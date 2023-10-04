@extends('layouts.template')

@section('title','Dashboard theo dõi sản lượng dịch vụ CA và SmartCA')
@section('content')
  <style>
    #pie_luykegiahan{
      height: 200px;
    }
    #pie_giahan{
      height: 200px;
    }
  </style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Dashboard theo dõi sản lượng dịch vụ CA và SmartCA</h1>
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
            <div class="col-sm-12">
              <div class="card mb-3">
                <form action="/dashboard/statistic-newclients" method="get" id="searchForm">
                  <div class="card-body" id="chart_card" class="collapse">
                      <div class="row">
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Năm: </label>
                            <div id="year"></div>                     
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Tháng: </label>
                            <div id="month"></div>  
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Trung tâm kinh doanh: </label>
                            <div id="tinh"></div>                        
                          </div>
                        </div>
                        <div class="col-sm-2">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Loại CA: </label>
                            <div id="caTypes"></div>                      
                          </div>
                        </div>
                        <div class="col-sm-2 advance-control">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Loại khách hàng: </label>
                            <div id="customerTypes"></div>
                          </div>
                        </div>
                        <div class="col-sm-2 advance-control">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Gói dịch vụ: </label>
                            <div id="packages"></div>  
                          </div>
                        </div>
                        <div class="col-sm-4" style="display: flex;align-items: center;">
                          <button type="button" id="btn-statistic" class="btn btn-primary ml-2" onclick="Statistic()">Thống kê</button>
                          <a id="btn-advance" href="#" onclick="ShowHideAdvanceControl()">Nâng cao</a>
                        </div>
                      </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div class="searchresult-area row">
              <div class="col-sm-6">
                <div class="card mb-3">
                  <div class="card-header">
                      <a data-toggle="collapse" href="#chart_card1" aria-expanded="true" aria-controls="chart_card1">
                        <div class="mb-0">
                          <i class="fa fa-bar-chart"></i> 1.TỔNG SẢN LƯỢNG LŨY KẾ NĂM <span class="year"></span>
                          <span class="float-right">Đơn vị: CTS</span>
                          <i class="fa fa-angle-down rotate-icon"></i>
                        </div>
                      </a>
                  </div>

                  <div class="card-body" id="chart_card1" class="collapse">
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text font-weight-bold">Kế hoạch năm</span>
                                <span class="info-box-number h6 text-primary format-number total_year"></span>
                                <b>Phát triển mới:</b>
                                <span class="total_phattrienmoi_nam"></span><br />
                                <b>Gia hạn:</b>
                                <span class="total_giahan_nam"></span>
                            </div> 
                          </div>
            
                          <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text font-weight-bold">Lũy kế từ đầu năm <!-- (Tạo mới + gia hạn) --></span>
                                <span class="info-box-number h6 text-primary format-number total_luykesanluong"></span>
                                <span>So với năm trước</span>
                                <span class="total_diffluykesanluong"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div id="pie_luykegiahan"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text font-weight-bold">Lũy kế Cấp mới</span>
                                <span class="info-box-number h6 text-primary total_luykecapmoi"></span>
                                <span>So với năm trước</span>
                                <span class="total_diffluykecapmoi"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text font-weight-bold">Lũy kế Gia hạn</span>
                                <span class="info-box-number h6 text-primary  total_luykedagiahan"></span>
                                <span>So với năm trước</span>
                                <span class="total_diffluykedagiahan"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                  <div class="card mb-3">
                    <div class="card-header">
                          <a data-toggle="collapse" href="#chart_card2" aria-expanded="true" aria-controls="chart_card2">
                          <div class="mb-0">
                            <i class="fa fa-bar-chart"></i> 2.SẢN LƯỢNG THÁNG <span class="thang"></span>/<span class="year"></span>
                            <span class="float-right">Đơn vị: CTS</span>
                            <i class="fa fa-angle-down rotate-icon"></i>
                          </div>
                      </a>
                    </div>
                    <div class="card-body" id="chart_card2" class="collapse">
                      
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Kế hoạch tháng</span>
                              <span class="info-box-number h6 text-primary format-number total_kehoach_thang"></span>
                              <b>Phát triển mới:</b>
                              <span class="total_phattrienmoi_thang"></span><br />
                              <b>Gia hạn:</b>
                              <span class="total_giahan_thang"></span>
                            </div>
                          </div>
                        
                          <div class="info-box">
                            <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Sản lượng tháng  <!-- (Tạo mới + gia hạn) --></span>
                              <span class="info-box-number h6 text-primary format-number total_sanluong"></span>
                                <span>So với tháng trước</span>
                                <span class="total_diffpremonthsanluong"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div id="pie_giahan"></div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Cấp mới</span>
                              <span class="info-box-number h6 text-primary total_capmoi"></span>
                                <span>So với tháng trước</span>
                                <span class="total_diffpremonthcapmoi"></span>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="info-box">
                            <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Gia hạn</span>
                              <span class="info-box-number h6 text-primary total_dagiahan"></span>
                                <span>So với tháng trước</span>
                                <span class="total_diffpremonthdagiahan"></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="searchresult-area row">
            <div class="col-sm-12">
              <div class="card mb-3">
                <div class="card-header">
                      <a data-toggle="collapse" href="#chart_card" aria-expanded="true" aria-controls="chart_card">
                      <div class="mb-0">
                          <i class="fa fa-bar-chart"></i> 3.THEO DÕI HIỆN TRẠNG SẢN LƯỢNG
                          <span class="float-right">Đơn vị: CTS</span
                          <i class="fa fa-angle-down rotate-icon"></i>
                      </div>
                  </a>
                </div>
                <div class="card-body" id="chart_card" class="collapse">
                  <div class="row">
                    <div class="col-sm-6">
                      <div class="text-center h6 bg-primary p-2">CTS gia hạn</div>
                      <div class="row">
                        <div class="col-sm-4">
                          <div class="text-center">Cần gia hạn T<span class="thang"></span>/<span class="year"></span></div>
                          <div class="text-primary format-number total_cangiahan text-center"></div>
                          <a class="text-center d-block" href="#" onclick="event.preventDefault();ExportExcel(1)">Xem chi tiết</a>
                        </div>
                        <div class="col-sm-4">
                          <div class="text-center">Đã gia hạn trong T<span class="thang"></span>/<span class="year"></span></div>
                          <div class="text-primary format-number total_dagiahan2 text-center"></div>
                          <a class="text-center d-block" href="#" onclick="event.preventDefault();ExportExcel(2)">Xem chi tiết</a>
                        </div>
                        <div class="col-sm-4">
                          <div class="text-center">Chưa gia hạn trong T<span class="thang"></span>/<span class="year"></span></div>
                          <div class="text-primary format-number total_chuagiahan text-center"></div>
						              <a class="text-center d-block" href="#" onclick="event.preventDefault();ExportExcel(3)">Xem chi tiết</a></div>
                      </div>
                    </div>
                    <div class="col-sm-2">
                      <div class="text-center h6 bg-primary p-2">CTS đang hoạt động</div>
                      <div class="text-center">Lũy kế đến T<span class="thang"></span>/<span class="year"></span></div>
                      <div class="text-primary format-number total_luykedanghoatdong text-center"></div>
                    </div>
                    <div class="col-sm-2">
                      <div class="text-center h6 bg-primary p-2">CTS thu hồi</div>
                      <div class="text-center">Lũy kế đến T<span class="thang"></span>/<span class="year"></span></div>
                      <div class="text-primary format-number total_luykethuhoi text-center"></div>
                    </div>
                    <div class="col-sm-2">
                      <div class="text-center h6 bg-primary p-2">CTS cấp bù</div>
                      <div class="text-center">Lũy kế đến T<span class="thang"></span>/<span class="year"></span></div>
                      <div class="text-primary format-number total_luykecapbu text-center"></div>
                      <a class="text-center d-block" href="#" onclick="event.preventDefault();ExportExcel(4)">Xem chi tiết</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="searchresult-area row">
            <div class="col-sm-12">
              <div class="card mb-3">
                <div class="card-body" class="collapse">
                  <div id="dxtab"></div>
				  Số liệu tháng <span class="thang"></span>/<span class="year"></span> <br />
                  <div id="tabs-container">
                    <div class="tab_sanluong">
                      <div id="gridContainer"></div>
                    </div>
                    <div class="tab_sanluonggiahan">
                      <div id="gridContainer2"></div>
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
  <div id="popup">
  
  </div>

@endsection



@section('script')

<script>
  var labelArr = [];
  var dataArr = [];
  var labelProvinceArr = [];
  var dataProvinceArr = [];
  var labelFieldArr = [];
  var dataFieldArr = [];
  var labelTelcoArr = [];
  var dataTelcoArr = [];
  var labelTypeArr = [];
  var dataTypeArr = [];
  
  function getDataSource(url){
    var comboClientDataSource = new DevExpress.data.DataSource({
        key: "id",
        load: function(loadOptions) {
            var d = $.Deferred(),
                    params = {};
            [
              "filter",
              "group", 
              "groupSummary",
              "parentIds",
              "requireGroupCount",
              "requireTotalCount",
              "searchExpr",
              "searchOperation",
              "searchValue",
              "select",
              "sort",
              "skip",     
              "take",
              "totalSummary", 
              "userData"
            ].forEach(function(i) {
                if(i in loadOptions && isNotEmpty(loadOptions[i])) 
                    params[i] = JSON.stringify(loadOptions[i]);
            });
            $.getJSON(url, params)
                .done(function(result) {
                    console.log(result);
                    d.resolve(result.data, { 
                        totalCount: result.totalCount,
                        summary: result.summary,
                        groupCount: result.groupCount
                    });
                });
            return d.promise();
        },
    });
    return comboClientDataSource;
  }

  
	function changeTab(e) {
        $("#tabs-container>div").hide();
		var dxtab = $("#dxtab").dxTabs("instance");
		var target = dxtab.option("selectedItems")[0].target;
		$("." + target).show();
		window[target]();
	}
	function tab_sanluong(){
	}
	function tab_sanluonggiahan(){
	}
  $(() => {
	  
	  $('.advance-control').hide();
	  $('.searchresult-area').hide();
	$('#dxtab').dxTabs({
		dataSource:  [
		  { id: 0, text: 'Danh sách sản lượng TTKD',"target":"tab_sanluong" },
		  { id: 1, text: 'Danh sách sản lượng gia hạn CTS',"target":"tab_sanluonggiahan" },
		],
		"keyExpr":"id",
		"selectedIndex":0,
		"onSelectionChanged":changeTab
	});
	changeTab();
	
	$('#tinh').dxSelectBox({
		dataSource: getDataSource("{{url('/api/dashboard/ca-ttkds')}}"),
		displayExpr: 'name',
		valueExpr: 'value',
		searchEnabled: true,
		showClearButton: true,
		remoteOperations: { groupPaging: true }
	});
    $('#year').dxSelectBox({
      dataSource: ["2021","2022","2023"],
    }).dxValidator({
	  validationGroup: "searchGroup",
      validationRules: [{
        type: 'required',
        message: 'Bắt buộc chọn',
      }],
    });
    $('#month').dxSelectBox({
      dataSource: ["1","2","3","4","5","6","7","8","9","10","11","12"],
    }).dxValidator({
	  validationGroup: "searchGroup",
      validationRules: [{
        type: 'required',
        message: 'Bắt buộc chọn',
      }],
    });
    $('#packages').dxSelectBox({
      dataSource: getDataSource("{{url('/api/dashboard/ca-packages')}}"),
      displayExpr: 'name',
      valueExpr: 'value',
      searchEnabled: true,
      showClearButton: true,
      remoteOperations: { groupPaging: true }
    });
    $('#customerTypes').dxSelectBox({
      dataSource: getDataSource("{{url('/api/dashboard/ca-customertypes')}}"),
      displayExpr: 'name',
      valueExpr: 'value',
      searchEnabled: true,
      showClearButton: true,
      remoteOperations: { groupPaging: true }
    });
    $('#station').dxSelectBox({
      dataSource: getDataSource("{{url('/api/dashboard/ca-stations')}}"),
      displayExpr: 'package',
      valueExpr: 'package',
      searchEnabled: true,
      showClearButton: true,
      remoteOperations: { groupPaging: true }
    });
  });
  $('#caTypes').dxSelectBox({
    dataSource: getDataSource("{{url('/api/dashboard/ca-types')}}"),
    displayExpr: 'name',
    valueExpr: 'value',
    searchEnabled: true,
    showClearButton: true,
    remoteOperations: { groupPaging: true }
  });
  
  function ExportExcel(type){
    var title = "";
    if(type == 1){
      title = "Cần gia hạn";
    }else if(type == 2){
      title = "Đã gia hạn";
    }else if(type == 3){
      title = "Chưa gia hạn";
    }else if(type == 4){
      title = "Cấp bù";
    }
    const detailPopup = $('#popup').dxPopup({
      contentTemplate: function (){
        const scrollView = $('<div id="exportGridContainer" />');
        scrollView.dxScrollView({
          width: '100%',
          height: '100%',
        });
        return scrollView;
      },
      title: `Export dữ liệu ${title}`,
      onShown: function() {
        var tinh = $("#tinh").dxSelectBox('instance').option('value');
        var packages = $("#packages").dxSelectBox('instance').option('value');
        var customerTypes = $("#customerTypes").dxSelectBox('instance').option('value');
        // var station = $("#station").dxSelectBox('instance').option('value');
        var caTypes = $("#caTypes").dxSelectBox('instance').option('value');
        var year = $("#year").dxSelectBox('instance').option('value');
        var month = $("#month").dxSelectBox('instance').option('value');
        var url = `/api/dashboard/ca-service-export?tinh=${tinh}&packages=${packages}&customerTypes=${customerTypes}&caTypes=${caTypes}&year=${year}&month=${month}&exportType=${type}`;
        LoadDxDataGridSourceKey("#exportGridContainer", url,'serial_number',[
            {
              caption: 'TTKD',
              dataField: 'tinh',
              dataType: 'string'
            },
            {
              caption: 'Serial Number',
              dataField: 'serial_number',
              dataType: 'string'
            },
            {
              caption: 'Account',
              dataField: 'account',
              dataType: 'string'
            },
            {
              caption: 'Địa chỉ',
              dataField: 'address',
              dataType: 'string'
            },
            {
              caption: 'Điện thoại',
              dataField: 'phone',
              dataType: 'string'
            },
            {
              caption: 'Email',
              dataField: 'email',
              dataType: 'string'
            },
            {
              caption: 'SubjectDN',
              dataField: 'subjectDN',
              dataType: 'string'
            },
            {
              caption: 'Package',
              dataField: 'package',
              dataType: 'string'
            }
          ], {
            
          },{
              export: {
                enabled: true
              },
          });
      }
    }).dxPopup('instance');
	detailPopup.show();
  }
  function ShowHideAdvanceControl(){
	  $('.advance-control').toggle();
  }
  
  function Statistic(){
    var retValid = DevExpress.validationEngine.validateGroup("searchGroup");
    if(!retValid.isValid){
      return;
    }
	  $('.searchresult-area').show();
    var tinh = $("#tinh").dxSelectBox('instance').option('value');
    var packages = $("#packages").dxSelectBox('instance').option('value');
    var customerTypes = $("#customerTypes").dxSelectBox('instance').option('value');
    // var station = $("#station").dxSelectBox('instance').option('value');
    var caTypes = $("#caTypes").dxSelectBox('instance').option('value');
    var year = $("#year").dxSelectBox('instance').option('value');
    var month = $("#month").dxSelectBox('instance').option('value');
    var url = `/api/dashboard/ca-service?tinh=${tinh}&packages=${packages}&customerTypes=${customerTypes}&caTypes=${caTypes}&year=${year}&month=${month}`;
    // window.location.href = url;
    $(".thang").html(month);
    $(".year").html(year);
    $.getJSON(url).done(function(result) {
      console.log(result);
      if(result.statistic.length <= 0){
        alert("Không có dữ liệu!");
        return;
      }
	    var total_conlai = result.statistic[0].total_year-(result.statistic[0].total_luykedagiahan + result.statistic[0].total_luykecapmoi);
      var chartYearDataSource = [{
        "title": "Other",
        "val": isNaN(total_conlai)?9999999999999999999:total_conlai
      }, {
        "title": "Lũy kế gia hạn",
        "val": result.statistic[0].total_luykedagiahan + result.statistic[0].total_luykecapmoi
      }];
	    var total_conlai_month = result.statistic[0][`thang_${month}`]-(result.statistic[0].total_dagiahan + result.statistic[0].total_capmoi);
      var chartMonthDataSource = [{
        title: "Other",
        val: isNaN(total_conlai_month)?9999999999999999999:total_conlai_month
      }, {
        "title": "Lũy kế gia hạn",
        "val": result.statistic[0].total_dagiahan + result.statistic[0].total_capmoi
      }];
      $('#pie_giahan').dxPieChart({
        type: 'doughnut',
        dataSource: chartMonthDataSource,
        title: 'So với kế hoạch tháng',
        tooltip: {
          enabled: true,
          customizeTooltip(arg) {
            return {
              text: `${arg.valueText} - ${(arg.percent * 100).toFixed(2)}%`,
            };
          },
        },
        customizePoint: function (point) {
          if(point.argument == "Other"){
            return {
              color: "#f5f3f0"
            }
          }
        },
        legend: {
          horizontalAlignment: 'right',
          verticalAlignment: 'top',
          margin: 0,
		      visible:false,
        },
        series: [{
          argumentField: 'title',
        }],
        centerTemplate(pieChart, container) {
          if(pieChart.getAllSeries()[0].getVisiblePoints()[1] != undefined){
            const percent = pieChart.getAllSeries()[0].getVisiblePoints()[1].percent;
            const content = $(`<svg><text text-anchor="middle" style="font-size: 18px" x="100" y="120" fill="#494949"><tspan x="100" dy="20px" style="font-weight: 600">${(percent*100).toFixed(2)}%</tspan></text></svg>`);
            container.appendChild(content.get(0));
          }
        },
      });
      $('#pie_luykegiahan').dxPieChart({
        type: 'doughnut',
        dataSource: chartYearDataSource,
        title: 'So với kế hoạch năm ',
        tooltip: {
          enabled: true,
          customizeTooltip(arg) {
            return {
              text: `${arg.valueText} - ${(arg.percent * 100).toFixed(2)}%`,
            };
          },
        },
        customizePoint: function (point) {
            if(point.argument == "Other"){
				return {
					color: "#f5f3f0"
				}
			}
		},
        legend: {
          horizontalAlignment: 'right',
          verticalAlignment: 'top',
          margin: 0,
		      visible:false,
        },
        series: [{
          argumentField: 'title',
        }],
        centerTemplate(pieChart, container) {
          if(pieChart.getAllSeries()[0].getVisiblePoints()[1] != undefined){
            const percent = pieChart.getAllSeries()[0].getVisiblePoints()[1].percent;
            const content = $(`<svg><text text-anchor="middle" style="font-size: 18px" x="100" y="120" fill="#494949"><tspan x="100" dy="20px" style="font-weight: 600">${(percent*100).toFixed(2)}%</tspan></text></svg>`);
            container.appendChild(content.get(0));
          }
        },
      }); 

      $(".total_year").html(result.statistic[0].total_year);
      $(".total_kehoach_thang").html(result.statistic[0][`thang_${month}`]);
      $(".total_kehoach_premonth").html(result.statistic[0][`thang_${month-1}`]);

      //Trong tháng
	  var percentDagiahan = result.statistic[0].total_dagiahan*100/result.statistic[0].total_sanluong;
      $(".total_dagiahan").html(`<span class="format-number">${result.statistic[0].total_dagiahan}</span> (${percentDagiahan.toFixed(2)}%)`);

	  var percentCapMoi = result.statistic[0].total_capmoi*100/result.statistic[0].total_sanluong;
      $(".total_capmoi").html(`<span class="format-number">${result.statistic[0].total_capmoi}</span> (${percentCapMoi.toFixed(2)}%) `);
	  
      $(".total_sanluong").html(result.statistic[0].total_sanluong);
      $(".total_cangiahan").html(result.statistic[0].total_cangiahan);
      $(".total_chuagiahan").html(result.statistic[0].total_chuagiahan);

      //lũy kế từ đầu năm
      $(".total_luykesanluong").html(result.statistic[0].total_luykesanluong);
      $(".total_luykethuhoi").html(result.statistic[0].total_luykethuhoi);
	  
      //Phái triển mới 
      $(".total_phattrienmoi_nam").html(`<span class="format-number">${result.statisticPtm[0].total_year}</span>`);
      $(".total_phattrienmoi_thang").html(`<span class="format-number">${result.statisticPtm[0][`thang_${month}`]}</span>`);

      // Gia hạn
      $(".total_giahan_nam").html(`<span class="format-number">${result.statisticGh[0].total_year}</span>`);
      $(".total_giahan_thang").html(`<span class="format-number">${result.statisticGh[0][`thang_${month}`]}</span>`);


	    var percentLuyKeDagiahan = result.statistic[0].total_luykedagiahan*100/result.statistic[0].total_luykesanluong;
      $(".total_luykedagiahan").html(`<span class="format-number">${result.statistic[0].total_luykedagiahan}</span> (${percentLuyKeDagiahan.toFixed(2)}%)`);
      $(".total_dagiahan2").html(`${result.statistic[0].total_dagiahan}`);
	  
	    var percentLuyKeCapMoi = result.statistic[0].total_luykecapmoi*100/result.statistic[0].total_luykesanluong;
      $(".total_luykecapmoi").html(`<span class="format-number">${result.statistic[0].total_luykecapmoi}</span> (${percentLuyKeCapMoi.toFixed(2)}%)`);
	  
      $(".total_luykecapbu").html(result.statistic[0].total_luykecapbu);

      //lũy kế từ đầu năm ngoái đến tháng tương ứng năm ngoái
      $(".total_luykesanluonglastyear").html(result.statistic[0].total_luykesanluonglastyear);
	  
      var diffluykesanluong = result.statistic[0].total_luykesanluonglastyear - result.statistic[0].total_luykesanluong;
      $(".total_diffluykesanluong").html(`<i class="fa ${diffluykesanluong < 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffluykesanluong)}</span>`);
	  
      $(".total_luykedagiahanlastyear").html(result.statistic[0].total_luykedagiahanlastyear);
	  
      var diffluykedagiahan = result.statistic[0].total_luykedagiahanlastyear - result.statistic[0].total_luykedagiahan;
      $(".total_diffluykedagiahan").html(`<i class="fa ${diffluykedagiahan < 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffluykedagiahan)}</span>`);
	  
      $(".total_luykecapmoilastyear").html(result.statistic[0].total_luykecapmoilastyear);
      
      var diffluykecapmoi = result.statistic[0].total_luykecapmoilastyear - result.statistic[0].total_luykecapmoi;
      $(".total_diffluykecapmoi").html(`<i class="fa ${diffluykecapmoi < 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffluykecapmoi)}</span>`);
      //tháng trước
      $(".total_premonthdagiahan").html(result.statistic[0].total_premonthdagiahan);
      $(".total_premonthcapmoi").html(result.statistic[0].total_premonthcapmoi);
	  
      var diffdagiahanpremonth = result.statistic[0].total_dagiahan - result.statistic[0].total_premonthdagiahan;
      $(".total_diffpremonthdagiahan").html(`<i class="fa ${diffdagiahanpremonth > 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffdagiahanpremonth)}</span>`);
        
      var diffcapmoipremonth = result.statistic[0].total_capmoi - result.statistic[0].total_premonthcapmoi; 
      $(".total_diffpremonthcapmoi").html(`<i class="fa ${diffcapmoipremonth > 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffcapmoipremonth)}</span>`);
      $(".total_premonthsanluong").html(result.statistic[0].total_premonthsanluong);
	  
	    var diffdiffpremonthsanluong = result.statistic[0].total_sanluong - result.statistic[0].total_premonthsanluong; 
	    $(".total_diffpremonthsanluong").html(`<i class="fa ${diffdiffpremonthsanluong > 0?'fa-arrow-up':'fa-arrow-down'}" aria-hidden="true"></i><span class="format-number">${Math.abs(diffdiffpremonthsanluong)}</span>`);

      $(".total_luykedanghoatdong").html(result.statistic[0].total_luykedanghoatdong);
      
      
      LoadDxDataGrid("#gridContainer", result.statisticTinh,'tinh', [
          {
            caption: 'STT',
            cellTemplate: function (container, options) {
				container.text(($('#gridContainer2').dxDataGrid("instance").option('paging.pageIndex') || 0) * ($('#gridContainer2').dxDataGrid("instance").option('paging.pageSize')) + options.row.rowIndex + 1);
            }
          },
          {
            caption: 'TTKD',
            dataField: 'tinh',
            dataType: 'string'
          },
          {
            caption: 'Sản lượng cấp mới',
            dataField: 'total_capmoi',
            dataType: 'number'
          },
          {
            caption: 'Sản lượng gia hạn',
            dataField: 'total_dagiahan',
            dataType: 'number'
          },
          {
            caption: 'Tổng sản lượng',
            dataField: 'total_sanluong',
            dataType: 'number'
          },
          {
            caption: 'Kế hoạch',
            dataField: `thang_${month}`,
            dataType: 'number'
          },
          {
            caption: 'So với Kế hoạch',
            dataType: 'number',
			sortOrder: "desc",
			allowSorting: true,
            cellTemplate: function (container, options) {  
              $("<div />").dxProgressBar({  
                  min: 0,  
                  max: 100,
                  value: options.data.percent_giahan*100, 
                  statusFormat(value) {
                    return `Tỷ lệ: ${(value * 100).toFixed(2)}%`;
                  },
              }).appendTo(container);  
            },
			calculateSortValue: function (rowData) {  
				return rowData.percent_giahan*100;  
			}
          }
        ], {
        },{
      });
      LoadDxDataGrid("#gridContainer2", result.statisticTinh,'tinh', [
          {
            caption: 'STT',
            cellTemplate: function (container, options) {
				container.text(($('#gridContainer2').dxDataGrid("instance").option('paging.pageIndex') || 0) * ($('#gridContainer2').dxDataGrid("instance").option('paging.pageSize')) + options.row.rowIndex + 1);
            }
          },
          {
            caption: 'TTKD',
            dataField: 'tinh',
            dataType: 'string'
          },
          {
            caption: 'Cần gia hạn',
            dataField: 'total_cangiahan',
            dataType: 'number'
          },
          {
            caption: 'Chưa gia hạn',
            dataField: 'total_chuagiahan',
            dataType: 'number'
          },
          {
            caption: 'Đã gia hạn',
            dataField: 'total_dagiahan',
            dataType: 'number'
          },
          {
            caption: 'Kế hoạch',
            dataField: `thang_${month}`,
            dataType: 'number'
          },
          {
            caption: 'Đã gia hạn so với Kế hoạch',
            dataType: 'number',
			sortOrder: "desc",
			allowSorting: true,
            cellTemplate: function (container, options) {  
              $("<div />").dxProgressBar({  
                  min: 0,  
                  max: 100,
                  value: options.data.percent_giahan*100, 
                  statusFormat(value) {
                    return `Tỷ lệ: ${(value * 100).toFixed(2)}%`;
                  },
              }).appendTo(container);  
            },
			calculateSortValue: function (rowData) {  
				return rowData.percent_giahan*100;  
			}  
          }
        ], {
        },{
      });
      
      $(".format-number" ).each(function( index ) {
        const numberString = DevExpress.localization.formatNumber(Number($(this).html()), ",##0.###");
        $(this).html(numberString);
      });
    });
  }
</script>
@endsection