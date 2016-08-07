<?php

namespace App\Http\Controllers;

use App\Models\Account;
use DB;
use Illuminate\Http\Request;
use Input;

class UserController extends Controller {

	public function index() {
		$users = DB::select(DB::raw("select *from t_admin where id>=1 order by id desc"));
		return view('admin/user_list', array(
			'users' => $users
		));
	}

	public function add(Request $request){
		$account = $request->input('account');		
		$res = DB::insert(
			'insert into `t_admin` (`account`) values (?)',array($account)
		);
		if($res){
			return response()->json(['code' => 1, 'message' => '更新成功']);
		}else{
			return response()->json(['code' => 0, 'message' => '添加失败']);
		}
	}
	public function update(Request $request){
		$update = 'update t_admin set ';
		if($request->input('account')){
			$update .=  " account='{$request->input('account')}',";
		}
		$update = trim($update,',');
		$update .=  " where id='{$request->input('id')}'";
		$res = DB::update($update);
		if($res){
			return response()->json(['code' => 1, 'message' => '更新成功']);
		}else{
			return response()->json(['code' => 0, 'message' => '更新失败']);
		}
	}
		public function delete(Request $request){
			$res =DB::table('t_admin')->where('id', '=', $request->input('id'))->delete();	
			if($res){
				return response()->json(['code' => 1, 'message' => '删除成功']);
			}else{
				return response()->json(['code' => 0, 'message' => '删除失败']);
			}
		}
		public function admindetail(Request $request, $biz) {
			if(!Session::has('userinfo')){
				return redirect()->intended('/admin/login');	
				exit;
			}
			$accountInfo = Account::where('biz', '=', $biz)->get()->first();
			$count = \App\Models\BizArticle::select(DB::raw('sum(likenum) as likenum,sum(readnum) as readnum,sum(cus) as cus,count(url) as url'))->where('biz', '=', $biz)->get();
			$today = date('Y-m-d');
			$newArticles = DB::select(DB::raw("SELECT t.readnum,t.likenum,t.title,t.biz,FROM_UNIXTIME(t.lastModified) as mindt from t_article t where t.biz='{$biz}' and  DATE_FORMAT(FROM_UNIXTIME(lastModified),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') "));
			$articleList = DB::select(DB::raw("SELECT t0.content_url,t0.title,FROM_UNIXTIME(t0.lastModified) as mintime,t2.readnum,t2.likenum,t2.cus ,t0.content_url 
				from t_article t0
				LEFT JOIN v_articles_mm t2 on t2.url=t0.content_url where t0.biz='$biz'"));
			return view('admin/account_detail', array(
				'accountInfo' => $accountInfo,
				'count' => $count[0],
				'newList' => $newArticles,
				'articleList' => $articleList
			));
		}


}
