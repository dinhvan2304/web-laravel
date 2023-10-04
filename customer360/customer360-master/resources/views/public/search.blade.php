@extends('layouts.template')

@section('title','Create Role')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Tìm kiếm</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">Tìm kiếm</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <div class="row">
        <!-- right column -->
        <div class="col-md-12 mx-auto">
            @include('layouts.includes.alerts')
                <!-- Contact Details -->
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-row mb-1">
                            <div class="col-sm-3 form-group row">
                              <select class="form-control" id="type" name="type">
                                <option value="_all">All</option>
                                <option value="vbpl">Văn bản</option>
                                <option value="newspaper_news">Tin tức</option>
                                <option value="doanhnghiep">Doanh nghiệp</option>
                                <option value="thong_tin_goi_thau">Thông tin gói thầu</option>
                                <option value="scope_tender">Thông tin phạm vi cung cấp gói thầu</option>
                              </select>
                            </div>
                            <div class="col-sm-6 form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Tìm kiếm</label>
                                <div class="col-sm-10">
                                  <input type="text" name="search" value="" placeholder="VD: Eoffice, ..." class="form-control" id="search">
                                </div>
                            </div>
                            <div class="col-sm-3">
                              <button class="btn btn-primary col-md-12" id="btnSearch">Tìm kiếm</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 mb-2">
                          <h5>Kết quả</h5>
                        </div>
                        <div class="col-md-12" id="searchResult">
                          <div id="searchResultContainer">
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                </div>
        </div>
        
          <!-- /.card -->
        </div>
      <!-- /.row -->
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection



@section('script')
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
	  <% } else if (data[i]._index == "thong_tin_goi_thau") { %>
		 <% 
			  var publishDate = moment(data[i]._source['@timestamp']).format("YYYY-MM-DD HH:mm:ss");
		 %>
		<div class="row">
		  <div class="col-md-12">
			  <div class="card">
					<div class="card-body p-2">
						<a target="_blank" href="<%=data[i]._source.link%>"><h5 class="card-title font-weight-bold"><%=data[i]._source.so_tbmt%></h5></a>
						<div class="card-text"><%= data[i]._source.ten_goi_thau%></div>
						<div><%= publishDate%></div>
					</div>
			  </div>
		  </div>
		</div>
	  <% } else if (data[i]._index == "clients") { %>
		 <% 
			  var publishDate = moment(data[i]._source['created_date']).format("YYYY-MM-DD");
		 %>
		<div class="row">
		  <div class="col-md-12">
			  <div class="card">
					<div class="card-body p-2">
						<a target="_blank" href="<%=data[i]._source.href%>"><h5 class="card-title font-weight-bold"><%=data[i]._source.vi_name%></h5></a>
						<div class="card-text">Tên người đại diện: <%= data[i]._source.manager_name%></div>
            <div class="card-text">Số điện thoại liên hệ: <%= data[i]._source.phone%></div>
            <div class="card-text">Ngành nghề kinh doanh: <%= data[i]._source.business%></div>
						<div>Ngày thành lập: <%= publishDate%></div>
					</div>
			  </div>
		  </div>
		</div>
	  <% } else if (data[i]._index == "scope_tender") { %>
		 <% 
			  var publishDate = moment(data[i]._source['insertion_time']).format("YYYY-MM-DD HH:mm:ss");
		 %>
		<div class="row">
		  <div class="col-md-12">
			  <div class="card">
					<div class="card-body p-2">
						<a target="_blank" href="<%=data[i]._source.href%>"><h5 class="card-title font-weight-bold"><%=data[i]._source.so_tbmt%></h5></a>
						<div class="card-text">Danh mục: <%= data[i]._source.danh_muc%></div>
						<div class="card-text">Khối lượng: <%= data[i]._source.khoi_luong%></div>
						<div class="card-text">Ghi chú: <%= data[i]._source.ghi_chu%></div>
						<div><%= publishDate%></div>
					</div>
			  </div>
		  </div>
		</div>
	  <% } %>
  <% } %>
</script>

<script>
    $(function () {
        $("#type").select2({
            tags: true,
            tokenSeparators: [',']
        })
    });
    $("#btnSearch" ).click(function() {
      var search = $("#search").val();
      var type = $("#type").val();
      // $.ajax({
      //   type: "GET",
      //   contentType: "application/json; charset=utf-8",
      //   dataType: "json",
      //   async: false,
      //   url: `http://123.31.19.244:9200/newspaper_news/_search?q=${search}&sort=publish_date:desc`,
      //   success: function (result) {
      //     console.log(result);
      //     testRet = result;
      //     if(result.hits.total > 0){
      //       $("#searchResult").html(tmpl("item_tmpl", {'data': result.hits.hits}));
      //     }
      //   }
      // });
	  var url = `http://123.31.19.244:9200/_all/_search?q="${search}"`;
	  if(type == "vbpl"){
			url = `http://123.31.19.244:9200/vbpl/_search?q="${search}"&sort=created_date:desc`;
	  }else if(type == "newspaper_news"){
			url = `http://123.31.19.244:9200/newspaper_news/_search?q="${search}"&sort=publish_date:desc`;
	  }else if(type == "doanhnghiep"){
			url = `http://123.31.19.244:9200/clients/_search?q="${search}"&sort=insertion_time:desc`;
	  }else if(type == "thong_tin_goi_thau"){
			url = `http://123.31.19.244:9200/thong_tin_goi_thau/_search?q="${search}"&sort=@timestamp:desc`;
	  }else if(type == "scope_tender"){
			url = `http://123.31.19.244:9200/scope_tender/_search?q="${search}"&sort=insertion_time:desc`;
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
    });
    
    $('#search').keypress(function(e){
        if(e.which == 13){//Enter key pressed
            $('#btnSearch').click();//Trigger search button click event
        }
    });
</script>
@endsection