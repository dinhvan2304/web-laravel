@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê thuê bao Vinaphone</h1>
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
                            <a class="nav-link" data-toggle="tab" href="#vnedu" role="tab" aria-controls="home" aria-selected="true">VNPT Edu</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#vnptigate" role="tab" aria-controls="home">VNPT IGate</a>
                          </li>
                        </ul>
                        <div id="detail-popup"></div>
                        <div id="pivotgrid-chart"></div>
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
  function LoadData(statisticUrl, gridUrl, myFields){
    $.getJSON(statisticUrl)
    .done(function(result){
    const pivotGridChart = $('#pivotgrid-chart').dxChart({
      commonSeriesSettings: {
        type: 'bar',
      },
      tooltip: {
        enabled: true,
      },
      size: {
        height: 320,
      },
      adaptiveLayout: {
        width: 450,
      },
    }).dxChart('instance');
    let drillDownDataSource = {};
    
    const detailPopup = $('#detail-popup').dxPopup({
      contentTemplate(contentElement) {
        $('<div class="h-100" />').addClass('drill-down').dxDataGrid({
            remoteOperations: { groupPaging: true },
            columnAutoWidth: true,
            allowColumnResizing: true,
            columnResizingMode: 'widget', // or 'nextColumn'
            rowAlternationEnabled: true,
            hoverStateEnabled: true,
            
            loadPanel: {
                enabled: false // or false | "auto"
            }, 
            // // showBorders: true,
            grouping: {
                autoExpandAll: false,
                contextMenuEnabled: true
            },
            groupPanel: {
                visible: false
            },       
            searchPanel: {
                visible: true
            },   
            filterRow: {
                visible: true
            },
            headerFilter: {
                visible: true
            },
            columnFixing: {
                enabled: true
            },
            export: {
                enabled: true
            },           
            paging: {
                pageSize: 10
            },
            pager: {
                showPageSizeSelector: true,
                allowedPageSizes: [10, 50, 100],
                showInfo: true
            },
            columns: [{
              caption: 'Tên khách hàng',
              dataField: 'name',
              dataType: 'string',
            }, {
              caption: 'Tỉnh',
              dataField: 'city',
              dataType: 'string',
            }, {
              caption: 'Nhà mạng',
              dataField: 'isp',
              dataType: 'string',
            }, {
              caption: 'Dịch vụ',
              dataField: 'service',
              dataType: 'string',
            }, {
              caption: 'Số điện thoại',
              dataField: 'phone',
              dataType: 'string',
            }],
          })
          .appendTo(contentElement);
      },
      onShowing() {
        $('.drill-down')
          .dxDataGrid('instance')
          .option('dataSource', drillDownDataSource);
      },
      onShown() {
        $('.drill-down')
          .dxDataGrid('instance')
          .updateDimensions();
      },
    }).dxPopup('instance');
    const pivotGrid = $('#gridContainer').dxPivotGrid({
        allowSortingBySummary: true,
        allowFiltering: true,
        allowSorting: true,
        showBorders: true,
        showColumnGrandTotals: false,
        showRowGrandTotals: false,
        showRowTotals: false,
        showColumnTotals: false,
        fieldChooser: {
          enabled: true,
          height: 400,
        },
        fieldPanel: {
            visible: true,
            showFilterFields: false
        },
        headerFilter: {
          allowSearch: true,
          showRelevantValues: true,
          width: 300,
          height: 400,
        },
        export: {
            enabled: true
        },
        onCellClick(e) {
          if (e.area === 'data') {
            console.log(e.cell);
            const datas = e.component.getDataSource().getData();
            const rowPathLength = e.cell.rowPath.length;
            const columnPathLength = e.cell.columnPath.length;
            const rowPathName = e.cell.rowPath[rowPathLength - 1];
            var rowOpt2="";
            var colOpt=e.cell.columnPath[0];
            var colOpt2="";
            const city = e.cell.rowPath[0];
            if(e.cell.rowPath.length > 1){
              rowOpt2 = e.cell.rowPath[1];
            }
            if(e.cell.columnPath.length > 1){
              colOpt2 = e.cell.columnPath[1];
            }
            const popupTitle = `${rowPathName}`;

            drillDownDataSource = new DevExpress.data.DataSource({
              key: "city",
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
                  $.getJSON(`${gridUrl}?city=${city}&rowOpt2=${rowOpt2}&colOpt=${colOpt}&colOpt2=${colOpt2}`, params)
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
            drillDownDataSource.load();
            detailPopup.option('title', popupTitle);
            detailPopup.show();
          }
        },
        onExporting: function(e) {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Statistic');
 
            DevExpress.excelExporter.exportPivotGrid({
                component: e.component,
                worksheet: worksheet
            }).then(function() {
                workbook.xlsx.writeBuffer().then(function(buffer) {
                    saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Statistic.xlsx');
                });
            });
            e.cancel = true;
        },
        dataSource: {
          fields: myFields,
          store: result.statistic,
        },
      }).dxPivotGrid('instance');
      pivotGrid.bindChart(pivotGridChart, {
        dataFieldsDisplayMode: 'splitPanes',
        alternateDataFields: false,
      });
    });
  }
  function changeTab(target = "#list"){
    if(target == "#list"){
      LoadData("{{url('/api/statistic-vnptthuebao')}}","{{url('/api/statistic-vnptthuebao-list')}}",[{
        caption: 'Tỉnh/thành phố',
        dataField: 'city',
        area: 'row',
      }, {
        caption: 'Nhà mạng',
        dataField: 'isp',
        area: 'row',
      }, {
        caption: 'Dịch vụ',
        dataField: 'service',
        area: 'column',
      }, {
        caption: 'Tổng số',
        dataField: 'total',
        dataType: 'number',
        summaryType: 'sum',
        area: 'data',
      }]);
    }else if(target == "#vnedu"){
      LoadData("{{url('/api/statistic-vnptthuebao-vnedu')}}","{{url('/api/statistic-vnptthuebao-vnedu-list')}}",
      [{
        caption: 'Tỉnh/thành phố',
        dataField: 'city',
        area: 'row',
      }, {
        caption: 'Loại',
        dataField: 'type',
        area: 'column',
      }, {
        caption: 'Nhà mạng',
        dataField: 'isp',
        area: 'column',
      }, {
        caption: 'Tổng số',
        dataField: 'total',
        dataType: 'number',
        summaryType: 'sum',
        area: 'data',
      }]);
    }else if(target == "#vnptigate"){
      LoadData("{{url('/api/statistic-vnptthuebao-igate')}}","{{url('/api/statistic-vnptthuebao-igate-list')}}",
      [{
        caption: 'Tỉnh/thành phố',
        dataField: 'city',
        area: 'row',
      }, {
        caption: 'Loại',
        dataField: 'type',
        area: 'column',
      }, {
        caption: 'Nhà mạng',
        dataField: 'isp',
        area: 'column',
      }, {
        caption: 'Tổng số',
        dataField: 'total',
        dataType: 'number',
        summaryType: 'sum',
        area: 'data',
      }]);
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