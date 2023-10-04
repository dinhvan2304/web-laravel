@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê danh sách gói thầu tiềm năng theo khách hàng</h1>
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
  
  $.getJSON("{{url('/api/statistic-clients')}}")
    .done(function(result){
    const pivotGrid = $('#gridContainer').dxPivotGrid({
        allowSortingBySummary: true,
        allowFiltering: true,
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
            caption: 'Tên công ty',
            dataField: 'company_name',
            area: 'row',
            sortBySummaryField: 'Total',
          }, {
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
            dataField: 'gia_goi_thau',
            dataType: 'number',
            summaryType: 'sum',
            format: 'currency',
            area: 'data',
          }],
          store: result.statistic,
        },
      }).dxPivotGrid('instance');
    });
</script>
@endsection