<?php

namespace App\Http\Controllers;

use App\Models\Account;
use DB;
use Illuminate\Http\Request;
use Input;

class AccountController extends Controller {

    public function index() {
        $accounts = DB::select(DB::raw("SELECT t0.*,t1.tcount,t2.likesum,t2.readsum from t_account t0 LEFT JOIN (SELECT biz,count(*) as tcount from t_article "
                                . "group by biz) t1 on t0.biz=t1.biz "
                                . " LEFT JOIN (SELECT biz,sum(likenum) as likesum,sum(readnum) as readsum"
                                . "  from t_article_time group by biz) t2 on t0.biz=t2.biz  ORDER BY t1.tcount DESC"));
        return view('account_list', array(
            'accounts' => $accounts
                )
        );
    }

    public function detail(Request $request, $biz) {
        $accountInfo = Account::where('biz', '=', $biz)->get()->first();
        $count = \App\Models\BizArticle::select(DB::raw('sum(likenum) as likenum,sum(readnum) as readnum,sum(cus) as cus,count(url) as url'))->where('biz', '=', $biz)->get();
        $today = date('Y-m-d');
        $newArticles = DB::select(DB::raw("SELECT t.readnum,t.likenum,t.title,t.biz,FROM_UNIXTIME(t.lastModified) as mindt from t_article t where t.biz='{$biz}' and  DATE_FORMAT(FROM_UNIXTIME(lastModified),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') "));
        $articleList = DB::select(DB::raw("SELECT t0.content_url,t0.title,FROM_UNIXTIME(t0.lastModified) as mintime,t2.readnum,t2.likenum,t2.cus ,t0.content_url 
                                        from t_article t0
                                        LEFT JOIN v_articles_mm t2 on t2.url=t0.content_url where t0.biz='$biz'"));
        return view('account_detail', array(
            'accountInfo' => $accountInfo,
            'count' => $count[0],
            'newList' => $newArticles,
            'articleList' => $articleList
        ));
    }
	public function update(Request $request){
		$update = 'update t_account set ';
		if($request->file('file')){
			$origin = $request->file('file')->getClientOriginalName();
			$imageName =md5($origin).time() .'.'.$request->file('file')->getClientOriginalExtension();	
			$request->file('file')->move(base_path() . '/public/upload/', $imageName);
			$update .=  " img ='$imageName' ,";
		}
		if($request->input('name')){
			$update .=  " name='{$request->input('name')}',";
		}
		$update = trim($update,',');
		$update .=  " where biz='{$request->input('biz')}'";
		$res = DB::update($update);
		if($res){
			return response()->json(['code' => 1, 'message' => '更新成功']);
		}else{
			return response()->json(['code' => 0, 'message' => '更新失败']);
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
