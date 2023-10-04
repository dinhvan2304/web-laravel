@extends('layouts.template')

@section('title','Tương quan bên mời thầu - nhà thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
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
                  <div class="row mb-2 text-center">
                    <div class="col-sm-5">
                      <h2>Nhà thầu: {{$detailCompetitor1->name_vi}}</h2>
                    </div>
                    <div class="col-sm-2">
                      <h2>VS</h2>
                    </div>
                    <div class="col-sm-5">
                      <h2>Nhà thầu: {{$detailCompetitor2->name_vi}}</h2>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" id="searchResult">
                      <h6>Số gói cạnh tranh: <span id="totalPackages"></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <h6>Số gói thắng: <span id="totalPackagesCompetitor1Win"></span></h6>
                    </div>
                    <div class="col">
                      <h6>Số gói thắng: <span id="totalPackagesCompetitor2Win"></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <h6>Tỷ lệ thắng: <span id="rateCompetitor1Win"></span></h6>
                    </div>
                    <div class="col">
                      <h6>Tỷ lệ thắng: <span id="rateCompetitor2Win"></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <h6>Tổng giá trị thắng: <span id="totalValueCompetitor1Win"></span></h6>
                    </div>
                    <div class="col">
                      <h6>Tổng giá trị thắng: <span id="totalValueCompetitor2Win"></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div id="packageYearStatsChart" class="w-100"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" id="searchResult">
                        <h6>Danh sách gói cạnh tranh</h6>
                        <div id="gridContainer-packages"></div>
                        <!-- <div id="gridContainer-packages" class="collapse multi-collapse"></div> -->
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6" id="searchResult">
                        <h6>Trong đó trúng
                          <!-- <i class="nav-icon fa fa-search" data-toggle="collapse" data-target="#gridContainer-packages1" aria-expanded="true" aria-controls="gridContainer-packages"></i> -->
                        </h6>
                        <div id="gridContainer-packages1"></div>
                    </div>
                    <div class="col-md-6" id="searchResult">
                        <h6>
                          Trong đó trúng
                          <!-- <i class="nav-icon fa fa-search" data-toggle="collapse" data-target="#gridContainer-packages2" aria-expanded="true" aria-controls="gridContainer-packages"></i> -->
                        </h6>
                        <div id="gridContainer-packages2"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <h6>Số gói liên danh: <span id="totalPackagesJoin"></span></h6>
                      <h6>Số gói liên danh thắng: <span id="totalPackagesJoinWin"></span></h6>
                      <h6>Tổng giá trị liên danh: <span id="totalValueJoin"></span></h6>
                      <h6>Tổng giá trị liên danh thắng: <span id="totalValueJoinWin"></span></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div id="packageYearJoinStatsChart" class="w-100"></div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12" id="searchResult">
                        <h6>Danh sách gói liên danh</h6>
                        <div id="gridContainer-packages-join"></div>
                        <!-- <div id="gridContainer-packages" class="collapse multi-collapse"></div> -->
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
  var competitor1_mst = "{{app('request')->input('competitor1_mst')}}";
  var competitor2_mst = "{{app('request')->input('competitor2_mst')}}";
  function loadData(){
      $.ajax({
          type: "GET",
          contentType: "application/json; charset=utf-8",
          dataType: "json",
          url: `/api/detail-competitor-competitor/statistic?competitor1_mst=${competitor1_mst}&competitor2_mst=${competitor2_mst}`,
          success: function (result) {
            var labelTypeArr = [];
            var dataTypeArr = [];
            if(result.length <= 0){
              return;
            }
            $("#totalPackages").html(result.totalPackages);
            $("#totalValueJoin").html(DevExpress.localization.formatNumber(result.totalValueJoin, "currency"));
            $("#totalValueJoinWin").html(DevExpress.localization.formatNumber(result.totalValueJoinWin, "currency"));
            $("#totalPackagesJoin").html(result.totalPackagesJoin);
            $("#totalPackagesJoinWin").html(result.totalPackagesJoinWin);
            $("#totalPackagesCompetitor1Win").html(result.totalPackagesCompetitor1Win);
            $("#totalPackagesCompetitor2Win").html(result.totalPackagesCompetitor2Win);
            $("#rateCompetitor1Win").html(DevExpress.localization.formatNumber(result.totalPackagesCompetitor1Win/result.totalPackages,"percent"));
            $("#rateCompetitor2Win").html(DevExpress.localization.formatNumber(result.totalPackagesCompetitor2Win/result.totalPackages,"percent"));
            $("#totalValueCompetitor1Win").html(DevExpress.localization.formatNumber(result.totalValueCompetitor1Win,"currency"));
            $("#totalValueCompetitor2Win").html(DevExpress.localization.formatNumber(result.totalValueCompetitor2Win,"currency"));
            $('#packageYearStatsChart').dxChart({
              dataSource: result.packageYearStats,
              commonSeriesSettings: {
                barPadding: 0,
                argumentField: 'year',
                type: 'bar',
              },
              series: [
                { valueField: 'number_packages', name: 'Số gói cạnh tranh trong năm' },
                { valueField: 'number_packages_competitor1', name: 'Số gói NT {{$detailCompetitor1->name_vi}} thắng' },
                { valueField: 'number_packages_competitor2', name: 'Số gói NT {{$detailCompetitor2->name_vi}} thắng' },
              ],
              legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center',
                itemTextPosition: 'bottom',
              },
              title: {
                text: 'Biểu đồ thống kê số gói thầu cạnh tranh',
              },
              export: {
                enabled: true,
              },
              tooltip: {
                enabled: true
              },
            }).dxChart('instance');
            $('#packageYearJoinStatsChart').dxChart({
              dataSource: result.packageYearJoinStats,
              commonSeriesSettings: {
                barPadding: 0,
                argumentField: 'year',
                type: 'bar',
              },
              series: [
                { valueField: 'number_packages', name: 'Số gói liên danh trong năm' },
              ],
              legend: {
                verticalAlignment: 'bottom',
                horizontalAlignment: 'center',
                itemTextPosition: 'bottom',
              },
              title: {
                text: 'Biểu đồ thống kê số gói thầu liên danh',
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
      LoadDxDataGridSource("#gridContainer-packages", `/api/detail-competitor-competitor/packages?competitor1_mst=${competitor1_mst}&competitor2_mst=${competitor2_mst}`, [{
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
        caption: 'Loại gói',
        dataField: 'package_type',
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
      LoadDxDataGridSource("#gridContainer-packages1", `/api/detail-competitor-competitor/packagesWin?competitor1_mst=${competitor1_mst}&competitor2_mst=${competitor2_mst}`, [{
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
        caption: 'Loại gói',
        dataField: 'package_type',
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
      LoadDxDataGridSource("#gridContainer-packages2", `/api/detail-competitor-competitor/packagesWin?competitor1_mst=${competitor2_mst}&competitor2_mst=${competitor1_mst}`, [{
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
      LoadDxDataGridSource("#gridContainer-packages-join", `/api/detail-competitor-competitor/packagesJoin?competitor1_mst=${competitor2_mst}&competitor2_mst=${competitor1_mst}`, [{
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
  loadData();
</script>
@endsection