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
                            <a class="nav-link active" data-toggle="tab" href="#list" role="tab" aria-controls="home" aria-selected="true">Danh sách chung</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnpt" role="tab" aria-controls="home">Danh sách KH VNPT</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tiemnang" role="tab" aria-controls="home" >Danh sách tiềm năng</a>
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
LoadDxDataGridSource("#gridContainer", "{{url('/api/user-smes')}}", [{
  caption: 'Mã số thuế',
  dataField: 'mst',
  width: 300,
  dataType: 'string',
  cellTemplate: function (container, options) {
      if(options.value == null){
        return;
      }
      $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-smes')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Tên',
    dataField: 'vi_name',
    dataType: 'string',
  }, {
    caption: 'Người quản lý',
    dataField: 'manager_name',
    dataType: 'string',
  }, {
    caption: 'ID Người quản lý',
    dataField: 'manager_id',
    dataType: 'string',
  }, {
    caption: 'Miền',
    dataField: 'province',
    dataType: 'string',
  }, {
    caption: 'Tỉnh/Thành phố',
    dataField: 'city',
    dataType: 'string',
  }, {
    caption: 'Huyện/xã',
    dataField: 'district',
    dataType: 'string',
  }, {
    caption: 'Địa chỉ kinh doanh',
    dataField: 'manager_addr',
    dataType: 'string',
  }, {
    caption: 'Ngày thành lập',
    dataField: 'created_date',
    dataType: 'date',
  }]);
  function changeTab(target = "#list"){
    dataGrid = $("#gridContainer").dxDataGrid("instance");
    dataGrid.clearFilter();
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