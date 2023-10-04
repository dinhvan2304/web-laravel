@extends('layouts.template')

@section('title','Tương quan bên mời thầu - nhà thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Bên mời thầu: {{$detailClient->company_name}}</h1>
            <h1>Nhà thầu: {{$detailCompetitor->name_vi}}</h1>
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
          </div>
          <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" id="searchResult">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#statistic" role="tab" aria-controls="home" aria-selected="true">Thống kê</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packages" role="tab" aria-controls="home" aria-selected="true">Danh sách gói thầu</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#packagesWin" role="tab" aria-controls="home" aria-selected="true">Danh sách gói trúng</a>
                          </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
                          <h1>Thống kê chung</h1>
                          <div class="row">
                            <div class="col">
                              Tổng số gói tham dự: <span id="totalPackages"></span><br />
                              Tổng số gói thắng: <span id="totalPackagesWin"></span>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div id="packageYearStatsChart" class="w-100"></div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="packages" role="tabpanel" aria-labelledby="bidder-tab">
                          <div id="gridContainer-packages"></div>
                        </div>
                        <div class="tab-pane fade" id="packagesWin" role="tabpanel" aria-labelledby="bidder-tab">
                          <div id="gridContainer-packagesWin"></div>
                        </div>
                      </div>
                  </div>
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
  var client_mst = "{{app('request')->input('client_mst')}}";
  var competitor_mst = "{{app('request')->input('competitor_mst')}}";
  function changeTab(target = "#statistic"){
      if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: `/api/detail-client-competitor/statistic?client_mst=${client_mst}&competitor_mst=${competitor_mst}`,
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalPackages").html(result.totalPackages);
              $("#totalPackagesWin").html(result.totalPackagesWin);
              $('#packageYearStatsChart').dxChart({
                dataSource: result.packageYearStats,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'year',
                  type: 'bar',
                },
                series: [
                  { valueField: 'number_packages', name: 'Số gói tham dự' },
                  { valueField: 'number_wins', name: 'Số gói thắng' },
                ],
                legend: {
                  verticalAlignment: 'bottom',
                  horizontalAlignment: 'center',
                  itemTextPosition: 'bottom',
                },
                title: {
                  text: 'Biểu đồ thống kê số gói thầu',
                },
                export: {
                  enabled: true,
                },
                tooltip: {
                  enabled: true,
                },
              }).dxChart('instance');
            }
        });
      }else if(target == "#packages"){
        LoadDxDataGridSource("#gridContainer-packages", `/api/detail-client-competitor/packages?client_mst=${client_mst}&competitor_mst=${competitor_mst}`, [{
          caption: 'Tên gói thầu',
          dataField: 'ten_goi_thau',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              if(options.value == null){
                return;
              }
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-packages')}}?so_tbmt=${options.data.so_tbmt}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số TBMT',
          dataField: 'so_tbmt',
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
              $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-clients')}}?mst=${options.data.mst_client}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Loại gói',
          dataField: 'package_type',
          dataType: 'string',
        }, {
          caption: 'Lĩnh vực',
          dataField: 'linh_vuc',
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
          calculateFilterExpression: filterDateYYYYMMDD,
        }, {
          caption: 'Ngày đóng, mở thầu',
          dataField: 'thoi_diem_dong_mo_thau',
          dataType: 'datetime',
          format: 'd/M/yyyy',
          calculateFilterExpression: filterDateYYYYMMDD,
        }], {
            totalItems: [{
                column: "so_tbmt",
                summaryType: "count"
            }, {
                column: "gia_trung_thau",
                summaryType: "sum",
                valueFormat: 'currency',
            }]
        });
      }else if(target == "#packagesWin"){
        LoadDxDataGridSource("#gridContainer-packagesWin", `/api/detail-client-competitor/packagesWin?client_mst=${client_mst}&competitor_mst=${competitor_mst}`, [{
          caption: 'Tên gói thầu',
          dataField: 'ten_goi_thau',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              if(options.value == null){
                return;
              }
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-packages')}}?so_tbmt=${options.data.so_tbmt}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số TBMT',
          dataField: 'so_tbmt',
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
              $('<a>' + options.value + '</a>').attr('href',  `{{url('/dashboard/detail-clients')}}?mst=${options.data.mst_client}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Loại gói',
          dataField: 'package_type',
          dataType: 'string',
        }, {
          caption: 'Lĩnh vực',
          dataField: 'linh_vuc',
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
          calculateFilterExpression: filterDateYYYYMMDD,
        }, {
          caption: 'Ngày đóng, mở thầu',
          dataField: 'thoi_diem_dong_mo_thau',
          dataType: 'datetime',
          format: 'd/M/yyyy',
          calculateFilterExpression: filterDateYYYYMMDD,
        }], {
            totalItems: [{
                column: "so_tbmt",
                summaryType: "count"
            }, {
                column: "gia_trung_thau",
                summaryType: "sum",
                valueFormat: 'currency',
            }]
        });
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