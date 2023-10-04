@extends('layouts.template')

@section('title','Doanh nghiệp')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1>Doanh nghiệp: {{$detail->vi_name}}</h1>
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
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane  fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3>Tên: {{$detail->vi_name}}</h3>
                        <p>Mã số thuế: {{$detail->mst}}</p>
                        <p>Miền: {{$detail->province}}</p>
                        <p>Tỉnh: {{$detail->city}}</p>
                        <p>Huyện/xã: {{$detail->district}}</p>
                        <p>Địa chỉ kinh doanh: {{$detail->location}}</p>
                        <p>Ngành nghề kinh doanh: {{$detail->business}}</p>
                        <p>Tên người quản lý: {{$detail->manager_name}}</p>
                        <p>Ngày sinh: {{$detail->manager_dob}}</p>
                        <p>ID: {{$detail->manager_id}}</p>
                        <p>Địa chỉ: {{$detail->manager_addr}}</p>
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

@endsection


@section('script')
<script>
</script>
@endsection