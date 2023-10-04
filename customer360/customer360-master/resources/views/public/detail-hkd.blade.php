@extends('layouts.template')

@section('title','Hộ kinh doanh')
@section('content')

@if(isset($detail))
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Khách hàng: {{$detail->name}}</h1>
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
                          <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">Thông tin chung</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#statistic" role="tab" aria-controls="home" aria-selected="true">Thống kê chung</a>
                        </li>
                        @if($detail->client_source == "1")
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#history" role="tab" aria-controls="home" aria-selected="true">Lịch sử sử dụng dịch vụ</a>
                        </li>
                        @endif
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" href="#history-tax" role="tab" aria-controls="home" aria-selected="true">Lịch sử thuế</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane  fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Tên: {{$detail->name}}</h3>
                        <p>Mã số thuế: {{$detail->mst}}
                          <a class="btn btn-primary btn-sm" target="_blank" href="https://bid.ptdl.tk/dashboard/detail-clients?mst={{$detail->mst}}">Lịch sử mời thầu</a>
                          <a class="btn btn-primary btn-sm" target="_blank" href="https://bid.ptdl.tk/dashboard/detail-competitors?mst={{$detail->mst}}">Lịch sử dự thầu</a>
                        </p>
                        <p>Số điện thoại: {{$detail->phone}}</p>
                        <p>Email: {{$detail->email}}</p>
                        <p>Tỉnh: {{$detail->tinh}}</p>
                        <p>Huyện: {{$detail->huyen}}</p>
                        <p>Xã: {{$detail->xa}}</p>
                        <p>Địa chỉ kinh doanh: {{$detail->dia_chi_kd}}</p>
                        <p>Ngành nghề kinh doanh: {{$detail->nganh_nghe}}</p>
                        <p>Khách hàng: {{$detail->type}}</p>
                      </div>
                      <div class="tab-pane fade" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
                        <h1>Thống kê chung</h1>
                        <div class="row">
                          <div class="col">
                            Tổng số dịch vụ: <span id="totalServices"></span><br />
                            Tổng doanh số: <span id="totalServicesDoanhThu"></span><br />
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div id="servicesStatsChart" class="w-100"></div>
                          </div>
                        </div>
                      </div>
                      @if($detail->client_source == "1")
                      <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <div id="gridContainer" ></div>
                      </div>
                      @endif
                      <div class="tab-pane fade" id="history-tax" role="tabpanel" aria-labelledby="history-tab">
                        <h4>Tất cả lịch sử</h4>
                        <div id="gridContainertax-all" ></div>
                        <h4>Lịch sử thay đổi</h4>
                        <div id="gridContainertax-change" ></div>
                        <h4>Tất cả Off</h4>
                        <div id="gridContainertax-off" ></div>
                        <h4>Lịch sử thuế GTGT</h4>
                        <div id="gridContainertax-gtgt" ></div>
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

@endif
@endsection


@section('script')
@if(isset($detail))
<script>
  function changeTab(target = "#profile"){
    if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "{{url('/api/detail-hkd/statistic?mst='.$detail->mst)}}",
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalServices").html(result.totalServices);
              $("#totalServicesDoanhThu").html(DevExpress.localization.formatNumber(result.totalServicesDoanhThu, "currency"));

              $('#servicesStatsChart').dxChart({
                dataSource: result.servicesStats,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'TEN_DVVT',
                  type: 'bar',
                },
                series: [
                  { valueField: 'number_services', name: 'Số dịch vụ'},
                ],
                legend: {
                  verticalAlignment: 'bottom',
                  horizontalAlignment: 'center',
                  itemTextPosition: 'bottom',
                },
                title: {
                  text: 'Thống kê dịch vụ sử dụng',
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
      }else if(target == "#history"){
      LoadDxDataGridSourceWithoutExport("#gridContainer", "{{url('/api/user-hkd-history')}}?mst={{$detail->mst}}", [{
          caption: 'Mã thuê bao',
          dataField: 'MA_TB',
          dataType: 'string'
        }, {
          caption: 'Tên dịch vụ',
          dataField: 'TEN_DVVT',
          dataType: 'string'
        }, {
          caption: 'Loại hình thuê bao',
          dataField: 'LOAIHINH_TB',
          dataType: 'string'
        }, {
          caption: 'Trạng thái thuê bao',
          dataField: 'TRANGTHAI_TB',
          dataType: 'string'
        }, {
          caption: 'Ngày lập hợp đồng',
          dataField: 'NGAYLAP_HD',
          dataType: 'datetime',
          calculateCellValue: function(rowData) {
              if(!rowData.NGAYLAP_HD){
                return "";
              }
              return moment(rowData.NGAYLAP_HD, 'DD/MM/YYYY HH:mm:ss').format("DD/MM/YYYY");
          }
        }, {
          caption: 'Ngày sử dụng',
          dataField: 'NGAY_SD',
          dataType: 'datetime',
          calculateCellValue: function(rowData) {
              if(!rowData.NGAY_SD){
                return "";
              }
              return moment(rowData.NGAY_SD, 'DD/MM/YYYY HH:mm:ss').format("DD/MM/YYYY");
          }
        }, {
          caption: 'Ngày cắt',
          dataField: 'NGAY_CAT',
          dataType: 'datetime',
          calculateCellValue: function(rowData) {
              if(!rowData.NGAY_CAT){
                return "";
              }
              return moment(rowData.NGAY_CAT, 'DD/MM/YYYY HH:mm:ss').format("DD/MM/YYYY");
          }
        }]);
    }else if(target == "#history-tax"){
      LoadDxDataGridSourceWithoutExport("#gridContainertax-all", "{{url('/api/user-hkd-history-tax-all')}}?mst={{$detail->mst}}", [{
        caption: 'Kỳ lập bộ',
        dataField: 'ky_lap_bo',
        dataType: 'string'
      }, {
        caption: 'Doanh thu tháng',
        dataField: 'doanh_thu_thang',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Tổng thuế',
        dataField: 'tong_thue',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Thuế GTGT',
        dataField: 'thue_gtgt',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Thuế TNCN',
        dataField: 'thue_tncn',
        dataType: 'number',
        format: 'currency',
      }]);
      LoadDxDataGridSourceWithoutExport("#gridContainertax-change", "{{url('/api/user-hkd-history-tax-change')}}?mst={{$detail->mst}}", [{
        caption: 'Kỳ lập bộ',
        dataField: 'ky_lap_bo',
        dataType: 'string'
      }, {
        caption: 'Doanh thu cũ',
        dataField: 'doanh_thu_cu',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Doanh thu mới',
        dataField: 'doanh_thu_moi',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Tổng thuế',
        dataField: 'tong_thue',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Thuế GTGT',
        dataField: 'thue_gtgt',
        dataType: 'number',
        format: 'currency',
      }, {
        caption: 'Thuế TNCN',
        dataField: 'thue_tncn',
        dataType: 'number',
        format: 'currency',
      }]);
      LoadDxDataGridSourceWithoutExport("#gridContainertax-off", "{{url('/api/user-hkd-history-tax-off')}}?mst={{$detail->mst}}", [{
        caption: 'Kỳ lập bộ',
        dataField: 'ky_lap_bo',
        dataType: 'string'
      }, {
        caption: 'Off Date to',
        dataField: 'off_date_to',
        dataType: 'string'
      }]);
      LoadDxDataGridSourceWithoutExport("#gridContainertax-gtgt", "{{url('/api/user-hkd-history-tax-gtgt')}}?mst={{$detail->mst}}", [{
        caption: 'Kỳ lập bộ',
        dataField: 'ky_lap_bo',
        dataType: 'string'
      }, {
        caption: 'Doanh thu tháng',
        dataField: 'doanh_thu_thang',
        dataType: 'number',
        format: 'currency',
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
@endif
@endsection