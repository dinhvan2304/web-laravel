@extends('layouts.template')

@section('title','Dashboard')

@section('content')

  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard Tổng hợp viễn thông - CNTT</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">{{__('app.dashboard')}}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      @include('layouts.includes.alerts')
      
      <div class="row mb-2">
        <form action="/dashboard" method="get" id="searchForm" class="form-inline">
            <div class="form-group ml-2">
              <label for="from" class="col-form-label">Từ ngày: </label>
              <input type="date" class="form-control" name="start_day" required="required" value="{{ $start_day->format('Y-m-d') }}" />
            </div>
            <div class="form-group ml-2">
              <label for="from" class="col-form-label">đến ngày: </label>
              <input type="date" class="form-control" name="end_day" required="required" value="{{ $end_day->format('Y-m-d') }}" />
            </div>
            <div class="form-group ml-2">
              <button type="submit" id="btn-statistic" class="btn btn-primary">Thống kê</button>
            </div>
        </form>
      </div>
          
      <div class="row mb-2">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <div class="info-box-content">
                <span class="info-box-text">Tổng gói thầu</span>
                <span class="info-box-number lead">
                  <span class="number_packages format-number"></span>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <div class="info-box-content">
                <span class="info-box-text">Quy mô thầu</span>
                <span class="info-box-number lead">
                  <span class="number_packages_value format-number"></span>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>


          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <div class="info-box-content">
                <span class="info-box-text">Số gói thầu VNPT trúng</span>
                <span class="info-box-number lead">
                  <span class="number_vnpt format-number"></span>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <div class="info-box-content">
                <span class="info-box-text">Giá trị trúng thầu của VNPT</span>
                <span class="info-box-number lead">
                  <span class="number_vnpt_value format-number"></span>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
		<div class="row mb-2">
		  <div class="col-12 col-sm-6 col-md-3">
        <h3 class="text-center">Khối địa phương</h3>
		    <canvas id="canvas" height="80vh" width="40vw"></canvas>
        <h3 class="text-center">Lĩnh vực</h3>
        <div id="statistic_linhvuc"></div>
		  </div>
		  <div class="col-12 col-sm-6 col-md-9">
        <h3 class="text-center">Khối khách hàng</h3>
        <div class="row mb-2">
          <div class="col-12 col-sm-6 col-md-3">
            <div id="statistic_block_packages"></div>
          </div>
          <div class="col-12 col-sm-6 col-md-9">
            <div id="statistic_block_packages_value"></div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12 col-sm-6">
            <div id="top5_clients"></div>
          </div>
          <div class="col-12 col-sm-6">
            <div id="top5_competitors"></div>
          </div>
        </div>
		  </div>
		</div>
    <h3 class="text-center">Kết quả trúng thầu của VNPT</h3>
    <div class="row mb-2">
      <div class="col-12 col-sm-6 col-md-2">
        <div id="vnpt_statistic_packages"></div>
      </div>
      <div class="col-12 col-sm-6 col-md-2">
        <div id="vnpt_statistic_winjoins"></div>
      </div>
      <div class="col-12 col-sm-6 col-md-8">
        <div id="vnpt_statistic_units"></div>
      </div>
    </div>
    </section>
    
  </div>
@endsection

@section('script')
<script src="https://unpkg.com/chart.js@3"></script>
<script src="https://unpkg.com/chartjs-chart-geo@3"></script>

<script src=" https://cdn.jsdelivr.net/npm/d3@v6"></script>
<script src=" https://cdn.jsdelivr.net/npm/d3-composite-projections"></script>
<script>
  
  function LoadStatistic(){
    $.ajax({
        type: "GET",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        url: "{{url('/api/dashboard/statistic')}}?start_day={{ $start_day->format('Y-m-d') }}&end_day={{ $end_day->format('Y-m-d') }}",
        success: function (result) {
          console.log(result);
          //Hiển thị statistic
          $(".number_packages").html(`${result.number_packages}`);
          $(".number_vnpt").html(`${result.number_vnpt}`);
          $(".number_packages_value").html(`${result.number_packages_value}`);
          $(".number_vnpt_value").html(`${result.number_vnpt_value}`);
          //Load map
          $.getJSON("/js/diaphantinh.topojson", function (data) {
              var featureCollection = {};
              var topology = {};
			        var regions = ChartGeo.topojson.feature(data, data.objects["diaphantinh.geojson.txt"]).features;
              var codes = regions.map((d) => d.properties.code);
              var chart = new Chart(document.getElementById("canvas").getContext("2d"),{
                type: "choropleth",
                data: {
                  labels: regions.map((d) => d.properties.name),
                  datasets: [
                    {
                      outline: regions,
                      showOutline: true,
                      data: regions.map((d, index) => ({
                        feature: d,
                        value: function (i){
                          var aEl = result.statistic_province.find(element => element.province_code == codes[i]);
                          if(!aEl){
                            return 0;
                          }
                          return aEl.number_packages;
                        }(index)
                      }))
                    }
                  ]
                },
                options: {
                  plugins: {
                    legend: {
                      display: false
                    },
                  },
                  scales: {
                    xy: {
                      projection: "mercator"
                    },
                    color: {
                      quantize: 50,
                      legend: {
                        position: "bottom-left",
                        title: {
                          color: "red"
                        }
                      }
                    }
                  },
                }
              });
            }
          );
            
		

          //Vẽ chart thống kê khối khách hàng
          $('#statistic_block_packages').dxPieChart({
            palette: 'bright',
            dataSource: result.statistic_block_packages,
            series: [
              {
                argumentField: 'name',
                valueField: 'number_packages',
              },
            ],
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            legend:{
              visible: false
            },
          });
          $('#statistic_block_packages_value').dxChart({
            dataSource: result.statistic_block_packages_value,
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            argumentAxis: {
              label: {
                visible: false,
              },
            },
            valueAxis: [{
              name: 'packages',
              position: 'left',
            }, {
              name: 'packages_value',
              position: 'right',
            }],
            commonSeriesSettings: {
              argumentField: 'name',
            },
            series: [{
              type: 'bar',
              valueField: 'number_packages',
              axis: 'packages',
              name: 'Số gói',
              color: '#fac29a',
            }, {
              type: 'spline',
              valueField: 'total_gia_trung_thau',
              axis: 'packages_value',
              name: 'Quy mô',
              color: '#6b71c3',
            }],
            legend: {
              verticalAlignment: 'top',
              horizontalAlignment: 'center',
            },
          });
          //Vẽ pie chart lĩnh vực
          $('#statistic_linhvuc').dxPieChart({
            palette: 'bright',
            dataSource: result.statistic_linhvuc,
            series: [
              {
                argumentField: 'linh_vuc',
                valueField: 'total_packages',
              },
            ],
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            legend:{
              visible: false
            },
          });

          //Vẽ chart top 5 nhà thầu, top 5 bên mời thầu
          $('#top5_clients').dxChart({
            palette: 'Harmony Light',
            dataSource: result.top5_clients,
            title: 'Top 5 bên mời thầu',
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            argumentAxis: {
              label: {
                visible: false,
              },
            },
            valueAxis: [{
              name: 'packages',
              position: 'left',
            }, {
              name: 'packages_value',
              position: 'right',
            }],
            commonSeriesSettings: {
              argumentField: 'company_name',
            },
            series: [{
              type: 'bar',
              valueField: 'number_packages',
              axis: 'packages',
              name: 'Số gói',
              color: '#fac29a',
            }, {
              type: 'spline',
              valueField: 'total_gia_trung_thau',
              axis: 'packages_value',
              name: 'Quy mô',
              color: '#6b71c3',
            }],
            legend: {
              verticalAlignment: 'top',
              horizontalAlignment: 'center',
            },
          });
          $('#top5_competitors').dxChart({
            palette: 'Harmony Light',
            dataSource: result.top5_competitors,
            title: 'Top 5 nhà thầu',
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            argumentAxis: {
              label: {
                visible: false,
              },
            },
            valueAxis: [{
              name: 'packages',
              position: 'left',
            }, {
              name: 'packages_value',
              position: 'right',
            }],
            commonSeriesSettings: {
              argumentField: 'name_vi',
            },
            series: [{
              type: 'bar',
              valueField: 'number_packages',
              axis: 'packages',
              name: 'Số gói',
              color: '#fac29a',
            }, {
              type: 'spline',
              valueField: 'total_gia_trung_thau',
              axis: 'packages_value',
              name: 'Quy mô',
              color: '#6b71c3',
            }],
            legend: {
              verticalAlignment: 'top',
              horizontalAlignment: 'center',
            },
          });
          //Vẽ chart thống kê của VNPT
          $('#vnpt_statistic_packages').dxPieChart({
            dataSource: result.vnpt_statistic_packages,
            series: [
              {
                argumentField: 'name',
                valueField: 'number_packages',
              },
            ],
            title: 'Phân loại gói thầu',
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            legend:{
              visible: false
            },
          });
          $('#vnpt_statistic_winjoins').dxPieChart({
            dataSource: result.vnpt_statistic_winjoins,
            series: [
              {
                argumentField: 'name',
                valueField: 'total_packages',
              },
            ],
            title: 'Tỷ lệ trúng thầu',
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            legend:{
              visible: false
            },
          });
          $('#vnpt_statistic_units').dxChart({
            dataSource: result.vnpt_statistic_units,
            title: 'Top 5 đơn vị thuộc VNPT',
            rotated: true,
            argumentAxis: {
              label: {
                overlappingBehavior: 'stagger',
              },
            },
            tooltip: {
              enabled: true,
              shared: true,
              customizeTooltip(arg) {
                const valueText = DevExpress.localization.formatNumber(Number(arg.originalValue), ",##0.###");
                return {
                  text: `${arg.seriesName}: ${valueText} <br /><b>${arg.argumentText}</b>`,
                };
              },
            },
            argumentAxis: {
              label: {
                visible: false,
              },
            },
            valueAxis: [{
              name: 'packages',
              position: 'top',
            }, {
              name: 'packages_value',
              position: 'bottom',
            }],
            commonSeriesSettings: {
              argumentField: 'name_vi',
            },
            series: [{
              type: 'bar',
              valueField: 'number_packages',
              axis: 'packages',
              name: 'Số gói',
              color: '#fac29a',
            }, {
              type: 'spline',
              valueField: 'total_gia_trung_thau',
              axis: 'packages_value',
              name: 'Quy mô',
              color: '#6b71c3',
            }],
            legend: {
              verticalAlignment: 'top',
              horizontalAlignment: 'center',
            },
          });
          $(".format-number" ).each(function( index ) {
            const numberString = DevExpress.localization.formatNumber(Number($(this).html()), ",##0.###");
            $(this).html(numberString);
          });
        }
    });
    
  }
  $(function() {
	  
	LoadStatistic();
  });
</script>
@endsection