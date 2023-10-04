@extends('layouts.template')

@section('title','Bên mời thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Bên mời thầu: {{$detail->company_name}}</h1>
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
                          <a class="nav-link" data-toggle="tab" href="#packages" role="tab" aria-controls="profile" aria-selected="false">DS gói thầu</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#competitors" role="tab" aria-controls="contact" aria-selected="false">DS nhà thầu đã tham dự</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#good" role="tab" aria-controls="contact" aria-selected="false">DS sản phẩm dịch vụ</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
                        <h1>Thống kê chung</h1>
                        <div class="row">
                          <div class="col">
                            Tổng số gói: <span id="totalPackages"></span><br />
                            Tổng số gói CNTT: <span id="totalPackagesCNTT"></span><br />
                          </div>
                          <div class="col">
                            Tổng giá trị các gói đã phát hành: <span id="totalPackagesValue"></span><br />
                            Tổng giá trị các gói CNTT đã phát hành: <span id="totalPackagesCNTTValue"></span><br />
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
                        <h3>Tên công ty: {{$detail->company_name}}</h3>
                        <p>Địa chỉ: {{$detail->address}}</p>
                        <p>Mã số thuế: {{$detail->so_dkkd}}</p>
                        <p>Phone: {{$detail->phone}}</p>
                        <p>Loại: {{$detail->type_company}}</p>
                        <h3>Danh sách đơn vị trực thuộc:</h3>
                        <div id="gridContainer-childs"></div>
                      </div>
                      <div class="tab-pane fade" id="packages" role="tabpanel" aria-labelledby="packages-tab">
                        <div id="gridContainer-packages" ></div>
                      </div>
                      <div class="tab-pane fade" id="competitors" role="tabpanel" aria-labelledby="bidder-tab">
                        <div id="gridContainer-competitors"></div>
                      </div>
                      <div class="tab-pane fade" id="good" role="tabpanel" aria-labelledby="contact-tab">
                        <div id="gridContainer-good"></div>
                      </div>
                    </div>
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
  function changeTab(target = "#statistic"){
      if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "{{url('/api/detail-clients/statistic?id='.app('request')->input('id'))}}",
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalPackages").html(result.totalPackages);
              $("#totalPackagesCNTT").html(result.totalPackagesCNTT);
              $("#totalPackagesValue").html(DevExpress.localization.formatNumber(result.totalPackagesValue, "currency"));
              $("#totalPackagesCNTTValue").html(DevExpress.localization.formatNumber(result.totalPackagesCNTTValue, "currency"));
      
              $('#packageYearStatsNumberChart').dxChart({
                palette: 'Violet',
                dataSource: result.packageYearStats,
                commonSeriesSettings: {
                  argumentField: 'year',
                  type: 'line',
                },
                argumentAxis: {
                  valueMarginsEnabled: false,
                  discreteAxisDivisionMode: 'crossLabels',
                  grid: {
                    visible: true,
                  },
                },
                series: [
                  { valueField: 'number_cntt', name: 'Số gói CNTT' },
                  { valueField: 'number_total', name: 'Tổng gói thầu' },
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
                palette: 'Violet',
                dataSource: result.packageYearStats,
                commonSeriesSettings: {
                  argumentField: 'year',
                  type: 'line',
                },
                argumentAxis: {
                  valueMarginsEnabled: false,
                  discreteAxisDivisionMode: 'crossLabels',
                  grid: {
                    visible: true,
                  },
                },
                series: [
                  { valueField: 'total_quy_mo_cntt', name: 'Tổng quy mô tham dự CNTT'},
                  { valueField: 'total_quy_mo', name: 'Tổng giá trị tham dự' },
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

              $('#packageCompetitorStatsChart').dxChart({
                palette: 'Violet',
                dataSource: result.packageCompetitorStats,
                commonSeriesSettings: {
                  argumentField: 'name_vi',
                  type: 'bar',
                },
                // size: {
                //     height: 8000,
                // },
                rotated: true,
                series: [
                  { valueField: 'number_packages', name: 'Số gói'},
                ],
                legend: {
                  verticalAlignment: 'top',
                  horizontalAlignment: 'center',
                },
                title: {
                  text: 'Thống kê nhà thầu tham dự thầu do \"{{$detail->company_name}}\" phát hành',
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
        LoadDxDataGridSource("#gridContainer-packages", "{{url('/api/detail-clients/packages?id='.app('request')->input('id'))}}", [{
          caption: 'Tên gói thầu',
          dataField: 'ten_goi_thau',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-packages')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số TBMT',
          dataField: 'so_tbmt',
          dataType: 'string',
        }, {
          caption: 'Lĩnh vực',
          dataField: 'linh_vuc',
          dataType: 'string',
        }, {
          caption: 'Đơn vị trúng thầu',
          dataField: 'name_vi',
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?id=${options.data.competitor_id}`).attr('target', '_blank').appendTo(container);
          }
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
          caption: 'Ngày đóng, mở thầu',
          dataField: 'thoi_diem_dong_mo_thau',
          dataType: 'datetime',
          format: 'd/M/yyyy',
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
      }else if(target == "#profile"){
        LoadDxDataGridSource("#gridContainer-childs", "{{url('/api/detail-competitors/childs?id='.app('request')->input('id'))}}", [{
          caption: 'Tên',
          dataField: 'company_name',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-clients')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
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
        LoadDxDataGridSource("#gridContainer-competitors", "{{url('/api/detail-clients/competitors?id='.app('request')->input('id'))}}", [{
          caption: 'Tên',
          dataField: 'name_vi',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số gói đã tham dự',
          dataField: 'number_packages',
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-client-competitor')}}?client_id={{app('request')->input('id')}}&competitor_id=${options.data.id}`).attr('target', '_blank').appendTo(container);
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
        LoadDxDataGridSource("#gridContainer-good", "{{url('/api/detail-clients/good?id='.app('request')->input('id'))}}", [{
          caption: 'Tên gói thầu',
          dataField: 'ten_goi_thau',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-packages')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Số TBMT',
          dataField: 'so_tbmt',
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
        }, {
          caption: 'Ngày đóng, mở thầu',
          dataField: 'thoi_diem_dong_mo_thau',
          dataType: 'datetime',
          format: 'd/M/yyyy',
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