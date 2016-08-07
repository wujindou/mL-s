@include('layout.header')

<div id="page-wrapper" class="gray-bg">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layout.banner')
        </nav>
    </div>
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>关注的公众号列表</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.php">首页</a>
                </li>
                <li class="active">
                    <strong>公众号列表</strong>
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
                        <h5>所关注的公众号列表</h5>
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
                                    <th>总发文数</th>
                                    <th>总阅读数</th>
                                    <th>总点赞数</th>
                                    <th>查看文章列表</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($accounts as $account)
                                <tr class="gradeX">
                                    <td><a href="/account/{{$account->biz}}">{{$account->name}}</a></td>
                                    <td  class="center">{{$account->tcount}}</td>
                                    <td  class="center">{{$account->readsum}}</td>
                                    <td  class="center">{{$account->likesum}}</td>
                                    <td  class="center"><a href="/account/{{$account->biz}}">查看</a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td>没有公众号信息</td>
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
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="js/plugins/jeditable/jquery.jeditable.js"></script>

<!-- Data Tables -->
<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="js/plugins/dataTables/dataTables.responsive.js"></script>
<script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
$(document).ready(function () {
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


});

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

</html>
