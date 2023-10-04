@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">Danh sách</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <!-- right column -->
          <div class="row">
               @include('layouts.includes.alerts')
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#packages" role="tab" aria-controls="home" aria-selected="true">Danh sách chung</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packages-7day" role="tab" aria-controls="packages" aria-selected="false">DS gói thầu CNTT 7 ngày gần nhất</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packages-1month" role="tab" aria-controls="packages" aria-selected="false">DS gói thầu CNTT 1 tháng gần nhất</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packages-3month" role="tab" aria-controls="packages" aria-selected="false">DS gói thầu CNTT 3 tháng gần nhất</a>
                          </li>
                        </ul>
                        <div id="gridContainer" ></div>
                      </div>
                    </div>
                  <!-- /.card-body -->
                </div>
              </div>
            </div>
			    </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection



@section('script')
<script>
LoadDxDataGridSource("#gridContainer", "{{url('/api/user-packages')}}", [{
    type: "buttons",
    buttons: [{
      hint: 'Theo dõi',
      icon: 'favorites',
      onClick(e) {
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: true,
            url: `/api/favorites?type=packages&so_tbmt=${e.row.data.so_tbmt}`,
            success: function (result) {
              
            }
        });
      },
    }]
  },{
  caption: 'Tên gói thầu',
  dataField: 'ten_goi_thau',
  width: 300,
  dataType: 'string',
  cellTemplate: function (container, options) {
      if(options.value == null){
        return;
      }
      $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-packages')}}?so_tbmt=${options.data.so_tbmt}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Số TBMT',
    dataField: 'so_tbmt',
    dataType: 'string',
    sortOrder: 'desc',
  }, {
    caption: 'Loại gói',
    dataField: 'package_type',
    dataType: 'string',
  }, {
    caption: 'Hình thức',
    dataField: 'hinh_thuc_lcnt',
    dataType: 'string',
  }, {
    caption: 'Lĩnh vực',
    dataField: 'linh_vuc',
    dataType: 'string',
  }, {
    caption: 'Bên mời thầu',
    dataField: 'company_name',
    width: 200,
    dataType: 'string',
    cellTemplate: function (container, options) {
        if(options.value == null){
          return;
        }
        $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-clients')}}?mst=${options.data.mst_client}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Đơn vị trúng thầu',
    dataField: 'name_vi',
    dataType: 'string',
    cellTemplate: function (container, options) {
        if(!options.data.id_competitor){
          return;
        }
        $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?mst=${options.data.mst_competitor}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Trạng thái',
    dataField: 'trang_thai',
    lookup: {
        dataSource: {
            store: {
                type: 'array',
                data: [
                    { id: 0, name: 'Chưa đóng' },
                    { id: 1, name: 'Đã đóng' },
                ],
                key: "id"
            },
        },
        valueExpr: 'id', // contains the same values as the "statusId" field provides
        displayExpr: 'name' // provides display values
    }
  }, {
    caption: 'Địa điểm thực hiện',
    dataField: 'dia_diem_thuc_hien',
    dataType: 'string',
  }, {
    caption: 'Địa điểm bên mời thầu',
    dataField: 'city',
    dataType: 'string',
  }, {
    caption: 'Giá dự toán',
    dataField: 'gia_du_toan',
    dataType: 'number',
    format: 'currency',
  }, {
    caption: 'Giá trúng thầu',
    dataField: 'gia_trung_thau',
    dataType: 'number',
    format: 'currency',
  }, {
    caption: 'Ngày phát hành',
    dataField: 'nhan_e_hsdt_tu_ngay',
    dataType: 'datetime',
    format: 'd/M/yyyy',
    calculateFilterExpression: filterDateYYYYMMDD,
  }, {
    caption: 'Ngày đóng/mở thầu',
    dataField: 'thoi_diem_dong_mo_thau',
    dataType: 'datetime',
    format: 'd/M/yyyy',
    calculateFilterExpression: filterDateYYYYMMDD,
  }]);
  function changeTab(target = "#packages"){
    dataGrid = $("#gridContainer").dxDataGrid("instance");
    if(target == "#packages-3month"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(3, 'months').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
    }else if(target == "#packages-1month"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(1, 'months').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
    }else if(target == "#packages-7day"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(7, 'days').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
    }else{
      dataGrid.clearFilter();
    }
  }
  $(function() {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
      var target = $(e.target).attr("href") // activated tab
      changeTab(target);
    });
    changeTab();
  });
</script>
@endsection