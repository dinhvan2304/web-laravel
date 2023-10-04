@extends('layouts.template')

@section('title','Xu hướng')
@section('style')
<style>
.card-img-top {
    width: 100%;
    height: 15vw;
    object-fit: cover;
}
.card{
     height: 350px;
}
@media (max-width: 768px) {
    .carousel-inner .carousel-item > div {
        display: none;
    }
    .carousel-inner .carousel-item > div:first-child {
        display: block;
    }
}

.carousel-inner .carousel-item.active,
.carousel-inner .carousel-item-next,
.carousel-inner .carousel-item-prev {
    display: flex;
}

/* display 3 */
@media (min-width: 768px) {
    
    .carousel-inner .carousel-item-right.active,
    .carousel-inner .carousel-item-next {
      transform: translateX(33.333%);
    }
    
    .carousel-inner .carousel-item-left.active, 
    .carousel-inner .carousel-item-prev {
      transform: translateX(-33.333%);
    }
}

.carousel-inner .carousel-item-right,
.carousel-inner .carousel-item-left{ 
  transform: translateX(0);
}
</style>
@endsection
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Xu hướng</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">{{__('app.home')}}</a></li>
              <li class="breadcrumb-item active">Xu hướng</li>
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
               <div class="col">
                    <a class="float-right" href="/list?type=top">Xem thêm</a><h4>Tin mới nhất</h4>
               </div>
          </div>
          <div class="row">
               <div id="carouselExampleIndicators1" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox"></div>
                    <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators1" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#carouselExampleIndicators1" role="button" data-slide="next">
                         <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                    </a>
               </div>
          </div>
          <!-- /.card -->
          <div class="row">
               <div class="col">
                    <a class="float-right" href="/list?type=competitor">Xem thêm</a><h4>Tin đối thủ</h4>
               </div>
          </div>
          <div class="row">
               <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox"></div>
                    <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#carouselExampleIndicators2" role="button" data-slide="next">
                         <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                    </a>
               </div>
          </div>
          <!-- /.card -->
          <div class="row">
               <div class="col">
                    <a class="float-right" href="/list?type=vnpt">Xem thêm</a><h4>Tin VNPT</h4>
               </div>
          </div>
          <div class="row">
               <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox"></div>
                    <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators3" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#carouselExampleIndicators3" role="button" data-slide="next">
                         <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                    </a>
               </div>
          </div>
          <!-- /.card -->
          <div class="row">
               <div class="col">
                    <a class="float-right" href="/list?type=market">Xem thêm</a><h4>Tin thị trường</h4>
               </div>
          </div>
          <div class="row">
               <div id="carouselExampleIndicators4" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox"></div>
                    <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators4" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#carouselExampleIndicators4" role="button" data-slide="next">
                         <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                    </a>
               </div>
          </div>
          <!-- /.card -->
          <div class="row">
               <div class="col">
                    <a class="float-right" href="/list?type=vbpl">Xem thêm</a><h4>Tin chính sách, pháp luật</h4>
               </div>
          </div>
          <div class="row">
               <div id="carouselExampleIndicators5" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox"></div>
                    <a class="carousel-control-prev w-auto" href="#carouselExampleIndicators5" role="button" data-slide="prev">
                         <span class="carousel-control-prev-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#carouselExampleIndicators5" role="button" data-slide="next">
                         <span class="carousel-control-next-icon bg-dark border border-dark rounded-circle" aria-hidden="true"></span>
                         <span class="sr-only">Next</span>
                    </a>
               </div>
          </div>
          <!-- /.card -->
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
     <% 
          var publishDate = new Date(data[i]._source.publish_date);
          var mins = moment(publishDate).fromNow();
     %>
     <% if(i == 0) { %>
     <div class="carousel-item active mb-3">
     <% } %>
     <% if(i%5 == 0 && i != 0) { %>
          </div>
     </div>
     <div class="carousel-item mb-3">
     <% } %>
          <div class="col">
               <div class="card">
                    <img class="card-img-top" src="<%=((data[i]._source.feature_image && data[i]._source.feature_image.length > 0 && data[i]._source.feature_image[0] != '')? data[i]._source.feature_image[0]:'https://via.placeholder.com/250x250.png?text=Empty') %>">
                    <div class="card-body p-2">
                         <a target="_blank" href="<%=data[i]._source.href%>"><h6><%= data[i]._source.topic.trimToLength(100) %></h4></a>
                         
                         <!-- <p><%= data[i]._source.sapo.trimToLength(200) %></p> -->
                    </div>
                    <div class="card-footer">
                         <div><%= mins %> - <%=data[i]._source.newspaper%></div>
                         <a target="_blank" href="<%=data[i]._source.href%>">Xem chi tiết</a>
                    </div>
               </div>
          </div>
     <% if(i == data.length - 1) { %>
     </div>
     <% } %>
  <% } %>
</script>

@section('script')
<script type="text/html" id="item_vbpl_tmpl">
  <% for ( var i = 0; i < data.length; i++ ) { %>
     <% 
          var publishDate = new Date(data[i]._source.publish_date);
          var createdDate = new Date(data[i]._source.created_date);
          var mins = moment(createdDate).fromNow();
     %>
     <% if(i == 0) { %>
     <div class="carousel-item active mb-3">
     <% } %>
     <% if(i%5 == 0 && i != 0) { %>
          </div>
     </div>
     <div class="carousel-item mb-3">
     <% } %>
               <div class="col">
                    <div class="card">
                         <div class="card-body p-2">
                              <a target="_blank" href="<%=data[i]._source.href%>"><h6><%=data[i]._source.title%></h4></a>
                              <div class="card-text"><%= data[i]._source.description.trimToLength(200) %></div>
                              <div class="card-text"><%= data[i]._source.publishDate%></div>
                         </div>
                         <div class="card-footer">
                              <div><%= mins %> - vbpl.vn</div>
                              <a target="_blank" href="<%=data[i]._source.href%>">Xem chi tiết</a>
                         </div>
                    </div>
               </div>
     <% if(i == data.length - 1) { %>
     </div>
     <% } %>
  <% } %>
</script>
<script>

     $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "http://123.31.19.244:9200/newspaper_news/_search?sort=publish_date:desc",
            success: function (result) {
                 if(result.hits.total > 0){
                    $("#carouselExampleIndicators1 .carousel-inner").html(tmpl("item_tmpl", {'data': result.hits.hits}));

                 }
            }
        });
     $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "http://123.31.19.244:9200/newspaper_news/_search?q=category:competitor&sort=publish_date:desc",
            success: function (result) {
                 if(result.hits.total > 0){
                    $("#carouselExampleIndicators2 .carousel-inner").html(tmpl("item_tmpl", {'data': result.hits.hits}));

                 }
            }
        });
     $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "http://123.31.19.244:9200/newspaper_news/_search?q=vnpt&sort=publish_date:desc",
            success: function (result) {
                 if(result.hits.total > 0){
                    $("#carouselExampleIndicators3 .carousel-inner").html(tmpl("item_tmpl", {'data': result.hits.hits}));

                 }
            }
        });
     $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "http://123.31.19.244:9200/newspaper_news/_search?q=category:market&sort=publish_date:desc",
            success: function (result) {
                 if(result.hits.total > 0){
                    $("#carouselExampleIndicators4 .carousel-inner").html(tmpl("item_tmpl", {'data': result.hits.hits}));

                 }
            }
        });
     $.ajax({
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            url: "http://123.31.19.244:9200/vbpl/_search?sort=created_date:desc",
            success: function (result) {
                 if(result.hits.total > 0){
                    $("#carouselExampleIndicators5 .carousel-inner").html(tmpl("item_vbpl_tmpl", {'data': result.hits.hits}));

                 }
            }
        });
</script>
@endsection