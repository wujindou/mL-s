@include('adminlayout.header')


<div id="page-wrapper" class="gray-bg">
	<div class="row border-bottom">
		<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
			@include('adminlayout.banner')
		</nav>
	</div>
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2>授权用户列表</h2>
			<ol class="breadcrumb">
				<li>
					<a href="/account/index">首页</a>
				</li>
				<li class="active">
					<strong>用户列表</strong>
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
						<h5>所关注的公众号列表</h5> &nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="add" class="btn btn-sm btn-primary m-t-n-xs"><strong>添加</strong></button>
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
									<th>学工号</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								@forelse($users as $k=>$account)
								<tr class="gradeX">
									<td  class="center">{{$account->account}}</td>
									<td  class="center"><a href="javascript:modifyproduct({{$account->id}});" id="{{$account->id}}"  account="{{$account->account}}" >修改</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:deleteproduct({{$account->id}});" >删除</a></td>
								</tr>
								@empty
								<tr>
									<td>没有用户信息</td>
								<tr>
									@endforelse
							</tbody>
		<!--                    <tfoot>
							<tr>
								<th>公众号名称</th>
								<th>总发文数</th>
								<th>总阅读数</th>
								<th>总点赞数</th>
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
	<div class="footer">
		<!--            <div class="pull-right">
						10GB of <strong>250GB</strong> Free.
					</div>-->
		<div>
			<strong>Copyright</strong> Example Company &copy; 2014-2015
		</div>
	</div>

</div>
</div>



<!-- Mainly scripts -->
<script src="{{ url::asset('js/jquery-2.1.1.js')}}"></script>
<script src="{{ url::asset('js/bootstrap.min.js')}}"></script>
<script src="{{ url::asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{ url::asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{ url::asset('js/plugins/jeditable/jquery.jeditable.js')}}"></script>

<!-- Data Tables -->
<script src="{{ url::asset('js/plugins/dataTables/jquery.dataTables.js')}}"></script>
<script src="{{ url::asset('js/plugins/dataTables/dataTables.bootstrap.js')}}"></script>
<script src="{{ url::asset('js/plugins/dataTables/dataTables.responsive.js')}}"></script>
<script src="{{ url::asset('js/plugins/dataTables/dataTables.tableTools.min.js')}}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ url::asset('js/inspinia.js')}}"></script>
<script src="{{ url::asset('js/plugins/pace/pace.min.js')}}"></script>

<!-- Page-Level Scripts -->
<script>
$(document).ready(function () {
	$('#add').click(function(){
		$('#op').val('add');	
		$('#uploadForm')[0].reset();
		$('#myModal').modal('show');
	});
	$('.dataTables-example').dataTable({
		responsive: true,
			//                "dom": 'T<"clear">lfrtip',
			//                "tableTools": {
			//                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
			//                }
	});
	//
	//            /* Init DataTables */
	//            var oTable = $('#editable').dataTable();
	//
	//            /* Apply the jEditable handlers to the table */
	//            oTable.$('td').editable( '../example_ajax.php', {
	//                "callback": function( sValue, y ) {
	//                    var aPos = oTable.fnGetPosition( this );
	//                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
	//                },
	//                "submitdata": function ( value, settings ) {
	//                    return {
	//                        "row_id": this.parentNode.getAttribute('id'),
	//                        "column": oTable.fnGetPosition( this )[2]
	//                    };
	//                },
	//
	//                "width": "90%",
	//                "height": "100%"
	//            } );
	 $.ajaxSetup({
		         headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
					     });
	$('#submit').click(function(){
		var data = {};
		var op = $('#op').val();
		var url = op =="add" ? "/user/add":"/user/update";
		data.account = $("input[name=account]").val();
		if(op!="add"){
		 data.id = $('#hiddenid').val();	
		}
		$.ajax({
				url: url,
				type: 'POST',
				cache: false,
				data: data,
				success:function(res){
					if(res.code==1){
						$('#myModal').modal('hide');
						alert(res.message);	
						window.location.reload();
					}else{
						alert(res.message);	
					}
				},
				error:function(res){
					
				}

	});
	});


});
function deleteproduct(id){
	$.ajax({
		url:'/user/delete',
		type:'post',
		data:{id:id},
		dataType:'json',
		success:function(res){
			if(res.code==1){
				alert(res.message);
				window.location.reload();
			}else{
				alert(res.message);	
			}	
		}

	});

}
function modifyproduct(id){
	var that = $('#'+id);
	 $('#hiddenid').val(id);
	 $('#op').val('modify');
	 $("input[name=account]").val(that.attr("account"));
	$('#myModal').modal('show');
}

function fnClickAddRow() {
	$('#editable').dataTable().fnAddData([
		"Custom row",
		"New row",
		"New row",
		"New row",
		"New row"]);

}
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
<div class="modal inmodal in" id="myModal" tabindex="-1" role="dialog" aria-hidden="false" style="display: hidden;">
								<div class="modal-dialog">
								<div class="modal-content animated bounceInRight">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title">编辑授权用户信息</h4>
											<!--<small class="font-bold">微信公众号修改</small>-->
										</div>
										<div class="modal-body">
				 						<input type="hidden" name="_token" value="{{ csrf_token() }}">
				 						<input type="hidden" id="hiddenid" value=""/>
										<input type="hidden" id="op" value="add"/>
										<form id="uploadForm" >
											<div class="form-group">
											<label>学工号</label> 
											<input name="account"  type="text" class="form-control">
											</div>
										</form>
										<div class="modal-footer">
											<button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
											<button type="button" id="submit" class="btn btn-primary">保存</button>
										</div>
									</div>
								</div>
</div>

</html>
