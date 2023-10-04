@extends('layouts.template')

@section('title','Nhà thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách nhà thầu</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">Danh sách nhà thầu</li>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Chọn nhà thầu để so sánh</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-column">
            <div>
                Nhà thầu 1
                <div id="competitor_1"></div>
            </div>
            <h2>VS</h2>
            <div>
                Nhà thầu 2
                <div id="competitor_2"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="SoSanh()">So sánh</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('script')
<script>
  var comboboxDataSource = new DevExpress.data.DataSource({
      key: "id",
      load: function(loadOptions) {
          var d = $.Deferred(),
                  params = {};
          [
              "skip",     
              "take", 
              "requireTotalCount", 
              "requireGroupCount", 
              "sort", 
              "filter", 
              "totalSummary", 
              "group", 
              "groupSummary"
          ].forEach(function(i) {
              if(i in loadOptions && isNotEmpty(loadOptions[i])) 
                  params[i] = JSON.stringify(loadOptions[i]);
          });
          $.getJSON(`/api/user-competitors/root`, params)
              .done(function(result) {
                  console.log(result);
                  d.resolve(result.data, { 
                      totalCount: result.totalCount,
                      summary: result.summary,
                      groupCount: result.groupCount
                  });
              });
          return d.promise();
      }
  });
  
  var comboDataSource = new DevExpress.data.DataSource({
      key: "id",
      load: function(loadOptions) {
          var d = $.Deferred(),
                  params = {};
          [

            "filter",
            "group", 
            "groupSummary",
            "parentIds",
            "requireGroupCount",
            "requireTotalCount",
            "searchExpr",
            "searchOperation",
            "searchValue",
            "select",
            "sort",
            "skip",     
            "take",
            "totalSummary", 
            "userData"
          ].forEach(function(i) {
              if(i in loadOptions && isNotEmpty(loadOptions[i])) 
                  params[i] = JSON.stringify(loadOptions[i]);
          });
          // $.getJSON("{{url('api/dxDatagrid/test-datagrid-service')}}", params)
          $.getJSON("{{url('/api/user-competitors')}}", params)
              .done(function(result) {
                  console.log(result);
                  d.resolve(result.data, { 
                      totalCount: result.totalCount,
                      summary: result.summary,
                      groupCount: result.groupCount
                  });
              });
          return d.promise();
      },
  });
  function isNotEmpty(value) {
      return value !== undefined && value !== null && value !== "";
  }
  
  LoadDxDataGridSource("#gridContainer", "{{url('/api/user-competitors')}}", [{
    caption: 'Hành động',
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
            url: `/api/favorites?type=competitors&id=${e.row.data.id}`,
            success: function (result) {
              
            }
        });
      },
    },{
        hint: 'Tương quan với VNPT',
        icon: 'variable',
        onClick(e) {
          window.open(`/dashboard/detail-competitor-competitor?competitor1_mst=${e.row.data.so_dkkd}&competitor2_mst={{$vnpt_competitor_mst}}`);
        }
      }]
  },{
    caption: 'Tên',
    dataField: 'name_vi',
    width: 300,
    dataType: 'string',
    cellTemplate: function (container, options) {
        if(options.value == null){
          return;
        }
        $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?mst=${options.data.so_dkkd}`).attr('target', '_blank').appendTo(container);
    }
  }, {
    caption: 'Số ĐKKD',
    dataField: 'so_dkkd',
    dataType: 'string',
  }, {
    caption: 'Tỉnh, thành phố',
    dataField: 'province',
    dataType: 'string',
  }, {
    caption: 'Địa chỉ',
    dataField: 'c_address',
    width: 300,
    dataType: 'string',
  }, {
    caption: 'Số gói tham dự',
    dataField: 'total_join',
    dataType: 'number',
    
  }, {
    caption: 'Loại hình doanh nghiệp',
    dataField: 'loai_doanh_nghiep',
    dataType: 'string',
  }, {
    caption: 'Số điện thoại',
    dataField: 'phone',
    dataType: 'string',
  },{
    caption: 'Trực thuộc',
    dataField: 'parent_name_vi',
    width: 300,
    dataType: 'string',
    cellTemplate: function (container, options) {
      if(options.value == null){
        return;
      }
      $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?mst=${options.data.head_mst}`).attr('target', '_blank').appendTo(container);
    }
  }], {
      totalItems: [{
          column: "name_vi",
          summaryType: "count"
      }]
  },{
    toolbar: {
      items: [
        {
          location: 'before',
          widget: 'dxButton',
          options: {
            text: 'So sánh tương quan 2 nhà thầu ',            
            width: 400,
            onClick(e) {
              $("#exampleModalLong").modal("show");
            },
          },
        },
        {
          location: 'before',
          widget: 'dxSelectBox',
          options: {
            width: 300,
            dataSource: comboboxDataSource,
            displayExpr: 'name_vi',
            valueExpr: 'id',
            onValueChanged(data) {
              $("#gridContainer").dxDataGrid("instance").filter(['path', "contains", `/${data.value}`]);
            },
          },
        },
        'columnChooserButton',
        'exportButton',
        'searchPanel',
      ],
    }
  });
  $('#competitor_1').dxSelectBox({
    dataSource: comboDataSource,
    displayExpr: 'name_vi',
    valueExpr: 'so_dkkd',
    searchEnabled: true,
    showClearButton: true,
    remoteOperations: { groupPaging: true }
  });

  $('#competitor_2').dxSelectBox({
    dataSource: comboDataSource,
    displayExpr: 'name_vi',
    valueExpr: 'so_dkkd',
    searchEnabled: true,
    showClearButton: true,
    remoteOperations: { groupPaging: true }
  });

  function SoSanh(){
    var competitor1_mst = $("#competitor_1").dxSelectBox('instance').option('value');
    var competitor2_mst = $("#competitor_2").dxSelectBox('instance').option('value');
    var url = `/dashboard/detail-competitor-competitor?competitor1_mst=${competitor1_mst}&competitor2_mst=${competitor2_mst}`;
    window.open(url,'_blank');
  }
  
  $(() => {
  });
</script>
@endsection
