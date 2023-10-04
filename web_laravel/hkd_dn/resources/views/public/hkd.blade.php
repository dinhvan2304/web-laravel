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
						
							@role('admin')
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#list" role="tab" aria-controls="home" aria-selected="true">Danh sách chung</a>
                          </li>
							@endrole
                          <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#hkdlist" role="tab" aria-controls="home" aria-selected="true">Danh sách HKDCT</a>
                          </li>
							@role('admin')
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnpt" role="tab" aria-controls="home">Danh sách KH VNPT</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tiemnang" role="tab" aria-controls="home" >Danh sách KH tiềm năng</a>
                          </li>
							@endrole
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
LoadDxDataGridSource("#gridContainer", "{{url('/api/user-hkd')}}", [{
  caption: 'Mã số thuế',
  dataField: 'mst',
  width: 100,
  dataType: 'string',
  cellTemplate: function (container, options) {
      if(options.value == null){
        return;
      }
      $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-hkd')}}?mst=${options.data.mst}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Tên chủ hộ/doanh nghiệp',
    dataField: 'name',
    dataType: 'string',
   }, {
     caption: 'Số điện thoại',
     dataField: 'phone',
     dataType: 'string',
	 visible:false,
   }, {
     caption: 'Email',
     dataField: 'email',
     dataType: 'string',
	 visible:false,
  }, {
    caption: 'Loại',
    dataField: 'type',
    dataType: 'string',
  }, {
    caption: 'Doanh thu tháng',
    dataField: 'latest_doanh_thu_thang',
    dataType: 'number',
    format: 'currency'
  }, {
    caption: 'Nhóm',
    dataField: 'client_type',
    dataType: 'string',
  }, {
    caption: 'Tỉnh',
    dataField: 'tinh',
    dataType: 'string',
  }, {
    caption: 'Huyện',
    dataField: 'huyen',
    dataType: 'string',
  }, {
    caption: 'Xã',
    dataField: 'xa',
    dataType: 'string',
  }, {
    caption: 'Địa chỉ kinh doanh',
    dataField: 'dia_chi_kd',
    dataType: 'string',
  }, {
    caption: 'Ngành nghề',
    dataField: 'nganh_nghe',
    dataType: 'string',
  }],{
  },{
    toolbar: {
      items: [
        {
          location: 'before',
          widget: 'dxCheckBox',
          options: {    
            width: 200,
            text: 'Lọc có Số điện thoại', 
            onValueChanged(data) {
				if(data.value == true){
					$("#gridContainer").dxDataGrid("instance").columnOption("phone", "selectedFilterOperation", "<>");  
					$("#gridContainer").dxDataGrid("instance").columnOption("phone", "filterValue",  ""); 
				}else{
					$("#gridContainer").dxDataGrid("instance").columnOption("phone", "filterValue",  null); 
				}
            },
          },
        },
		
        {
          location: 'before',
          widget: 'dxCheckBox',
          options: {    
            width: 200,
            text: 'Lọc có Email', 
            onValueChanged(data) {
				if(data.value == true){
					$("#gridContainer").dxDataGrid("instance").columnOption("email", "selectedFilterOperation", "<>");  
					$("#gridContainer").dxDataGrid("instance").columnOption("email", "filterValue",  ""); 
				}else{
					$("#gridContainer").dxDataGrid("instance").columnOption("email", "filterValue",  null);
				}
            },
          },
        },
        'columnChooserButton',
        'exportButton',
        'searchPanel',
      ],
    }
  });
  function changeTab(target = "#hkdlist"){
    dataGrid = $("#gridContainer").dxDataGrid("instance");
    if(target == "#vnpt"){
      dataGrid.filter(["type", "=", 'KH hiện hữu']);
    }else if(target == "#tiemnang"){
      dataGrid.filter(["type", "<>", 'KH hiện hữu']);
    }else if(target == "#hkdlist"){
      dataGrid.filter(["client_type", "=", "Hộ kinh doanh cá thể"]);
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