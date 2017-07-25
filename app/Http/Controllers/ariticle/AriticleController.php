<?php

namespace App\Http\Controllers\Ariticle;

use App\Ariticle;
use App\Repositories\AriticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AriticleController extends Controller
{
    protected $request;
    protected $ariticle;
    protected $user;
    public function __construct(Request $request,AriticleRepository $ariticle,UserRepository $user)
    {
        $this->request=$request;
        $this->ariticle = $ariticle;
        $this->user = $user;
    }

    //首页
    public function index()
    {
        $data['newAriticle']=$this->ariticle->newAriticle();
        $data['ariticles']=$this->ariticleList();
        return view('ariticle.index',$data);
    }

    //指定文章页
    public function detail($id)
    {
        $data['newAriticle']=$this->ariticle->getAriticleById($id);
        $data['ariticles']=$this->ariticleList();
        if($data['newAriticle'])
        {
            $this->ariticle->addAriticleViews($id);
            return view('ariticle.index',$data);
        }else{
            return view('errors.404');
        }
    }

    //我的博客详情
    public function myAriticleDetail($id)
    {
        $data['userInfo']=$this->user::getUserById($this->user::getUserId());
        $data['newAriticle']=$this->ariticle->getAriticleById($id);
        return view('ariticle.myAriticleDetail',$data);
    }

    //文章列表
    public function ariticleList()
    {
        return $this->ariticle->ariticleList(8);
    }

    //我的博客
    public function myblog()
    {
        $data['userInfo']=$this->user::getUserById($this->user::getUserId());
        $data['ariticles']=$this->ariticle::getAriticleByUserId($this->user::getUserId(),2);
        return view('ariticle.myblog',$data);
    }

    //参数验证
    public function verificationData()
    {
        $this->validate($this->request, [
            'ariticle.title' => 'required',
            'ariticle.content' => 'required',
        ], [
            'required' => ':attribute 为必填项',
        ], [
            'ariticle.title' => '标题',
            'ariticle.content' => '内容'
        ]);
    }

    //发表博客
    public function create()
    {
        if($this->request->isMethod('post'))
        {
           $this->verificationData();
           $data=$this->request->input('ariticle');
           $data['user_id']=$this->user::getUserId();
           $data['status']=Ariticle::ARITICLE_STATUS_ENABLE;
           $result=$this->ariticle::create($data);
           if($result){
               return redirect('/')->with('success','发表成功！');
           }else{
               return redirect()->back()->with('error','发表失败！');
           }
        }
        return view('ariticle.create');
    }

    //删除博客
    public function delete($id)
    {
        $result=$this->ariticle->delete($id);
        if($result){
            return redirect('/myblog')->with('success','删除成功！');
        }else{
            return redirect()->back()->with('error','删除失败！');
        }
    }

    //编辑博客
    public function edit($id)
    {
        if($this->request->isMethod('post')){
            $this->verificationData();
            $result=$this->ariticle->edit($id,$this->request->input('ariticle'));
            if($result>0){
                return redirect('/myblog')->with('success','编辑成功！');
            }else{
                return redirect()->back()->with('error','编辑失败！');
            }
        }
        $data['ariticle']=$this->ariticle::getAriticleById($id);
        return view('ariticle.edit',$data);
    }

    //博客点赞
    public function praise()
    {
        $validator = \Validator::make($this->request->input(), [
            'ariticle_id' => 'required|min:2|max:20',
        ], [
            'required' => ':attribute 为必填项',
            'integer' => ':attribute 不合法'
        ], [
            'ariticle_id' => '文章ID'
        ]);
        if ($validator->fails()) {
            return ajaxReturn(-2,'非法参数',$validator->errors());
        }
        $result=$this->ariticle::ariticlePraise($this->user::getUserId(),$this->request->input('ariticle_id'));
        switch ($result)
        {
            case 'success':
                return ajaxReturn(1,'点赞成功');
            case 'error':
                return ajaxReturn(-1,'点赞失败');
            case 'repetition':
                return ajaxReturn(0,'不能重复点赞');
        }
    }

    //更改头像
    public function updatePt()
    {
        if($this->request->isMethod('post'))
        {
            $file=$this->request->file('portrait');
            if(empty($file)) return ajaxReturn(0,'文件不能为空');
            //文件是否上传成功
            if($file->isValid())
            {
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;// 生成的文件名
                // 使用我们新建的uploads本地存储空间（目录）
                $savePt = Storage::disk('user_portrait')->put($filename, file_get_contents($realPath));
                if($savePt){
                    $fileUrl='home/user_portrait/'.$filename;
                    $result=$this->user::updatePt($fileUrl);
                    return $result ? ajaxReturn(1,'头像上传成功',$fileUrl) : ajaxReturn(-3,'文件保存失败！');
                }else{
                    return ajaxReturn(-2,'文件保存失败');
                }
            }else{
                return ajaxReturn(-1,'头像上传失败，超出大小限制');
            }
        }
        return view('ariticle.updatePt');
    }

    //修改个人信息
    public function updateMyInfo()
    {
        $validator = \Validator::make($this->request->input(), [
            'User.name' => 'required|min:2|max:20',
            'User.sex' => 'required|integer',
            'User.hobby' => 'required',
            'User.signature' => 'required',
            'User.details' => 'required',
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'integer' => ':attribute 必须为整数',
        ], [
            'User.name' => '姓名',
            'User.sex' => '性别',
            'User.hobby' => '爱好',
            'User.signature' => '个性签名',
            'User.details' => '自我评价',
        ]);
        if ($validator->fails()) {
            return ajaxReturn(0,'参数错误',$validator->errors());
        }
        $data=$this->request->input('User');
        $result=$this->user::updateMyInfo($data);
        if($result>=1){
            return ajaxReturn(1,'修改成功！');
        }else{
            return ajaxReturn(-1,'修改失败！');
        }
    }



}
