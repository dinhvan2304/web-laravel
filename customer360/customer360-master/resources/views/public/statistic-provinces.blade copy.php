@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê danh sách gói thầu tiềm năng theo địa bàn</h1>
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
  
  $.getJSON("{{url('/api/statistic-provinces')}}")
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
        export: {
            enabled: true
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
            sortBySummaryField: 'Total',
          }, {
            caption: 'Lĩnh vực',
            dataField: 'linh_vuc',
            width: 150,
            area: 'row',
          // }, {
          //   dataField: 'year',
          //   dataType: 'number',
          //   area: 'column',
          }, {
            caption: 'Tháng',
            dataField: 'format_year',
            area: 'column',
          }, {
            caption: 'Số lượng gói',
            dataField: 'number_packages',
            dataType: 'number',
            summaryType: 'sum',
            area: 'data',
          }, {
            caption: 'Tổng giá trị',
            dataField: 'total_gia_goi_thau',
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