@extends('layouts.public')

@section('content')
     <div class="container-fluid">
          <div class="animated fadeIn">
				@include('flash::message')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fa fa-plus-square-o fa-lg"></i>
                                <strong>Đăng ký</strong>
                            </div>
                            <div class="card-body">
                                {!! Form::open(['route' => 'public.enterprises.store']) !!}

                                <!-- Name Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('name', 'Tên doanh nghiệp:') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
                                </div>

                                <!-- Code Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('code', 'Mã số thuế:') !!}
                                    {!! Form::text('code', null, ['class' => 'form-control','maxlength' => 255, 'required' => 'required']) !!}
                                </div>

                                <!-- Address Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('address', 'Địa chỉ:') !!}
                                    {!! Form::text('address', null, ['class' => 'form-control','maxlength' => 255, 'required' => 'required']) !!}
                                </div>

                                <!-- Website Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('website', 'Website:') !!}
                                    {!! Form::text('website', null, ['class' => 'form-control','maxlength' => 255 ]) !!}
                                </div>

                                <!-- Field Id Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('field_id', 'Lĩnh vực:') !!}
                                    {!! Form::select('field_id', $fields, null, ['class' => 'form-control', 'required' => 'required']) !!}
                                </div>

                                <!-- Business Need Field -->
                                <div class="form-group col-sm-12 col-lg-12">
                                    {!! Form::label('business_need', 'Nhu cầu:') !!}
                                    {!! Form::textarea('business_need', null, ['class' => 'form-control']) !!}
                                </div>

                                <!-- Email Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('email', 'Email:') !!}
                                    {!! Form::email('email', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255, 'required' => 'required']) !!}
                                </div>

                                <!-- Phone Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('phone', 'Phone:') !!}
                                    {!! Form::text('phone', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255]) !!}
                                </div>

                                <!-- Province Id Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::label('province_id', 'Tỉnh thành:') !!}
                                    {!! Form::select('province_id', $provinces, null, ['class' => 'form-control']) !!}
                                </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <h5 class="pull-right">{{__('app.login_details')}}</h5>
                                                    <hr class="my-4">
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-row">
                                                        <div class="col-sm-4">
                                                            <label for="username" class="control-label">{{__('app.username')}}</label>
                                                            <input type="text" required name="username" value="{{old('username', @$enterprise->user->username)}}" class="form-control" id="username" placeholder="{{__('app.username')}}">
                                                            @if ($errors->has('username'))
                                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $errors->first('username') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="password" class="control-label">{{__('app.password')}}</label>
                                                            <input type="password" required name="password" class="form-control" id="password" placeholder="{{__('app.password')}}">
                                                            @if ($errors->has('password'))
                                                                <span class="text-danger" role="alert">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <label for="password_confirmation" class="control-label">{{__('app.confirm_password')}}</label>
                                                            <input type="password" required name="password_confirmation" class="form-control" id="password_confirmation" placeholder="{{__('app.confirm_password')}}">
                                                            @if ($errors->has('password_confirmation'))
                                                                <span class="text-danger" role="alert">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                              </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                <!-- Submit Field -->
                                <div class="form-group col-sm-12">
                                    {!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
           </div>
    </div>
@endsection
