@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê danh sách gói thầu CNTT theo địa bàn</h1>
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
  
  $.getJSON("{{url('/api/statistic-city')}}")
    .done(function(result){
    const pivotGridChart = $('#pivotgrid-chart').dxChart({
      commonSeriesSettings: {
        type: 'bar',
      },
      tooltip: {
        enabled: true,
        customizeTooltip(args) {
          const valueText = (args.seriesName.indexOf('Tổng giá trị') !== -1)
            ? new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(args.originalValue)
            : args.originalValue;

          return {
            html: `${args.seriesName}<div class='currency'>${
              valueText}</div>`,
          };
        },
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
              caption: 'Tên gói thầu',
              dataField: 'ten_goi_thau',
              width: 300,
              dataType: 'string',
              cellTemplate: function (container, options) {
                  if(options.value == null){
                    return;
                  }
                  $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-packages')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
              }
            }, {
              caption: 'Bên mời thầu',
              dataField: 'company_name',
              width: 300,
              dataType: 'string',
              cellTemplate: function (container, options) {
                  if(options.value == null){
                    return;
                  }
                  $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-clients')}}?id=${options.data.id_client}`).attr('target', '_blank').appendTo(container);
              }
            }, {
              caption: 'Số TBMT',
              dataField: 'so_tbmt',
              dataType: 'string',
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
                  $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-clients')}}?id=${options.data.id_client}`).attr('target', '_blank').appendTo(container);
              }
            }, {
              caption: 'Đơn vị trúng thầu',
              dataField: 'name_vi',
              dataType: 'string',
              cellTemplate: function (container, options) {
                  if(options.value == null){
                    return;
                  }
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
            const popupTitle = `${rowPathName}`;
            var year = e.cell.columnPath[0];
            var yearmonth = "";
            if(columnPathLength > 1){
              yearmonth = e.cell.columnPath[columnPathLength - 1];
            }

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
                  $.getJSON(`{{url('/api/statistic-city-list')}}?city=${rowPathName}&year=${year}&yearmonth=${yearmonth}`, params)
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
            dataField: 'city',
            area: 'row',
            
          }, {
            caption: 'Năm',
            dataField: 'year',
            area: 'column',
          }, {
            caption: 'Tháng',
            dataField: 'format_yearmonth',
            area: 'column',
          }, {
            caption: 'Số lượng gói',
            dataField: 'number_packages',
            dataType: 'number',
            summaryType: 'sum',
            area: 'data',
          }, {
            caption: 'Tổng giá trị',
            dataField: 'total_gia_trung_thau',
            dataType: 'number',
            summaryType: 'sum',
            format: 'currency',
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