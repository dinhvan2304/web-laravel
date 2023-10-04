@extends('layouts.template')

@section('title','DS HKD&Doanh nghiệp')
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
                            <a class="nav-link active" data-toggle="tab" href="#list" role="tab" aria-controls="home" aria-selected="true">Danh sách chung</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnptioffice" role="tab" aria-controls="home" aria-selected="true">VNPT iOffice</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnedu" role="tab" aria-controls="home" aria-selected="true">VNPT Edu</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnptigate" role="tab" aria-controls="home">VNPT IGate</a>
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
LoadDxDataGridSource("#gridContainer", "{{url('/api/user-vnptthuebao')}}", [{
    caption: 'Tên thuê bao',
    dataField: 'name',
    dataType: 'string',
  }, {
    caption: 'Số điện thoại',
    dataField: 'phone',
    dataType: 'string',
  }, {
    caption: 'Địa chỉ',
    dataField: 'address',
    dataType: 'string',
  }, {
    caption: 'Nhà mạng',
    dataField: 'isp',
    dataType: 'string'
  }, {
    caption: 'Loại',
    dataField: 'type',
    dataType: 'string'
  }, {
    caption: 'Dịch vụ',
    dataField: 'service',
    dataType: 'string',
  }, {
    caption: 'Tỉnh',
    dataField: 'city',
    dataType: 'string',
  }]);
  function changeTab(target = "#list"){
    dataGrid = $("#gridContainer").dxDataGrid("instance");
    if(target == "#list"){
      dataGrid.clearFilter();
    }else if(target == "#vnptioffice"){
      dataGrid.filter(["service", "=", 'ioffice']);
    }else if(target == "#vnedu"){
      dataGrid.filter(["service", "=", 'vnedu']);
    }else if(target == "#vnptigate"){
      dataGrid.filter(["service", "=", 'igate']);
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