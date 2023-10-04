@extends('layouts.template')

@section('title','Kế hoạch lựa chọn nhà thầu')
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
                            <a class="nav-link active" data-toggle="tab" href="#plans" role="tab" aria-controls="home" aria-selected="true">Danh sách kế hoạch LCNT</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packages" role="tab" aria-controls="packages" aria-selected="false">DS gói thầu trong kế hoạch</a>
                          </li>
                        </ul>
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
  function changeTab(target = "#plans"){
    if(target == "#plans"){
      LoadDxDataGridSource("#gridContainer", "{{url('/api/user-plans')}}", [{
        caption: 'Tên KHLCNT',
        dataField: 'ten_khlcnt',
        width: 300,
        dataType: 'string',
        cellTemplate: function (container, options) {
            if(options.value == null){
              return;
            }
            $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-plans')}}?so_khlcnt=${options.data.so_khlcnt}`).attr('target', '_blank').appendTo(container);
        }
      }, {
        caption: 'Số KHLCNT',
        dataField: 'so_khlcnt',
        dataType: 'string',
      }, {
        caption: 'Tên bên mời thầu',
        dataField: 'ben_moi_thau',
        dataType: 'string',
      },{
        caption: 'Tên đơn vị lập KHLCNT',
        dataField: 'company_name',
        width: 300,
        dataType: 'string',
        cellTemplate: function (container, options) {
            if(options.value == null){
              return;
            }
            $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-clients')}}?mst=${options.data.mst_client}`).attr('target', '_blank').appendTo(container);
        }
      }, {
        caption: 'Tỉnh/Thành phố',
        dataField: 'city',
        dataType: 'string',
      }, {
        caption: 'Phân loại',
        dataField: 'phan_loai',
        dataType: 'string',
      }, {
        caption: 'Giá dự toán',
        dataField: 'gia_du_toan',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Ngày phê duyệt',
        dataField: 'ngay_phe_duyet',
        dataType: 'datetime',
        format: 'd/M/yyyy',
        calculateFilterExpression: filterDateYYYYMMDD,
      }, {
        caption: 'Ngày đăng',
        dataField: 'ngay_dang',
        dataType: 'datetime',
        format: 'd/M/yyyy',
        calculateFilterExpression: filterDateYYYYMMDD,
      }, {
        caption: 'Số hiệu',
        dataField: 'so_hieu',
      }]);
    }else if(target == "#packages"){    
      LoadDxDataGridSource("#gridContainer", "{{url('/api/user-plans-packages')}}", [{
        caption: 'Tên KHLCNT',
        dataField: 'ten_khlcnt',
        width: 300,
        dataType: 'string',
        cellTemplate: function (container, options) {
            if(options.value == null){
              return;
            }
            $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-plans')}}?so_khlcnt=${options.data.so_khlcnt}`).attr('target', '_blank').appendTo(container);
        }
      }, {
        caption: 'Số KHLCNT',
        dataField: 'so_khlcnt',
        dataType: 'string',
      },{
        caption: 'Tên đơn vị lập KHLCNT',
        dataField: 'company_name',
        width: 300,
        dataType: 'string',
        cellTemplate: function (container, options) {
            if(options.value == null){
              return;
            }
            $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-clients')}}?mst=${options.data.mst_client}`).attr('target', '_blank').appendTo(container);
        }
      }, {
        caption: 'Tên gói thầu',
        dataField: 'ten_goi_thau',
        dataType: 'string',
      }, {
        caption: 'Giá gói thầu',
        dataField: 'gia_goi_thau',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Tỉnh/Thành phố',
        dataField: 'city',
        dataType: 'string',
      }, {
        caption: 'Phân loại',
        dataField: 'phan_loai',
        dataType: 'string',
      }, {
        caption: 'Ngày phê duyệt',
        dataField: 'ngay_phe_duyet',
        dataType: 'datetime',
        format: 'd/M/yyyy',
        calculateFilterExpression: filterDateYYYYMMDD,
      }, {
        caption: 'Ngày đăng',
        dataField: 'ngay_dang',
        dataType: 'datetime',
        format: 'd/M/yyyy',
        calculateFilterExpression: filterDateYYYYMMDD,
      }]);
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