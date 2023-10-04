@extends('layouts.template')

@section('title','Dashboard theo dõi doanh thu dịch vụ CA và SmartCA')
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
            <h1>Dashboard theo dõi doanh thu dịch vụ CA và SmartCA</h1>
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
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Năm: </label>
                            <div id="year"></div>                     
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Tháng: </label>
                            <div id="month"></div>  
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Trung tâm kinh doanh: </label>
                            <div id="tinh"></div>                        
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <label for="from" class="col-form-label">Loại CA: </label>
                            <div id="caTypes"></div>                      
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group advance-control">
                            <label for="from" class="col-form-label">Loại khách hàng: </label>
                            <div id="customerTypes"></div>
                          </div>
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group advance-control">
                            <label for="from" class="col-form-label">Gói dịch vụ: </label>
                            <div id="packages"></div>  
                          </div>
                        </div>
                        <!-- <div class="col-sm-3">
                          <div class="form-group advance-control">
                            <label for="from" class="col-form-label">Điểm trạm cung cấp: </label>
                            <div id="station"></div>
                          </div>
                        </div> -->
                        <div class="col-sm-3">
                          <div class="form-group">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <button type="button" id="btn-advance" class="btn btn-primary" onclick="ShowHideAdvanceControl()">Nâng cao</button>
                        <button type="button" id="btn-statistic" class="btn btn-primary ml-2" onclick="Statistic()">Thống kê</button>
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
                        <i class="fa fa-bar-chart"></i> 1.TỔNG DOANH THU LŨY KẾ NĂM 2022
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
                              <span class="info-box-number h6 text-primary" id="total_year"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Lũy kế từ đầu năm</span>
                              <span class="info-box-number h6 text-primary" id="total_luykegiahan"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Cấp mới</span>
                              <span class="info-box-number h6 text-primary" id="total_luyketaomoi"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                              <span class="info-box-text font-weight-bold">Gia hạn</span>
                              <span class="info-box-number h6 text-primary" id="total_luykegiahan"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div id="pie_luykegiahan"></div>
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
                            <i class="fa fa-bar-chart"></i> 2.DOANH THU THÁNG <span class="thang"></span>/<span class="year"></span>
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
                            <span class="info-box-number h6 text-primary" id="total_thang"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Doanh thu tháng</span>
                            <span class="info-box-number h6 text-primary" id="total_giahan"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Cấp mới</span>
                            <span class="info-box-number h6 text-primary" id="total_taomoi"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="info-box">
                          <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Gia hạn</span>
                            <span class="info-box-number h6 text-primary" id="total_giahan"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div id="pie_giahan"></div>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        <div class="searchresult-area row">
            <div class="col">
              <div class="card mb-3">
                <div class="card-body" class="collapse">
                  <div id="dxtab"></div>
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
	  $('.data-area').hide();
	  $('.searchresult-area').hide();
	$('#dxtab').dxTabs({
		dataSource:  [
		  { id: 0, text: 'Danh sách doanh thu TTKD',"target":"tab_sanluong" },
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
    var url = `/api/dashboard/ca-revenue?tinh=${tinh}&packages=${packages}&customerTypes=${customerTypes}&caTypes=${caTypes}&year=${year}&month=${month}`;
    // window.location.href = url;
    $(".thang").html(month);
    $(".year").html(year);
    $.getJSON(url).done(function(result) {
      console.log(result);
      var chartYearDataSource = [{
        "title": "Other",
        "val": result.statistic[0].total_year-result.statistic[0].total_luykegiahan
      }, {
        "title": "Lũy kế gia hạn",
        "val": result.statistic[0].total_luykegiahan
      }];
      var chartMonthDataSource = [{
        title: "Other",
        val: result.statistic[0][`thang_${month}`]-result.statistic[0].total_giahan
      }, {
        "title": "Lũy kế gia hạn",
        "val": result.statistic[0].total_giahan
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
        legend: {
          horizontalAlignment: 'right',
          verticalAlignment: 'top',
          margin: 0,
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
        title: 'So với kế hoạch năm',
        tooltip: {
          enabled: true,
          customizeTooltip(arg) {
            return {
              text: `${arg.valueText} - ${(arg.percent * 100).toFixed(2)}%`,
            };
          },
        },
        legend: {
          horizontalAlignment: 'right',
          verticalAlignment: 'top',
          margin: 0,
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
      $("#total_year").html(result.statistic[0].total_year);
      $("#total_thang").html(result.statistic[0][`thang_${month}`]);
      $("#total_luykegiahan").html(result.statistic[0].total_luykegiahan);
      $("#total_luyketaomoi").html(result.statistic[0].total_luyketaomoi);
      $("#total_giahan").html(result.statistic[0].total_giahan);
      $("#total_taomoi").html(result.statistic[0].total_taomoi);
      $("#percent_giahan").html(DevExpress.localization.formatNumber(result.statistic[0].percent_giahan, "percent"));
      $("#percent_luykegiahan").html(DevExpress.localization.formatNumber(result.statistic[0].percent_luykegiahan, "percent"));
      
      LoadDxDataGrid("#gridContainer", result.statisticTinh,'tinh', [
          {
            caption: 'TTKD',
            dataField: 'tinh',
            dataType: 'string'
          },
          {
            caption: 'Doanh thu cấp mới',
            dataField: 'total_taomoi',
            dataType: 'number'
          },
          {
            caption: 'Doanh thu gia hạn',
            dataField: 'total_giahan',
            dataType: 'number'
          },
          {
            caption: 'Tổng doanh thu',
            dataField: 'total_giahan',
            dataType: 'number'
          },
          {
            caption: 'Kế hoạch',
            dataField: `thang_${month}`,
            dataType: 'number'
          },
          {
            caption: 'So với Kế hoạch',
            dataType: 'string',
            cellTemplate: function (container, options) {  
              $("<div />").dxProgressBar({  
                  min: 0,  
                  max: 100,
                  value: options.data.percent_giahan*100, 
                  statusFormat(value) {
                    return `Tỷ lệ: ${(value * 100).toFixed(2)}%`;
                  },
              }).appendTo(container);  
            }
          }
        ], {
        },{
      });
    });
  }
</script>
@endsection