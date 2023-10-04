@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
@if(isset($detail))
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
                            <a class="nav-link" data-toggle="tab" href="#hsmt" role="tab" aria-controls="home" aria-selected="true">Thông tin hồ sơ mời thầu</a>
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
                          <div class="row">
                            <div class="col">
                              <div id="chartPrice"></div>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="hsmt" role="tabpanel" aria-labelledby="hsmt-tab">
                          <table style="width: 100%; margin: 0" id="hsmt-table" class="table"> 
                            <thead>
                              <tr>
                                <th>STT</th>
                                <th>Tên phần/ Tên chương</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                          <h3>Tên gói thầu: {{$detail->ten_goi_thau}}</h3>
                          <p>Số thông báo: {{$detail->so_tbmt}} <a class="btn btn-sm btn-primary" target="_blank" href="{{$detail->link}}">Xem trên muasamcong</a></p>
                          <p>Bên mời thầu: {{$detail->ben_moi_thau}}</p>
                          <p>Nguồn vốn: {{$detail->nguon_von}}</p>
                          <p>Tên dự toán: {{$detail->ten_du_toan}}</p>
                          <p>Loại hợp đồng: {{$detail->loai_hop_dong}}</p>
                          <p>Hình thức lựa chọn nhà thầu: {{$detail->hinh_thuc_lcnt}}</p>
                          <p>Phương thức lựa chọn nhà thầu: {{$detail->phuong_thuc_lcnt}}</p>
                          <p>Giá dự toán: <span class="format-currency" data-value="{{$detail->gia_du_toan}}"></span></p>
                          <p>Đảm bảo dự thầu:<span class="format-currency" data-value="{{$detail->tien_dbdt}}"></span></p>
                          <p>Thời gian thực hiện: {{$detail->thoi_gian_thuc_hien}}</span></p>
                          <p>Hình thức dự thầu: {{$detail->hinh_thuc_du_thau}}</p>
                          <p>Nhận hồ sơ dự thầu từ : <span class="format-date-yyyyMMdd" data-value="{{$detail->nhan_e_hsdt_tu_ngay}}"></span> đến <span class="format-date-yyyyMMdd" data-value="{{$detail->nhan_e_hsdt_den_ngay}}"></span> </p>
                          <p>Địa điểm nhận HSDT: {{$detail->dia_diem_nhan_hsdt}}</p>
                          <p>Thời điểm đóng/mở thầu: <span class="format-date-yyyyMMdd" data-value="{{$detail->thoi_diem_dong_mo_thau}}"></span></p>
                          <p>Địa điểm mở thầu: {{$detail->dia_diem_mo_thau}}</p>
                          <p>Hình thức đảm bảo dự thầu: {{$detail->hinh_thuc_dbdt}}</p>
                          <p>Địa điểm nhận HSDT: {{$detail->dia_diem_nhan_hsdt}}</p>

                          <p>Đơn vị trúng thầu: {{$detail->don_vi_trung_thau}}</p>
						  @if($detail->competitor_id != "")
                          <p>
                            MST Đơn vị trúng thầu: {{$detail->competitor_id}}<a class="btn btn-primary btn-sm" target="_blank" href="https://hkd.ptdl.tk/dashboard/detail-hkd?mst={{$detail->competitor_id}}">Xem thông tin thuế</a>
                          </p>
						  @endif
                          <p>Giá trúng thầu: <span class="format-currency" data-value="{{$detail->gia_trung_thau}}"></span></p>
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

@endif
@endsection


@section('script')
@if(isset($detail))
<script>
  
  function changeTab(target = "#statistic"){
      if(target == "#statistic"){
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "{{url('/api/detail-packages/statistic?so_tbmt='.$detail->so_tbmt)}}",
            success: function (result) {
              var labelTypeArr = [];
              var dataTypeArr = [];
              if(result.length <= 0){
                return;
              }
              $("#totalCompetitors").html(result.totalCompetitors);

              var chart = $('#chartPrice').dxChart({
                dataSource: result.chartData,
                commonSeriesSettings: {
                  barPadding: 0,
                  argumentField: 'name_vi',
                  type: 'bar',
                },
                series: [
                  { valueField: 'gia_du_thau', name: 'Giá dự thầu' },
                  { valueField: 'gia_sau_giam', name: 'Giá sau giảm' },
                  { valueField: 'thoi_gian_thuc_hien', name: 'Thời gian thực hiện' },
                ],
                legend: {
                  verticalAlignment: 'bottom',
                  horizontalAlignment: 'center',
                  itemTextPosition: 'bottom',
                },
                title: {
                  text: 'Biểu đồ giá dự thầu',
                },
                export: {
                  enabled: true,
                },
                tooltip: {
                  enabled: true,
                  format: {type: "currency"}
                },
              }).dxChart('instance');
            }
        });
      }else if(target == "#competitors"){
        LoadDxDataGridSource("#gridContainer-competitors", "{{url('/api/detail-packages/competitors?so_tbmt='.$detail->so_tbmt)}}", [{
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
          calculateFilterExpression: filterDateYYYYMMDD,
        }]);
      }else if(target == "#hsmt"){
         $("#hsmt-table tbody").html("");
        $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            url: "{{url('/api/detail-packages/statistic?so_tbmt='.$detail->so_tbmt)}}",
            success: function (result) {
              let lstChapters = getListChapter(result.hsmtData);
              console.log(lstChapters);
              for (var i = 0;i < lstChapters.length ; i++){
                let aChapter = lstChapters[i];
                $("#hsmt-table tbody").append(`
                  <tr style="height: auto;"> 
                    <td>${i+1}</td>
                    <td>${aChapter.name}</td>
                  <tr>
                `);
                if(aChapter.children.length == 0){
                  continue;
                }
                for (var j = 0;j < aChapter.children.length; j++){
                  $("#hsmt-table tbody").append(`
                    <tr style="height: auto;"> 
                      <td>${i+1}.${j+1}</td>
                      <td><a target="blank" href="https://muasamcong.mpi.gov.vn/egp/contractorfe/viewer?formCode=${aChapter.children[j].code}&id=${aChapter.children[j].notifyId}">${aChapter.children[j].name}</a></td>
                    <tr>
                  `);
                }
              }
            }
        });
      }
  }
  function getListChapter(list) {
      let lstFinal = list;
      lstFinal = list.sort((a, b) => a.lev < b.lev && 1 || -1);
      var map = {}, node, roots = [], i;
      for (i = 0; i < lstFinal.length; i += 1) {
          map[lstFinal[i].code] = i;
          lstFinal[i].children = [];
      }
      for (i = 0; i < lstFinal.length; i += 1) {
          node = lstFinal[i];
          if (node.pcode == undefined || node.pcode == null 
            || map[node.pcode] == undefined || map[node.pcode] == null
            || lstFinal[map[node.pcode]] == undefined || lstFinal[map[node.pcode]] == null
            || lstFinal[map[node.pcode]].children == undefined || lstFinal[map[node.pcode]].children == null
          ) {
              roots.unshift(node);
              continue;
          }
          lstFinal[map[node.pcode]].children.unshift(node);
      }
      return roots;
  };
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