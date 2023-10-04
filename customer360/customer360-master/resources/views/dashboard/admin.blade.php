@extends('layouts.template')

@section('title','Dashboard')

@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
		<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{__('app.dashboard')}}</h1>
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

      <!-- Small boxes (Stat box) -->
      @include('layouts.includes.alerts')
      @role('admin')
      <!-- Info boxes -->
        <div class="row mb-2">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <a href="{{route('user.index')}}"  Class="info-box-icon bg-dark elevation-1" data-toggle="tooltip" data-placement="bottom" title="See All Users"><i class="fa fa-users"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">{{__('app.total_users')}}</span>
                <span class="info-box-number lead">
                  {{$users}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box shadow p-3">
              <a href="{{route('user.index')}}"  Class="info-box-icon bg-navy elevation-1" data-toggle="tooltip" data-placement="bottom" title="See Users"><i class="fa fa-user-plus"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">{{__('app.new_users')}}</span>
                <span class="info-box-number lead">
                  {{$latest_users}}
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
              <a href="{{route('role.index')}}"  Class="info-box-icon bg-primary elevation-1" data-toggle="tooltip" data-placement="bottom" title="See Roles"><i class="fa fa-tag"></i></a>

              <div class="info-box-content">
                <span class="info-box-text">{{__('app.roles')}}</span>
                <span class="info-box-number lead">
                  {{$roles}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->



      <div class="row">

        <div class="col-lg-7 col-xs-11 h-100 mb-3">
          <!-- small box -->
          <div class="card bg-white shadow">
            <div class="card-header bg-primary">
              {{__('app.reg_history')}}
            </div>
            <div class="card-body">
              {!! $latestUser->container() !!}
              @if($latestUser)
                {!! $latestUser->script() !!}
              @endif
            </div>
          </div>
        </div>
        <!-- ./col -->
        
      </div>
		@endrole('admin')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
