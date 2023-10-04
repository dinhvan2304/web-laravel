@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Gói thầu: {{$detail->ten_goi_thau}}</h1>
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
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-controls="home" aria-selected="true">Thông tin chung</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#competitors" role="tab" aria-controls="home" aria-selected="true">Danh sách nhà thầu tham dự</a>
                          </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="statistic" role="tabpanel" aria-labelledby="statistic-tab">
                          <h1>Thống kê chung</h1>
                          <div class="row">
                            <div class="col">
                              Tổng số nhà thầu tham dự: <span id="totalCompetitors"></span>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <h3>Tên gói thầu: {{$detail->ten_goi_thau}}</h3>
                          <p>Số thông báo: <a class="btn btn-primary" target="_blank" href="{{$detail->link}}">{{$detail->so_tbmt}}</a></p>
                          <p>Bên mời thầu: {{$detail->ben_moi_thau}}</p>
                          <p>Nguồn vốn: {{$detail->nguon_von}}</p>
                          <p>Tên dự toán: {{$detail->ten_du_toan}}</p>
                          <p>Loại hợp đồng: {{$detail->loai_hop_dong}}</p>
                          <p>Hình thức lựa chọn nhà thầu: {{$detail->hinh_thuc_lcnt}}</p>
                          <p>Phương thức lựa chọn nhà thầu: {{$detail->phuong_thuc_lcnt}}</p>
                          <p>Giá dự toán: {{$detail->gia_du_toan}}</p>
                          <p>Đảm bảo dự thầu: {{$detail->tien_dbdt}}</p>
                          <p>Thời gian thực hiện: {{$detail->thoi_gian_thuc_hien}}</p>
                          <p>Hình thức dự thầu: {{$detail->hinh_thuc_du_thau}}</p>
                          <p>Nhận hồ sơ dự thầu từ : {{$detail->nhan_e_hsdt_tu_ngay}} đến {{$detail->nhan_e_hsdt_den_ngay}} </p>
                          <p>Địa điểm nhận HSDT: {{$detail->dia_diem_nhan_hsdt}}</p>
                          <p>Thời điểm đóng/mở thầu: {{$detail->thoi_diem_dong_mo_thau}}</p>
                          <p>Địa điểm mở thầu: {{$detail->dia_diem_mo_thau}}</p>
                          <p>Hình thức đảm bảo dự thầu: {{$detail->hinh_thuc_dbdt}}</p>
                          <p>Địa điểm nhận HSDT: {{$detail->dia_diem_nhan_hsdt}}</p>

                          <p>Đơn vị trúng thầu: {{$detail->don_vi_trung_thau}}</p>
                          <p>Giá trúng thầu: {{$detail->gia_trung_thau}}</p>
                          <p>Phạm vi cung cấp: <a class="btn btn-primary" target="_blank" href="http://muasamcong.mpi.gov.vn:8081/webentry/attack_file/phamvicungcap?bid_no={{$detail->so_tbmt}}&bid_turn_no=00&bid_succmethod=9">Xem</a></p>
                        </div>
                        <div class="tab-pane fade" id="competitors" role="tabpanel" aria-labelledby="bidder-tab">
                          <div id="gridContainer-competitors"></div>
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
  
  function changeTab(target = "#statistic"){
      if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "{{url('/api/detail-packages/statistic?id='.app('request')->input('id'))}}",
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalCompetitors").html(result.totalCompetitors);
            }
        });
      }else if(target == "#competitors"){
        LoadDxDataGridSource("#gridContainer-competitors", "{{url('/api/detail-packages/competitors?id='.app('request')->input('id'))}}", [{
          caption: 'Tên',
          dataField: 'name_vi',
          width: 300,
          dataType: 'string',
          cellTemplate: function (container, options) {
              $('<a>' + options.value + '</a>').attr('href', `{{url('/dashboard/detail-competitors')}}?id=${options.data.id}`).attr('target', '_blank').appendTo(container);
          }
        }, {
          caption: 'Giá dự thầu',
          dataField: 'gia_du_thau',
          dataType: 'number',
          format: 'currency',
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
          
          dataType: 'datetime',
          width: 180,
          format: 'd/M/yyyy',
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