@extends('layouts.template')

@section('title','Dashboard')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách gói thầu có khả năng thầu lại</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('app.dashboard')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @include('layouts.includes.alerts')
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div id="gridContainer" ></div>
                      </div>
                    </div>
                  <!-- /.card-body -->
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
LoadDxDataGridSource("#gridContainer", "{{url('/api/user-packages-rejoin')}}", [{
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
  }, {
    caption: 'Chỉ số đánh giá CNTT',
    dataField: 'score_service',
    dataType: 'number',
  }]);
  function changeTab(target = "#packages"){
    dataGrid = $("#gridContainer").dxDataGrid("instance");
    if(target == "#packages-3month"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(3, 'months').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
    }else if(target == "#packages-1month"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(1, 'months').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
    }else if(target == "#packages-7day"){
      dataGrid.filter([["nhan_e_hsdt_tu_ngay", ">=", `${moment().subtract(1, 'days').format("YYYYMMDD")}`],"and",["score_service", ">", 0.4]]);
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