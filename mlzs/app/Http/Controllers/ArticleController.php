<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Account;

class ArticleController extends Controller {

	public function index() {

	}

	public function statis(Request $request) {
		$url = $request->get('url');
		$article = Article::select('lastModified',DB::raw('FROM_UNIXTIME(lastModified) as mindt,title,biz'))->where('content_url', '=', $url)->get()->first();
        $accountInfo = Account::where('biz', '=', $article->biz)->get()->first();
		$createtime = $article->mindt;
		$publishtime = $article->lastModified;
		$endtime =  min(strtotime("+1 day", $publishtime), time() ) ;
		$interval = '+30 minutes';
		$data = array();
		$index = $publishtime;
		while($index <=$endtime){
			$data[] = array('datetime'=>$index,'time'=>date('Y-m-d H:i:s',$index),'readnum'=>0,'likenum'=>0); 	
			$index = strtotime($interval,$index);
		}
		#print_r($createtime );
		$statis = DB::select(DB::raw("SELECT  UNIX_TIMESTAMP(datetime) as datetime,readnum,likenum from t_article_time where url='$url' and datetime>='$createtime' order by datetime asc"));
		if(count($statis)>0){
			foreach($statis as $st){
				for($i=0;$i<count($data);$i++){
					if($data[$i]['datetime']>=$st->datetime){
						$data[$i]['readnum']= $st->readnum;
						$data[$i]['likenum']= $st->likenum;
						break;	
					}	
				}
			}	
		}
		for($i=1;$i<count($data);$i++){
			if($data[$i-1]['readnum']>$data[$i]['readnum']){
				$data[$i]['readnum'] = $data[$i-1]['readnum'];	
			}
			if($data[$i-1]['likenum']>$data[$i]['likenum']){
				$data[$i]['likenum'] = $data[$i-1]['likenum'];	
			}

		}
		$read = "[";
		$like = "[";
		foreach($data as $v){
			$read = $read . '[' . $v['datetime']*1000 . ',' . $v['readnum'] . '],';
			$like = $like . '[' . $v['datetime']*1000 . ',' . $v['likenum'] . '],';
		}
		$like = $like . '];';
		$read = $read . '];';
		return view('article_statis', array(
			'read' => $read,
			'like' => $like,
			'article'=> $article,
			'accountInfo'=> $accountInfo
		));
	}
	public function getStatisByDay(){
		$start = strtotime(date('Y-m-d'),time());	
		$interval = '+30 minutes';
		$endofday = strtotime('+1 day',$start);
		$endtime = min(strtotime('+1 day',$start),time());
		$index = $start;
		$temp = array();
		while($index <=$endtime){
			$data[] = array('datetime'=>$index,'time'=>date('Y-m-d H:i:s',$index),'readnum'=>0,'likenum'=>0); 	
			$temp[] = array('datetime'=>$index);
			$index = strtotime($interval,$index);
		}
		$statis = DB::select(DB::raw("select
			t.lastModified,t1.readnum as newreadnum,t1.likenum as newlikenum,t1.datetime,t.content_url
			from
			t_article  as t  join t_article_time  as t1 on t.content_url =t1.url
			where
			FROM_UNIXTIME(t.lastModified)> (now() - INTERVAL 24 HOUR) 
			and 	  
			t.lastModified<$endtime
			order by datetime asc,content_url asc  ;"));
		if(count($statis)>0){
			foreach($statis as $st){
				for($i=0;$i<count($data);$i++){
					if($i==0 && $st->datetime<$data[$i]['time']){
						$temp[$i][$st->content_url]['readnum'] =    $st->newreadnum;	
						$temp[$i][$st->content_url]['likenum'] =    $st->newlikenum;	
					}
					if($i!=0 && $data[$i]['time']>$st->datetime && $data[$i-1]['time']<=$st->datetime){
						$temp[$i-1][$st->content_url]['readnum'] =    $st->newreadnum;	
						$temp[$i-1][$st->content_url]['likenum'] =    $st->newlikenum;	
						break;
					}	
				}
			}	
		}
		for($i=0;$i<count($data);$i++){
			foreach(array_keys($temp[$i]) as $v){
				if($v!='datetime'){
					$data[$i]['readnum'] += $temp[$i][$v]['readnum'];	
					$data[$i]['likenum'] += $temp[$i][$v]['likenum'];	
				}	
			}	
		}	
		for($i=1;$i<count($data);$i++){
			if($data[$i]['datetime']<time()){
				if($data[$i-1]['readnum']>$data[$i]['readnum']){
					$data[$i]['readnum'] = $data[$i-1]['readnum'];	
				}
				if($data[$i-1]['likenum']>$data[$i]['likenum']){
					$data[$i]['likenum'] = $data[$i-1]['likenum'];	
				}
			}

		}
		$res = array();
		$res['min']  = $start*1000;
		$res['max']  = $endofday*1000;
		$res['readnums'] = array();
		$res['likenums'] = array();
		foreach($data as $d){
			$res['readnums'][] = array($d['datetime']*1000,$d['readnum']);		
			$res['likenums'][] = array($d['datetime']*1000,$d['likenum']);
		}
		die(json_encode($res));

	}

	public function getStatisByMonth(){
		$start = date('Y-m-d');
		$d = new \DateTime($start);
		$d->modify('first day of this month');
		$start = $d->format('Y-m-d');  
		$starttime = strtotime($start);
		$d = new \DateTime($start);
		$d->modify('last day of this month');
		$end = $d->format('Y-m-d');
		$endtime  = strtotime($end);
		$queryend = min(strtotime('+1 day',strtotime(date('Y-m-d'))),strtotime($end.' 23:59:59'));
		$data = array();
		$interval = '+1 day';
		$data = array();
		$index = $starttime;
		while($index <=$endtime){
			$data[] = array('datetime'=>$index,'time'=>date('Y-m-d H:i:s',$index),'readnum'=>0,'likenum'=>0); 	
			$index = strtotime($interval,$index);
		}
		$statis = DB::select(DB::raw("select  max(t1.readnum) as readnum,max(t1.likenum) as likenum ,date(t1.datetime) as datetime,t1.url from t_article as t0
			join t_article_time as t1 on t0.content_url =t1.url where t0.lastModified>={$starttime}  and t0.lastModified<={$queryend}  group by date(t1.datetime),t1.url order by date(t1.datetime) asc ;"));
		if(count($statis)>0){
			$begin = $statis[0]->datetime;
			$previous = array();
			foreach($statis as $k=>$obj){
				$previous[$obj->datetime][$obj->url]['readnum'] = $obj->readnum;
				$previous[$obj->datetime][$obj->url]['likenum'] = $obj->likenum;
			}	
			$visited =$previous[$begin];
			for($i=0;$i<count($data);$i++){
				if($data[$i]['datetime']> strtotime($begin) && array_key_exists(date('Y-m-d',$data[$i]['datetime']),$previous)){
					$urls = $previous[date('Y-m-d',$data[$i]['datetime'])];	
					foreach($visited as $k=>$v){
						if(!array_key_exists($k,$urls)){
							$urls[$k]['readnum'] = $v['readnum'];
							$urls[$k]['likenum'] = $v['likenum'];
						}	
					}
					$visited = $urls;
				}
				$readnum = 0 ;
				$likenum = 0 ;
				foreach($visited as  $k=>$v){
					$readnum = $readnum+$v['readnum'];	
					$likenum = $likenum+$v['likenum'];
				}
				$data[$i]['readnum'] = $readnum;
				$data[$i]['likenum'] = $likenum;

			}
			$res = array();
			$res['min']  = $starttime*1000;
			$res['max']  = strtotime("+1 day", $endtime)*1000;
			$res['readnums'] = array();
			$res['likenums'] = array();
			foreach($data as $d){
					if($d['datetime']<$queryend){
						$res['readnums'][] = array($d['datetime']*1000,$d['readnum']);		
						$res['likenums'][] = array($d['datetime']*1000,$d['likenum']);
					}
			}
			die(json_encode($res));


		}



	}

}
