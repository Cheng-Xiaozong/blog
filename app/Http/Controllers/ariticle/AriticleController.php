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


    }

    //更改头像
    public function updatePt()
    {
        if($this->request->isMethod('post'))
        {
            $file=$this->request->file('portrait');
            //文件是否上传成功
            if($file->isValid())
            {
                // 获取文件相关信息
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;// 生成的文件名
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('user_portrait')->put($filename, file_get_contents($realPath));
                if($bool){
                    return $this->savePt($filename);
                }
            }
        }
        return view('ariticle.updatePt');
    }

    //保存头像
    public function savePt($filename)
    {
        return $this->user::updatePt($filename) ? $filename : '上传失败！';
    }

}
