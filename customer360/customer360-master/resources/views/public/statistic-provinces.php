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
                        <div id="gridContainer"></div>
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
    caption: 'Tên gói thầu',
    dataField: 'ten_goi_thau',
    width: 300,
    dataType: 'string',
    cellTemplate: function (container, options) {
        $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-packages')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Số TBMT',
    dataField: 'so_tbmt',
    dataType: 'string',
  }, {
    caption: 'Lĩnh vực',
    dataField: 'linh_vuc',
    dataType: 'string',
  }, {
    caption: 'Đơn vị trúng thầu',
    dataField: 'name_vi',
    dataType: 'string',
    cellTemplate: function (container, options) {
        $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?id=${options.data.id_competitor}`).attr('target', '_blank').appendTo(container);
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
  }, {
    caption: 'Ngày đóng/mở thầu',
    dataField: 'thoi_diem_dong_mo_thau',
    dataType: 'datetime',
    format: 'd/M/yyyy',
  }, {
    caption: 'Chỉ số đánh giá CNTT',
    dataField: 'score_service',
    dataType: 'number',
  }]);
</script>
@endsection