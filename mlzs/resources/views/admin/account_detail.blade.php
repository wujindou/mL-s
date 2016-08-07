@include('layout.header') 
<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('layout.banner') 
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>{{$accountInfo->name}}的公众号主页</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">首页</a>
                        </li>
                        <li class="active">
                            <strong>公众号列表</strong>
                        </li>
                        <li class="active">
                            <strong>公众号主页</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
		<div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>公众号简介</h5>
                        </div>
                        <div>
                            <div class="ibox-content  border-left-right">
                                <img alt="image" class="img-responsive" src="/mlzs/public/ewimg/{{$accountInfo->biz}}.jpg">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>{{$accountInfo->name}}</strong></h4>
                             <!--   <p><i class="fa fa-map-marker"></i> Riviera State 32/106</p>
                                <h5>
                                    About me
                                </h5>-->
                                <p>
                                    公众号简介
                                </p>
                                <div class="row m-t-lg">
									
                                    <div class="col-md-4">
                                        <h5><strong>{{$count->url}}</strong> 发文</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><strong>{{$count->readnum}}阅读</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h5><strong>{{$count->likenum}}点赞</h5>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>当天发文</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <!--<ul class="dropdown-menu dropdown-user">
                                    <li><a href="#">Config option 1</a>
                                    </li>
                                    <li><a href="#">Config option 2</a>
                                    </li>
                                </ul>-->
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">

                            <div>
                                <div class="feed-activity-list">
                                    @forelse($newList as $newarticle)
                                    <div class="feed-element">
                                        <div class="media-body ">
                                            <small class="pull-right">{{$newarticle->mindt}}</small>
                                            <strong>{{$newarticle->title}}</strong>
                                            <small class="text-muted">{{$newarticle->readnum}}次阅读{{$newarticle->likenum}}个点赞</small>
                                        </div>
                                    </div>
                                    @empty
                                    <p>今日没有发文</p>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>{{$accountInfo->name}}的历史发文列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>公众号名称</th>
                        <th>文章标题</th>						
                        <th>发文时间</th>
                        <th>当前阅读数</th>
                        <th>当前点赞数</th>
                        <th>采集次数</th>
                        <th>查看时间变化</th>
                    </tr>
                    </thead>
                    <tbody>
                           @forelse($articleList as $article)
                                   <tr class="gradeX">
                            <td>{{$accountInfo->name}}</td>
                            <td><a href="{{$article->content_url}}" target="_blank" >{{$article->title}}</a></td>
                            <td>{{$article->mintime}}</td>						
                            <td  class="center">{{$article->readnum}}</td>	
                            <td  class="center">{{$article->likenum}}</td>
                            <td  class="center">{{$article->cus}}</td>
                            <td  class="center"><a href="/article_statis?url={{urlencode($article->content_url)}}">查看时间变化</a></td>
                             </tr>
                                    @empty
                                    <tr><td>没有历史发文</td></tr>
                                    @endforelse
				<?php
//				$sql = "SELECT t0.content_url,t0.title,FROM_UNIXTIME(t0.lastModified) as mintime,t2.readnum,t2.likenum,t2.cus ,t0.content_url 
//from t_article t0
//LEFT JOIN v_articles_mm t2 on t2.url=t0.content_url
//where t0.biz='$biz'";	//获取公众号列表
//				$ids = DAO::getRowsArray($sql);
////			print_r($ids);exit;
//					foreach($ids as  $idn=>$idv){
//						echo '<tr class="gradeX">';
//						echo '<td>'.$bizinfo['name'].'</td>';
//						echo '<td><a href="'.$idv["content_url"].'" target="_blank" >'.$idv["title"].'</a></td>';
//						echo '<td>'.$idv["mintime"].'</td>';						
//						echo '<td  class="center">'.$idv["readnum"].'</td>';		
//						echo '<td  class="center">'.$idv["likenum"].'</td>';	
//						echo '<td  class="center">'.$idv["cus"].'</td>';
//						echo '<td  class="center"><a href="page_show.php?url='.urlencode($idv["content_url"]).'">查看时间变化</a></td>';
//						echo '</tr>';
//					}
				?>
                    </tbody>
<!--                    <tfoot>
                    <tr>
                        <th>公众号名称</th>
                        <th>文章标题</th>						
                        <th>发文时间</th>
                        <th>当前阅读数</th>
                        <th>当前点赞数</th>
                        <th>采集次数</th>
                        <th>查看文章列表</th>
                    </tr>
                    </tfoot>-->
                    </table>
                    </div>
                </div>
            </div>
            </div>
            <div class="row">
            </div>
        </div>
            @include('layout.footer')

        </div>
        </div>



 

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
               // "dom": 'T<"clear">lfrtip',
//                "tableTools": {
//                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
//                }
            });

        


        });
    </script>
<style>
    body.DTTT_Print {
        background: #fff;

    }
    .DTTT_Print #page-wrapper {
        margin: 0;
        background:#fff;
    }

    button.DTTT_button, div.DTTT_button, a.DTTT_button {
        border: 1px solid #e7eaec;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }
    button.DTTT_button:hover, div.DTTT_button:hover, a.DTTT_button:hover {
        border: 1px solid #d2d2d2;
        background: #fff;
        color: #676a6c;
        box-shadow: none;
        padding: 6px 8px;
    }

    .dataTables_filter label {
        margin-right: 5px;

    }
</style>
</body>

</html>
