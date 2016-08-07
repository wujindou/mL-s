@include('layout.header')
<div id="page-wrapper" class="gray-bg">
		<div class="row border-bottom">
		<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
		@include('layout.banner')
		</nav>
		</div>
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>{{$article->title}}</h2>
					<ol class="breadcrumb">
						<li>
							<a href="/">主页</a>
						</li>
						<li>
							<a href="/account/{{$accountInfo->biz}}">{{$accountInfo->name}}</a>
						</li>
						<li class="active">
							<strong>时间趋势</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">

				</div>
			</div>
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>时间变化趋势图 </h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<i class="fa fa-wrench"></i>
								</a>
								<ul class="dropdown-menu dropdown-user">
									<li><a href="#">Config option 1</a>
									</li>
									<li><a href="#">Config option 2</a>
									</li>
								</ul>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">
							<div class="flot-chart">
								<div class="flot-chart-content" id="flot-line-chart-multi"></div>
							</div>
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
		</div>



	<!-- Mainly scripts -->
	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Flot -->
	<script src="js/plugins/flot/jquery.flot.js"></script>
	<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
	<script src="js/plugins/flot/jquery.flot.resize.js"></script>
	<script src="js/plugins/flot/jquery.flot.symbol.js"></script>
	<script src="js/plugins/flot/jquery.flot.pie.js"></script>
	<script src="js/plugins/flot/jquery.flot.time.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="js/inspinia.js"></script>
	<script src="js/plugins/pace/pace.min.js"></script>

	<!-- Flot demo data -->
<script>


$(function() { //date_to_unixtime
	//var oilprices = [ [1167692400000, 61.05], [1167778800000, 58.32]];
	//var exchangerates = [ [1167692400000, 0.7580], [1167778800000, 0.7580]];
	//var oilprices = [ [1461474000000, 61.05], [1461477600000, 58.32]];
	//var exchangerates = [ [1461474000000, 0.7580], [1461477600000, 0.7580]];


	var readnums ={{$read}}
	var likenums={{$like}}
	var min = readnums[0][0];
	var max =readnums[readnums.length-1][0];

		function euroFormatter(v, axis) {
			return v.toFixed(axis.tickDecimals) + "";
		}
	function doPlot(position) {
		$.plot($("#flot-line-chart-multi"), [{
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
				position: position,
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
				content: "%s 是  %y",
					xDateFormat: "%y-%0m-%0d",

					onHover: function(flotItem, $tooltipEl) {
						// console.log(flotItem, $tooltipEl);
					}
			}

		});
	}

	doPlot("right");

	$("button").click(function() {
		doPlot($(this).text());
	});
});


</script>

</body>

</html>
