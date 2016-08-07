<?php
namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Account;
use App\Models\ArticleTime;
use App\Models\BizArticle;
use DB;
use Auth;
use Session;
class IndexController extends Controller{
      
       public function index(){
           $articleCount = Article::count(); //文章总数
           $accountCount = Account::count(); //公众号数量
           $total = ArticleTime::select( DB::raw('count(*) as atsum,sum(likenum) as likesum,sum(readnum) as readsum'))->get();
           $newList = DB::select( DB::raw("SELECT * from t_article ORDER BY lastModified desc LIMIT 0,5 ") );
		   foreach($newList as &$article){
		  		$article->lastModified = date('Y-m-d H:i:s',$article->lastModified); 	 
		   }
           $hotList  =  DB::select( DB::raw("SELECT t.likenum,t.readnum,t.content_url,t.biz,FROM_UNIXTIME(t.lastModified) as mindt,t.title  from t_article t    where  FROM_UNIXTIME(t.lastModified)> (now() - INTERVAL 24 HOUR) order by readnum desc limit 0,10 ") );
           return view('index',
                      array(
                          'articleCount'=>$articleCount,
                          'accountCount'=>$accountCount,
                          'total'=>$total[0],
                          'newList'=>$newList,
                          'hotList'=>$hotList
                      )
                 );
       }
    
}
