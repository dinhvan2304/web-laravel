@extends('layouts.template')

@section('title','Bên mời thầu')
@section('content')
@if(isset($detail))
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Bên lập KHLCNT: {{$detail->ten_khlcnt}}</h1>
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
                          <a class="nav-link" data-toggle="tab" href="#packages" role="tab" aria-controls="profile" aria-selected="false">DS gói thầu</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane  fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Số KHLCNT: {{$detail->so_khlcnt}}</h3>
                        <p>Loại thông báo: {{$detail->loai_tb}}</p>
                        <p>Hình thức: {{$detail->hinh_thuc}}</p>
                        <p>Tên KHLCNT: {{$detail->ten_khlcnt}}</p>
                        <p>Chủ đầu tư: {{$detail->chu_dau_tu}}</p>
                        <p>Bên mời thầu: {{$detail->ben_moi_thau}}</p>
                        <p>Phân loại: {{$detail->phan_loai}}</p>
                        <p>Phạm vi: {{$detail->pham_vi}}</p>
                        <p>Trạng thái: {{$detail->trang_thai}}</p>
                        <p>Ngày phê duyệt: <span class="format-date-yyyyMMdd" data-value="{{$detail->ngay_phe_duyet}}"></span></p>
                        <p>Giá dự toán: <span class="format-currency" data-value="{{$detail->gia_du_toan}}"></span></p>
                        <p>Ngày đăng: <span class="format-date-yyyyMMdd" data-value="{{$detail->ngay_dang}}"></span></p>
                      </div>
                      <div class="tab-pane fade" id="packages" role="tabpanel" aria-labelledby="packages-tab">
                        <div id="gridContainer-packages" ></div>
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
  function changeTab(target = "#statistic"){
      if(target == "#packages"){
        LoadDxDataGridSource("#gridContainer-packages", "{{url('/api/detail-plans/packages?so_khlcnt='.$detail->so_khlcnt)}}", [{
          caption: 'Tên gói thầu',
          dataField: 'ten_goi_thau',
          width: 300,
          dataType: 'string',
        }, {
          caption: 'Lĩnh vực',
          dataField: 'linh_vuc',
          dataType: 'string',
        }, {
          caption: 'Giá gói thầu',
          dataField: 'gia_goi_thau',
          dataType: 'number',
          format: 'currency',
        }, {
          caption: 'Thời gian tổ chức',
          dataField: 'thoi_gian_to_chuc',
          deserializeValue: function(dateStr) {  
            if(!dateStr){
              return "";
            }
            const year = dateStr.slice(0, 4)
            const month = dateStr.slice(4, 6) 
            const date = new Date(parseInt(year), parseInt(month) - 1)
            return date;
          },
          format: 'quarterAndYear',
        }], {
            totalItems: [{
                column: "ten_goi_thau",
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