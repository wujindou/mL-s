
@include('layout.header')

<div id="page-wrapper" class="gray-bg">
	<div class="row border-bottom">
		<nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
			@include('layout.banner')
		</nav>
	</div>
	<div class="wrapper wrapper-content">
		<div class="row">
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-success pull-right"></span>
						<h5>总数据量</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">
							{{ $total->atsum }}
						</h1>
						<div class="stat-percent font-bold text-success"><!--98%--> <i class="fa fa-bolt"></i></div>
						<small>Total</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-info pull-right">微信</span>
						<h5>文章数</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{ $articleCount }}</h1>
						<div class="stat-percent font-bold text-info"><!--98%--> <i class="fa fa-level-up"></i></div>
						<small>all</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-primary pull-right">ALL</span>
						<h5>收集公众号数</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{$accountCount}}</h1>
						<div class="stat-percent font-bold text-navy"><!--98%--><i class="fa fa-level-up"></i></div>
						<small>all</small>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<span class="label label-danger pull-right">ALL</span>
						<h5>总阅读数</h5>
					</div>
					<div class="ibox-content">
						<h1 class="no-margins">{{$total->readsum}}</h1>
						<div class="stat-percent font-bold text-danger"><!--98%--><i class="fa fa-level-down"></i></div>
						<small>all</small>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>近24小时数据</h5>
						<div class="pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-xs btn-white active" >按日统计</button>
								<button type="button" class="btn btn-xs btn-white" >按月统计</button>
							  @if(Session::has('user'))
								<button type="button" class="btn btn-xs btn-white">Annual</button>
            					@endif
							</div>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="flot-chart">
									<div class="flot-chart-content" id="flot-dashboard-chart"></div>
								</div>
							</div>
							<!--
							<div class="col-lg-1">
								<ul class="stat-list">
									<li>
										<h2 class="no-margins">{{$total->atsum}}</h2>
										<small>总数据量</small>
										<div class="stat-percent"><i class="fa fa-level-up text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 48%;" class="progress-bar"></div>
										</div>
									</li>
									<li>
										<h2 class="no-margins ">{{$articleCount}}</h2>
										<small>文章数</small>
										<div class="stat-percent">  <i class="fa fa-level-down text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 60%;" class="progress-bar"></div>
										</div>
									</li>
									<li>
										<h2 class="no-margins ">{{$total->readsum}}</h2>
										<small>总阅读数</small>
										<div class="stat-percent"> <i class="fa fa-bolt text-navy"></i></div>
										<div class="progress progress-mini">
											<div style="width: 82%;" class="progress-bar"></div>
										</div>
									</li>
								</ul>
							</div>
-->
						</div>
					</div>

				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-6">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>最新发文</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="feed-activity-list">
							@forelse($newList as $newarticle)
							<div class="feed-element">
								<strong>{{$newarticle->title}}</strong>
								<div>{{$newarticle->readnum}}次阅读 {{$newarticle->likenum}}个点赞</div>
								<small class="text-muted">{{$newarticle->lastModified}}</small>
							</div>
							@empty
							<p>没有最新发文</p>
							@endforelse
						</div>
					</div>
				</div>
			</div>

			<div class="col-lg-6">

				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>24小时最热发文</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<table class="table table-hover no-margins">
							<thead>
								<tr>
									<th>标题</th>
									<th>发文时间</th>
									<th>阅读数</th>
									<th>点赞数</th>
								</tr>
							</thead>
							<tbody>
								@forelse($hotList as $hotarticle)
								<tr>

									<td><small><a href="/article_statis?url={{urlencode($hotarticle->content_url)}}">{{$hotarticle->title}}</a></small></td>
									<td><i class="fa fa-clock-o"></i>{{$hotarticle->mindt}}</td>
									<td>{{$hotarticle->readnum}}</td>
									<td>{{$hotarticle->likenum}}</td>
								</tr>
								@empty
								<tr><td>没有最新发文<td></tr>
								@endforelse

							</tbody>
						</table>
					</div>
				</div>

			</div>


		</div>
	</div>
	<div class="footer">
		<div class="pull-right">
			10GB of <strong>250GB</strong> Free.
		</div>
		<div>
			<strong>Copyright</strong> Example Company &copy; 2014-2015
		</div>
	</div>
</div>
<div id="right-sidebar">
	<div class="sidebar-container">

		<ul class="nav nav-tabs navs-3">

			<li class="active"><a data-toggle="tab" href="#tab-1">
					Notes
				</a></li>
			<li><a data-toggle="tab" href="#tab-2">
					Projects
				</a></li>
			<li class=""><a data-toggle="tab" href="#tab-3">
					<i class="fa fa-gear"></i>
				</a></li>
		</ul>

		<div class="tab-content">


			<div id="tab-1" class="tab-pane active">

				<div class="sidebar-title">
					<h3> <i class="fa fa-comments-o"></i> Latest Notes</h3>
					<small><i class="fa fa-tim"></i> You have 10 new message.</small>
				</div>

				<div>

					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a1.jpg">

								<div class="m-t-xs">
									<i class="fa fa-star text-warning"></i>
									<i class="fa fa-star text-warning"></i>
								</div>
							</div>
							<div class="media-body">

								There are many variations of passages of Lorem Ipsum available.
								<br>
								<small class="text-muted">Today 4:21 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a2.jpg">
							</div>
							<div class="media-body">
								The point of using Lorem Ipsum is that it has a more-or-less normal.
								<br>
								<small class="text-muted">Yesterday 2:45 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a3.jpg">

								<div class="m-t-xs">
									<i class="fa fa-star text-warning"></i>
									<i class="fa fa-star text-warning"></i>
									<i class="fa fa-star text-warning"></i>
								</div>
							</div>
							<div class="media-body">
								Mevolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
								<br>
								<small class="text-muted">Yesterday 1:10 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a4.jpg">
							</div>

							<div class="media-body">
								Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the
								<br>
								<small class="text-muted">Monday 8:37 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a8.jpg">
							</div>
							<div class="media-body">

								All the Lorem Ipsum generators on the Internet tend to repeat.
								<br>
								<small class="text-muted">Today 4:21 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a7.jpg">
							</div>
							<div class="media-body">
								Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
								<br>
								<small class="text-muted">Yesterday 2:45 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a3.jpg">

								<div class="m-t-xs">
									<i class="fa fa-star text-warning"></i>
									<i class="fa fa-star text-warning"></i>
									<i class="fa fa-star text-warning"></i>
								</div>
							</div>
							<div class="media-body">
								The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
								<br>
								<small class="text-muted">Yesterday 1:10 pm</small>
							</div>
						</a>
					</div>
					<div class="sidebar-message">
						<a href="#">
							<div class="pull-left text-center">
								<img alt="image" class="img-circle message-avatar" src="img/a4.jpg">
							</div>
							<div class="media-body">
								Uncover many web sites still in their infancy. Various versions have.
								<br>
								<small class="text-muted">Monday 8:37 pm</small>
							</div>
						</a>
					</div>
				</div>

			</div>

			<div id="tab-2" class="tab-pane">

				<div class="sidebar-title">
					<h3> <i class="fa fa-cube"></i> Latest projects</h3>
					<small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
				</div>

				<ul class="sidebar-list">
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Business valuation</h4>
							It is a long established fact that a reader will be distracted.

							<div class="small">Completion with: 22%</div>
							<div class="progress progress-mini">
								<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
							</div>
							<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Contract with Company </h4>
							Many desktop publishing packages and web page editors.

							<div class="small">Completion with: 48%</div>
							<div class="progress progress-mini">
								<div style="width: 48%;" class="progress-bar"></div>
							</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Meeting</h4>
							By the readable content of a page when looking at its layout.

							<div class="small">Completion with: 14%</div>
							<div class="progress progress-mini">
								<div style="width: 14%;" class="progress-bar progress-bar-info"></div>
							</div>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="label label-primary pull-right">NEW</span>
							<h4>The generated</h4>
							<!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
							There are many variations of passages of Lorem Ipsum available.
							<div class="small">Completion with: 22%</div>
							<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Business valuation</h4>
							It is a long established fact that a reader will be distracted.

							<div class="small">Completion with: 22%</div>
							<div class="progress progress-mini">
								<div style="width: 22%;" class="progress-bar progress-bar-warning"></div>
							</div>
							<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Contract with Company </h4>
							Many desktop publishing packages and web page editors.

							<div class="small">Completion with: 48%</div>
							<div class="progress progress-mini">
								<div style="width: 48%;" class="progress-bar"></div>
							</div>
						</a>
					</li>
					<li>
						<a href="#">
							<div class="small pull-right m-t-xs">9 hours ago</div>
							<h4>Meeting</h4>
							By the readable content of a page when looking at its layout.

							<div class="small">Completion with: 14%</div>
							<div class="progress progress-mini">
								<div style="width: 14%;" class="progress-bar progress-bar-info"></div>
							</div>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="label label-primary pull-right">NEW</span>
							<h4>The generated</h4>
							<!--<div class="small pull-right m-t-xs">9 hours ago</div>-->
							There are many variations of passages of Lorem Ipsum available.
							<div class="small">Completion with: 22%</div>
							<div class="small text-muted m-t-xs">Project end: 4:00 pm - 12.06.2014</div>
						</a>
					</li>

				</ul>

			</div>

			<div id="tab-3" class="tab-pane">

				<div class="sidebar-title">
					<h3><i class="fa fa-gears"></i> Settings</h3>
					<small><i class="fa fa-tim"></i> You have 14 projects. 10 not completed.</small>
				</div>

				<div class="setings-item">
					<span>
						Show notifications
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example">
							<label class="onoffswitch-label" for="example">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Disable Chat
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" name="collapsemenu" checked class="onoffswitch-checkbox" id="example2">
							<label class="onoffswitch-label" for="example2">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Enable history
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example3">
							<label class="onoffswitch-label" for="example3">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Show charts
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example4">
							<label class="onoffswitch-label" for="example4">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Offline users
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example5">
							<label class="onoffswitch-label" for="example5">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Global search
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" checked name="collapsemenu" class="onoffswitch-checkbox" id="example6">
							<label class="onoffswitch-label" for="example6">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>
				<div class="setings-item">
					<span>
						Update everyday
					</span>
					<div class="switch">
						<div class="onoffswitch">
							<input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="example7">
							<label class="onoffswitch-label" for="example7">
								<span class="onoffswitch-inner"></span>
								<span class="onoffswitch-switch"></span>
							</label>
						</div>
					</div>
				</div>

				<div class="sidebar-content">
					<h4>Settings</h4>
					<div class="small">
						I belive that. Lorem Ipsum is simply dummy text of the printing and typesetting industry.
						And typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.
						Over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
					</div>
				</div>

			</div>
		</div>

	</div>



</div>
</div>

<!-- Mainly scripts -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="js/plugins/flot/jquery.flot.js"></script>
<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="js/plugins/flot/jquery.flot.spline.js"></script>
<script src="js/plugins/flot/jquery.flot.resize.js"></script>
<script src="js/plugins/flot/jquery.flot.pie.js"></script>
<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="js/plugins/peity/jquery.peity.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!--
<script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>

<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

<script src="js/demo/sparkline-demo.js"></script>

-->
<script>
$(document).ready(function () {
/**
	$('.chart').easyPieChart({
barColor: '#f8ac59',
//                scaleColor: false,
scaleLength: 5,
lineWidth: 4,
size: 80
});

$('.chart2').easyPieChart({
barColor: '#1c84c6',
//                scaleColor: false,
scaleLength: 5,
lineWidth: 4,
size: 80
});
 */

	function euroFormatter(v, axis) {
		return v.toFixed(axis.tickDecimals) + "";
	}


	showByDay();
	//doPlot(1463364206000,1463450606000,readnums,likenums,'right');
	function doPlot(min,max,readnums,likenums,position) {

		$.plot($("#flot-dashboard-chart"), [{
			data: readnums,
				label: "阅读数",
				points: { show: true },
				lines:{show:true}
		}, {
			data: likenums,
				label: "点赞数",
				yaxis: 2,
				position: "right",
				lines:{show:true},
				points: {show:true, symbol: "triangle"}
		}], {
			xaxes: [{
				timeformat: "%H:%M",
					mode: 'time',
					tickSize:[0.5,'hour'],
					min: min, // start of today
					max: max,
					timezone:"browser",
			}],
			yaxes: [{
				min: 0
			}, {
				// align if we are to the right
				// alignTicksWithAxis: position == "right" ? 1 : null,
				position:position, 
					tickFormatter: euroFormatter
			}],
			legend: {
				position: 'sw'
			},
			colors: ["#1ab394"],
			grid: {
				color: "#999999",
					hoverable: true,
					clickable: true,
					tickColor: "#D4D4D4",
					borderWidth:0,
					hoverable: true //IMPORTANT! this is needed for tooltip to work,

			},
			tooltip: true,
			tooltipOpts: {
				content: "%x %s 是  %y",
					xDateFormat: "%Y-%m-%d %H:%M",

					onHover: function(flotItem, $tooltipEl) {
						// console.log(flotItem, $tooltipEl);
					}
			}

		});
	}

	function doPlotMonth(min,max,readnums,likenums,position) {

		$.plot($("#flot-dashboard-chart"), [{
			data: readnums,
				label: "阅读数",
				points: { show: true },
				lines:{show:true}
		}, {
			data: likenums,
				label: "点赞数",
				yaxis: 2,
				position: "right",
				lines:{show:true},
				points: {show:true, symbol: "triangle"}
		}], {
			xaxes: [{
				timeformat: "%m-%d",
					mode: 'time',
					tickSize:[1,'day'],
					min: min, // start of today
					max: max,
					timezone:"browser",
			}],
			yaxes: [{
				min: 0
			}, {
				// align if we are to the right
				// alignTicksWithAxis: position == "right" ? 1 : null,
				position:position, 
					tickFormatter: euroFormatter
			}],
			legend: {
				position: 'sw'
			},
			colors: ["#1ab394"],
			grid: {
				color: "#999999",
					hoverable: true,
					clickable: true,
					tickColor: "#D4D4D4",
					borderWidth:0,
					hoverable: true //IMPORTANT! this is needed for tooltip to work,

			},
			tooltip: true,
			tooltipOpts: {
				content: "%x %s 是  %y",
					xDateFormat: "%Y-%m-%d %H:%M",

					onHover: function(flotItem, $tooltipEl) {
						// console.log(flotItem, $tooltipEl);
					}
			}

		});
	}

	/*var readnums = [[1463414400000,4945],[1463416200000,4945],[1463418000000,4978]];
	var likenums =[[1463414400000,79],[1463416200000,79],[1463418000000,79]]; 
	var min = 1463414400000;
	var max = 1463481000000;
	 */
	//doPlot(min,max,readnums,likenums,'right');

	function showByDay(){
		$.ajax({
			url:'/article/getStatisByDay',
				type:'get',
				dataType:'json',
				success:function(data){
					//var readnums = [[1463414400000,4945],[1463416200000,4945],[1463418000000,4978]];
					doPlot(data.min,data.max,data.readnums,data.likenums,'right');
				}

		});
	}
	function showByMonth(){
		$.ajax({
			url:'/article/getStatisByMonth',
				type:'get',
				dataType:'json',
				success:function(data){
					//var readnums = [[1463414400000,4945],[1463416200000,4945],[1463418000000,4978]];
					doPlotMonth(data.min,data.max,data.readnums,data.likenums,'right');
				}

		});
	}
	//showByDay();
	/*
	var dataset = [
	{
		label: "点赞数",
			data: data3,
			color: "#1ab394",
			bars: {
				show: true,
					align: "center",
					barWidth: 24 * 60 * 60 * 600,
					lineWidth: 0
			}

	}, {
		label: "阅读数",
			data: data2,
			yaxis: 2,
			color: "#464f88",
			lines: {
				lineWidth: 1,
					show: true,
					fill: true,
					fillColor: {
						colors: [{
							opacity: 0.2
						}, {
							opacity: 0.2
						}]
					}
			},
				splines: {
					show: false,
						tension: 0.6,
						lineWidth: 1,
						fill: 0.1
				},
	}
];
	 */
/*
	var options = {
		xaxis: {
			mode: "time",
				tickSize: [0.5, "hour"],
				tickLength: 0,
				axisLabel: "Hour",
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 24,
				axisLabelFontFamily: 'Arial',
				axisLabelPadding: 10,
				color: "#d5d5d5"
		},
		yaxes: [{
			position: "left",
				color: "#d5d5d5",
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 12,
				axisLabelFontFamily: 'Arial',
				axisLabelPadding: 3
		}, {
			position: "right",
				clolor: "#d5d5d5",
				axisLabelUseCanvas: true,
				axisLabelFontSizePixels: 12,
				axisLabelFontFamily: ' Arial',
				axisLabelPadding: 67
		}
	],
		legend: {
			noColumns: 1,
				labelBoxBorderColor: "#000000",
				position: "nw"
		},
		grid: {
			hoverable: false,
				borderWidth: 0
		}
	};
 */
	$('.btn-white').each(function(index){
		var that = $(this);
		$(this).click(function(){
			if(index==0){
				showByDay();	
			}
			if(index==1){
				showByMonth();	
			}
			if(that.attr('class').indexOf('active')==-1){
			$('.btn-white').each(function(t){
				 $(this).removeClass('active');	
			});
			that.addClass('active');
			}
			
		});	

	});

});
</script>
</body>
</html>
