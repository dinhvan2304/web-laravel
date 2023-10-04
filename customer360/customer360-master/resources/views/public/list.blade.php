@extends('layouts.template')

@section('title','Xu hướng')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Danh sách</h1>
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
            <div class="col-md-12" id="searchResult">
              <div id="searchResultContainer">
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
String.prototype.trimToLength = function(m) {
  return (this.length > m) 
    ? jQuery.trim(this).substring(0, m).split(" ").slice(0, -1).join(" ") + "..."
    : this;
};
</script>
<script type="text/html" id="item_tmpl">
  <% for ( var i = 0; i < data.length; i++ ) { %>
	  <% if (data[i]._index == "newspaper_news") { %>
		 <% 
			  var publishDate = moment(data[i]._source.publish_date).format("YYYY-MM-DD HH:mm:ss");
		 %>
		<div class="row">
		  <div class="col-md-12">
			  <div class="card">
					<div class="card-body p-2">
						<a target="_blank" href="<%=data[i]._source.href%>"><h5 class="card-title font-weight-bold"><%=data[i]._source.topic%></h5></a>
						<div class="card-text"><%= data[i]._source.sapo%></div>
						<div><%= publishDate%> - <%=data[i]._source.newspaper%></div>
					</div>
			  </div>
		  </div>
		</div>
	  <% } else if (data[i]._index == "vbpl") { %>
		 <% 
			  var publishDate = moment(data[i]._source.created_date).format("YYYY-MM-DD HH:mm:ss");
		 %>
		<div class="row">
		  <div class="col-md-12">
			  <div class="card">
					<div class="card-body p-2">
						<a target="_blank" href="<%=data[i]._source.href%>"><h5 class="card-title font-weight-bold"><%=data[i]._source.title%></h5></a>
						<div class="card-text"><%= data[i]._source.description%></div>
						<div><%= publishDate%> - <%=data[i]._source.newspaper%></div>
					</div>
			  </div>
		  </div>
		</div>
	  <% } %>
  <% } %>
</script>
<script>

      var type = '{{ app('request')->input('type') }}';
	  var url = ``;
	  if(type == "vbpl"){
			url = `http://123.31.19.244:9200/vbpl/_search?sort=publish_date:desc`;
	  }else if(type == "top"){
			url = `http://123.31.19.244:9200/newspaper_news/_search?sort=publish_date:desc`;
	  }else if(type == "competitor"){
			url = `http://123.31.19.244:9200/newspaper_news/_search?q=category:competitor&sort=publish_date:desc`;
	  }else if(type == "vnpt"){
			url = `http://123.31.19.244:9200/newspaper_news/_search?q=vnpt&sort=publish_date:desc`;
	  }else if(type == "market"){
			url = `http://123.31.19.244:9200/newspaper_news/_search?q=category:market&sort=publish_date:desc`;
	  }
	  
      $('#searchResult').pagination({
          dataSource: url,
          locator: 'hits.hits',
          totalNumberLocator: function(response) {
              return response.hits.total;
          },
          alias: {
              pageNumber: 'from',
              pageSize: 'size'
          },
          ajax: {
              beforeSend: function(xObj, settings) {
                const urlParams = new URLSearchParams(settings.url);
                let from = urlParams.get('from');
                let size = urlParams.get('size');
                from = Number(size)*(Number(from)-1);
                settings.url = `${url}&from=${from}&size=${size}`;
                console.log(xObj);
              }
          },
          pageSize: 10,
          callback: function(data, pagination) {
            $("#searchResultContainer").html(tmpl(`item_tmpl`, {'data': data}));
          }
      })
</script>
@endsection