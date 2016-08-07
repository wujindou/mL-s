<?php

namespace App\Http\Controllers;

use App\Models\Account;
use DB;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Redirect;
class AdminController extends Controller {


	public function index(){
		if(!Session::has('userinfo')){
			return redirect()->intended('/admin/login');	
			exit;
		}
        $accounts = DB::select(DB::raw("SELECT t0.*,t1.tcount,t2.likesum,t2.readsum from t_account t0 LEFT JOIN (SELECT biz,count(*) as tcount from t_article "
                                . "group by biz) t1 on t0.biz=t1.biz "
                                . " LEFT JOIN (SELECT biz,sum(likenum) as likesum,sum(readnum) as readsum"
                                . "  from t_article_time group by biz) t2 on t0.biz=t2.biz  ORDER BY t1.tcount DESC"));
        return view('admin/account', array(
            'accounts' => $accounts
                )
        );

		return view('admin/dashboard');
	}
	public function getLogin(){
	    return view('admin/login');

	}
	public function postLogin(Request $request) {
		$username = $request->input('username');
		$password = $request->input('password');
		if ($username!='admin' || $password!='123456')
		{
			return Redirect::to('admin/login')->withErrors(array('msg' =>'用户名或密码错误'))->withInput();
		}else{
			$user =array('username'=>'mlzs2016','password'=>'Mlzs20160518');
			print_r('wwwww');
			Session::put('userinfo',$user);
			return redirect()->intended('/admin/index');	
		}
	}
	public function logout(){
		Session::forget('userinfo');	
		return redirect()->intended('admin/login');	
	}
}
