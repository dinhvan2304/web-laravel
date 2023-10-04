@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê danh sách HKD theo địa bàn</h1>
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
  
  $.getJSON("{{url('/api/statistic-gdt')}}")
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
              caption: 'Tên',
              dataField: 'name',
              width: 300,
              dataType: 'string',
              cellTemplate: function (container, options) {
                  if(options.value == null){
                    return;
                  }
                  $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-hkd')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
              }
            }, {
              caption: 'MST',
              dataField: 'mst',
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
            var huyen="";
            var xa="";
            const tinh = e.cell.rowPath[0];
            if(e.cell.rowPath.length > 1){
              huyen = e.cell.rowPath[1];
            }
            if(e.cell.rowPath.length > 2){
              xa = e.cell.rowPath[2];
            }
            const popupTitle = `${rowPathName}`;

            drillDownDataSource = new DevExpress.data.DataSource({
              key: "tinh",
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
                  $.getJSON(`{{url('/api/statistic-gdt-list')}}?tinh=${tinh}&huyen=${huyen}&xa=${xa}`, params)
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
          fields: [{
            caption: 'Tỉnh/thành',
            dataField: 'tinh',
            area: 'row',
          }, {
            caption: 'Huyện',
            dataField: 'huyen',
            area: 'row',
          }, {
            caption: 'Xã',
            dataField: 'xa',
            area: 'row',
          }, {
            caption: 'Tổng',
            area: 'column',
          }, {
            caption: 'Tổng số',
            dataField: 'total',
            dataType: 'number',
            summaryType: 'sum',
            area: 'data',
          }],
          store: result.statistic,
        },
      }).dxPivotGrid('instance');
      pivotGrid.bindChart(pivotGridChart, {
        dataFieldsDisplayMode: 'splitPanes',
        alternateDataFields: false,
      });
    });
</script>
@endsection