@extends('layouts.template')

@section('title','Nhà thầu')
@section('content')
@if(isset($detail))
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Nhà thầu:  {{$detail->name_vi}}</h1>
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
          <div class="col-md-12 mx-auto">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12" id="searchResult">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link active" data-toggle="tab" href="#statistic" role="tab" aria-controls="home" aria-selected="true">Thống kê chung</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">Thông tin chung</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#packages" role="tab" aria-controls="profile" aria-selected="false">DS gói thầu đã tham dự</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#packagesWin" role="tab" aria-controls="profile" aria-selected="false">DS gói thầu trúng thầu</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#packagesClients" role="tab" aria-controls="profile" aria-selected="false">DS bên mời thầu đã từng tham dự</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#competitors" role="tab" aria-controls="contact" aria-selected="false">DS đối thủ</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#good" role="tab" aria-controls="contact" aria-selected="false">DS sản phẩm dịch vụ</a>
                        </li> -->
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#join" role="tab" aria-controls="contact" aria-selected="false">DS nhà thầu liên doanh</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
                        <h1>Thống kê chung</h1>
                        <div class="row">
                          <div class="col">
                            Tổng số gói đã tham dự: <span id="totalPackages"></span><br />
                            Tổng số gói trúng: <span id="totalPackagesWin"></span><br />
                            Tổng số gói CNTT đã tham dự: <span id="totalPackagesCNTT"></span><br />
                            Tổng số gói CNTT trúng: <span id="totalPackagesCNTTWin"></span><br />

                          </div>
                          <div class="col">
                            Tổng giá trị các gói đã tham dự: <span id="totalPackagesValue"></span><br />
                            Tổng giá trị các gói CNTT đã tham dự: <span id="totalPackagesValueThamDuCNTT"></span><br />
                            Tổng giá trị các gói đã trúng: <span id="totalPackagesValueTrungThau"></span><br />
                            Tổng giá trị các gói CNTT đã trúng: <span id="totalPackagesValueTrungThauCNTT"></span>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div id="packageYearStatsNumberChart" class="w-100"></div>
                          </div>
                          <div class="col">
                            <div id="packageYearStatsValueChart" class="w-100"></div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div id="packageCompetitorStatsChart" class="w-100"></div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Tên công ty: {{$detail->name_vi}}</h3>
                        <p>Địa chỉ: {{$detail->c_address}}</p>
						@if($detail->so_dkkd != "")
                        <p>Mã số thuế: {{$detail->so_dkkd}}<a class="btn btn-primary btn-sm" target="_blank" href="https://hkd.ptdl.tk/dashboard/detail-hkd?mst={{$detail->so_dkkd}}">Xem lịch sử thuế</a>
                        </p>
						@endif
                        <p>Phone: {{$detail->phone}}</p>
                        <p>Loại doanh nghiệp: {{$detail->loai_doanh_nghiep}}</p>
                        <h3>Danh sách đơn vị trực thuộc:</h3>
                        <div id="gridContainer-childs"></div>
                      </div>
                      <div class="tab-pane fade" id="packages" role="tabpanel" aria-labelledby="packages-tab">
                        <div id="gridContainer-packages"></div>
                      </div>
                      <div class="tab-pane fade" id="packagesWin" role="tabpanel" aria-labelledby="packages-tab">
                        <div id="gridContainer-packagesWin"></div>
                      </div>
                      <div class="tab-pane fade" id="packagesClients" role="tabpanel" aria-labelledby="packages-tab">
                        <div id="gridContainer-packagesClients"></div>
                      </div>
                      <div class="tab-pane fade" id="competitors" role="tabpanel" aria-labelledby="competitors-tab">
                        <div id="gridContainer-competitors"></div>
                      </div>
                      <div class="tab-pane fade" id="good" role="tabpanel" aria-labelledby="good-tab">
                        <div id="gridContainer-good"></div>
                      </div>
                      <div class="tab-pane fade" id="join" role="tabpanel" aria-labelledby="lienket-tab">
                        <div id="gridContainer-join"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@else
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Không có dữ liệu</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
</div>
@endif
@endsection


@section('script')
@if(isset($detail))
<script>
  var testData;
  function changeTab(target = "#statistic"){
      if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "{{url('/api/detail-competitors/statistic?mst='.$detail->so_dkkd)}}",
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalPackages").html(result.totalPackages);
              $("#totalPackagesWin").html(result.totalPackagesWin);
              $("#totalPackagesCNTT").html(result.totalPackagesCNTT);
              $("#totalPackagesCNTTWin").html(result.totalPackagesCNTTWin);

              $("#totalPackagesValue").html(DevExpress.localization.formatNumber(result.totalPackagesValue, "currency"));
              $("#totalPackagesValueThamDuCNTT").html(DevExpress.localization.formatNumber(result.totalPackagesValueThamDuCNTT, "currency"));
              $("#totalPackagesValueTrungThau").html(DevExpress.localization.formatNumber(result.totalPackagesValueTrungThau, "currency"));
              $("#totalPackagesValueTrungThauCNTT").html(DevExpress.localization.formatNumber(result.totalPackagesValueTrungThauCNTT, "currency"));

             
              $('#packageYearStatsNumberChart').dxChart({
                dataSource: result.packageYearStats,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'year',
                  type: 'bar',
                },
                series: [
                  { valueField: 'number_cntt', name: 'Số gói CNTT' },
                  { valueField: 'number_total', name: 'Tổng gói thầu' },
                  { valueField: 'number_win', name: 'Số gói trúng' },
                  { valueField: 'number_cntt_win', name: 'Số gói CNTT trúng' },
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
              
              $('#packageYearStatsValueChart').dxChart({
                dataSource: result.packageYearStats,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'year',
                  type: 'bar',
                },
                series: [
                  { valueField: 'total_quy_mo_tham_du_cntt', name: 'Tổng quy mô tham dự CNTT'},
                  { valueField: 'total_quy_mo_tham_du', name: 'Tổng giá trị tham dự' },
                  { valueField: 'total_gia_trung_thau', name: 'Tổng giá trị trúng'},
                  { valueField: 'total_gia_trung_thau_cntt', name: 'Tổng giá trị trúng CNTT'},
                ],
                legend: {
                  verticalAlignment: 'bottom',
                  horizontalAlignment: 'center',
                  itemTextPosition: 'bottom',
                },
                title: {
                  text: 'Biểu đồ thống kê giá trị thầu',
                },
                export: {
                  enabled: true,
                },
                tooltip: {
                  enabled: true,
                  format: {type: "currency"}
                },
              }).dxChart('instance');
              var pivotData = [];
              result.packageCompetitorStats.forEach(function (value, index) {
                if(pivotData[value.id] == undefined){
                  pivotData[value.id] = {};
                }
                for (const prop in value) {
                  if(prop != "year"){
                    pivotData[value.id][prop] = value[prop];
                  }else{
                    pivotData[value.id][`${value[prop]}`] = value["number_packages"];
                  }
                }
              });
              pivotData = pivotData.filter(x => x !== undefined);


              var seriesChart = Array.from(new Set(result.packageCompetitorStats.map(bill => bill.year)));
              seriesChart = seriesChart.map(aY => { return { 'valueField': aY, 'name': aY}});

              $('#packageCompetitorStatsChart').dxChart({
                dataSource: pivotData,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'company_name',
                  type: 'bar',
                },
                size: {
                    height: pivotData.length * 20,
                },
                rotated: true,
                series: seriesChart,
                legend: {
                  verticalAlignment: 'top',
                  horizontalAlignment: 'center',
                },
                title: {
                  text: 'Biểu đồ thống kê số bên mời thầu đã tham dự',
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
      }else if(target == "#profile"){
        LoadDxDataGridSource("#gridContainer-childs", "{{url('/api/detail-competitors/childs?mst='.$detail->so_dkkd)}}", [{
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
          caption: 'Mã số thuế',
          dataField: 'so_dkkd',
          dataType: 'string',
        }, {
          caption: 'Tỉnh, thành phố',
          dataField: 'province',
          dataType: 'string',
        }], {
          totalItems: [{
                column: "so_dkkd",
                summaryType: "count"
            }]
        });
      }else if(target == "#packages"){
        LoadDxDataGridSource("#gridContainer-packages", "{{url('/api/detail-competitors/packages?mst='.$detail->so_dkkd)}}", [{
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
        LoadDxDataGridSource("#gridContainer-packagesWin", "{{url('/api/detail-competitors/packages-win?mst='.$detail->so_dkkd)}}", [{
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
      }else if(target == "#packagesClients"){
        LoadDxDataGridSource("#gridContainer-packagesClients", "{{url('/api/detail-competitors/packages-clients?mst='.$detail->so_dkkd)}}", [{
          caption: 'Tên',
          dataField: 'company_name',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              if(options.value == null){
                return;
              }
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-clients')}}?mst=${options.data.so_dkkd}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số gói đã tham dự',
          dataField: 'number_packages',
          dataType: 'number',
          cellTemplate: function (container, options) {
              if(options.value == null){
                return;
              }
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-client-competitor')}}?competitor_mst={{$detail->so_dkkd}}&client_mst=${options.data.so_dkkd}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Mã số thuế',
          dataField: 'so_dkkd',
          dataType: 'string',
        }, {
          caption: 'Tỉnh, thành phố',
          dataField: 'city',
          dataType: 'string',
        }, {
          caption: 'Ngày thành lập',
          dataField: 'created_date',
          
          dataType: 'datetime',
          width: 180,
          format: 'd/M/yyyy',
        }], {
          totalItems: [{
                column: "so_dkkd",
                summaryType: "count"
            }]
        });
      }else if(target == "#competitors"){
        LoadDxDataGridSource("#gridContainer-competitors", "{{url('/api/detail-competitors/competitors?mst='.$detail->so_dkkd)}}", [{
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
          caption: 'Số gói cạnh tranh',
          dataField: 'number_packages',
          dataType: 'number',
          cellTemplate: function (container, options) {
              if(options.value == null){
                return;
              }
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitor-competitor')}}?competitor1_mst={{$detail->so_dkkd}}&competitor2_mst=${options.data.so_dkkd}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Loại hình doanh nghiệp',
          dataField: 'loai_doanh_nghiep',
          dataType: 'string',
        }, {
          caption: 'Tỉnh, thành phố',
          dataField: 'province',
          dataType: 'string',
        }, {
          caption: 'Địa chỉ',
          dataField: 'c_address',
          dataType: 'string',
        }], {
            totalItems: [{
                column: "name_vi",
                summaryType: "count"
            }]
        });
      }else if(target == "#good"){
        LoadDxDataGridSource("#gridContainer-good", "{{url('/api/detail-competitors/good?mst='.$detail->so_dkkd)}}", [{
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
      }else if(target == "#join"){
        LoadDxDataGridSource("#gridContainer-join", "{{url('/api/detail-competitors/competitors-joins?mst='.$detail->so_dkkd)}}", [{
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
          caption: 'Số gói cùng liên doanh',
          dataField: 'number_packages',
          dataType: 'number',
        }, {
          caption: 'Mã số thuế',
          dataField: 'so_dkkd',
          dataType: 'string',
        }, {
          caption: 'Tỉnh, thành phố',
          dataField: 'province',
          dataType: 'string',
        }], {
          totalItems: [{
                column: "so_dkkd",
                summaryType: "count"
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
@endif
@endsection