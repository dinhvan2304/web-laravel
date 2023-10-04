@extends('layouts.template')

@section('title','Gói thầu')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Thống kê danh sách HKD theo địa bàn</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">Danh sách</li>
            </ol>
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
                <div class="card-header">
                      <a data-toggle="collapse" href="#chart_card" aria-expanded="true" aria-controls="chart_card">
                      <div class="mb-0">
                          <i class="fa fa-bar-chart"></i> Thống kê doanh nghiệp thành lập
                          <i class="fa fa-angle-down rotate-icon"></i>
                      </div>
                  </a>
                </div>
                <div class="card-body" id="chart_card" class="collapse">
                  <div class="row">
                    <form action="/dashboard/statistic-newclients" method="get" id="searchForm" class="form-inline">
                        <div class="form-group ml-2">
                          <label for="from" class="col-form-label">Thành lập từ: </label>
                          <input type="date" class="form-control" name="start_day" required="required" value="{{ $start_day->format('Y-m-d') }}" />
                        </div>
                        <div class="form-group ml-2">
                          <label for="from" class="col-form-label">đến: </label>
                          <input type="date" class="form-control" name="end_day" required="required" value="{{ $end_day->format('Y-m-d') }}" />
                        </div>
                        <div class="form-group ml-2">
                          <button type="submit" id="btn-statistic" class="btn btn-primary">Thống kê</button>
                          <button type="button" id="btn-export" class="btn btn-primary ml-2">Xuất danh sách</button>
                        </div>
                    </form>
                  </div>
                  <div class="row">
                      <div class="col">
                        <label>Total: {{$enterpriseTotal}}</label>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col">
                        <label>Theo vùng miền</label>
                        <canvas id="enterpriseStats" class="w-100"></canvas>
                      </div>
                      <div class="col">
                        <label>Top 5 địa phương</label>
                        <canvas id="enterpriseProvinceStats" class="w-100"></canvas>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col">
                        <label>Theo Lĩnh vực</label>
                        <canvas id="enterpriseFieldStats" class="w-100"></canvas>
                      </div>
                      <div class="col">
                        <label>Theo mạng di động</label>
                        <canvas id="enterpriseTelcoStats" class="w-100"></canvas>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col">
                        <label>Theo Loại hình doanh nghiệp</label>
                        <canvas id="enterpriseTypeStats" class="w-100"></canvas>
                      </div>
                      <div class="col">
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
  
  @foreach($enterpriseStats as $key => $value)
  labelArr.push('{{$value->province}}');
  dataArr.push({{$value->total}});
  @endforeach
  @foreach($enterpriseProvinceStats as $key => $value)
  labelProvinceArr.push('{{$value->province_code}}');
  dataProvinceArr.push({{$value->total}});
  @endforeach
  @foreach($enterpriseFieldStats as $key => $value)
  labelFieldArr.push('{{$value->main_business_code}}');
  dataFieldArr.push({{$value->total}});
  @endforeach
  @foreach($enterpriseTelcoStats as $key => $value)
  labelTelcoArr.push('{{$value->telco}}');
  dataTelcoArr.push({{$value->total}});
  @endforeach
  @foreach($enterpriseTypeStats as $key => $value)
  labelTypeArr.push('{{$value->enterprise_type}}');
  dataTypeArr.push({{$value->total}});
  @endforeach

  var myChart = new Chart( document.getElementById("enterpriseStats"), {
    type: 'doughnut',
    data: {
      labels: labelArr,
      datasets: [{
        data: dataArr,
        backgroundColor: [
          'rgba(255, 99, 132, 0.5)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: false,
      tooltips: {
        enabled: false
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let datasets = ctx.chart.data.datasets;
            if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
              let sum = datasets[0].data.reduce((a, b) => a + b, 0);
              let percentage = Math.round((value / sum) * 100) + '%';
              return percentage;
            } else {
              return percentage;
            }
          },
          color: '#000',
        }
      }
    }
  });
  var myChart2 = new Chart( document.getElementById("enterpriseProvinceStats"), {
    type: 'doughnut',
    data: {
      labels: labelProvinceArr,
      datasets: [{
        data: dataProvinceArr,
        backgroundColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderWidth: 1
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: false,
      tooltips: {
        enabled: false
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let datasets = ctx.chart.data.datasets;
            if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
              let sum = datasets[0].data.reduce((a, b) => a + b, 0);
              let percentage = Math.round((value / sum) * 100) + '%';
              return percentage;
            } else {
              return percentage;
            }
          },
          color: '#000',
        }
      }
    }
  });
  var myChart3 = new Chart( document.getElementById("enterpriseFieldStats"), {
    type: 'doughnut',
    data: {
      labels: labelFieldArr,
      datasets: [{
        data: dataFieldArr,
        backgroundColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderWidth: 1
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: false,
      tooltips: {
        enabled: false
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let datasets = ctx.chart.data.datasets;
            if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
              let sum = datasets[0].data.reduce((a, b) => a + b, 0);
              let percentage = Math.round((value / sum) * 100) + '%';
              return percentage;
            } else {
              return percentage;
            }
          },
          color: '#000',
        }
      }
    }
  });
  var myChart4 = new Chart( document.getElementById("enterpriseTelcoStats"), {
    type: 'doughnut',
    data: {
      labels: labelTelcoArr,
      datasets: [{
        data: dataTelcoArr,
        backgroundColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderWidth: 1
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: false,
      tooltips: {
        enabled: false
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let datasets = ctx.chart.data.datasets;
            if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
              let sum = datasets[0].data.reduce((a, b) => a + b, 0);
              let percentage = Math.round((value / sum) * 100) + '%';
              return percentage;
            } else {
              return percentage;
            }
          },
          color: '#000',
        }
      }
    }
  });
  var myChart5 = new Chart( document.getElementById("enterpriseTypeStats"), {
    type: 'doughnut',
    data: {
      labels: labelTypeArr,
      datasets: [{
        data: dataTypeArr,
        backgroundColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderColor: [
          '#CD24DF',
          '#114DFC',
          '#9B6C63',
          '#90BB9C',
          '#EE7F29',
          '#F81086',
          '#116699',
          '#E8B152',
          '#23DB19',
          '#A53BED'
        ],
        borderWidth: 1
      }]
    },
    options: {
      //cutoutPercentage: 40,
      responsive: false,
      tooltips: {
        enabled: false
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let datasets = ctx.chart.data.datasets;
            if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
              let sum = datasets[0].data.reduce((a, b) => a + b, 0);
              let percentage = Math.round((value / sum) * 100) + '%';
              return percentage;
            } else {
              return percentage;
            }
          },
          color: '#000',
        }
      }
    }
  });
  $("#btn-statistic").click(function(e) {
    e.preventDefault();
    $('#searchForm').attr('action', "/dashboard/statistic-newclients").submit();
  });
  $("#btn-export").click(function(e) {
    e.preventDefault();
    $('#searchForm').attr('action', "/export").submit();
  });
</script>
@endsection