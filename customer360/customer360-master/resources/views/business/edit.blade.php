@extends('layouts.app')

@section('content')
    <ol class="breadcrumb">
          <li class="breadcrumb-item">
             <a href="{!! route('business.index') !!}">Business</a>
          </li>
          <li class="breadcrumb-item active">Edit</li>
        </ol>
    <div class="container-fluid">
         <div class="animated fadeIn">
             @include('coreui-templates::common.errors')
             <div class="row">
                 <div class="col-lg-12">
                      <div class="card">
                          <div class="card-header">
                              <i class="fa fa-edit fa-lg"></i>
                              <strong>Edit Field</strong>
                          </div>
                          <div class="card-body">
                              {!! Form::model($business, ['route' => ['business.update', $business], 'method' => 'patch']) !!}

                              @include('business.fields')

                              {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
         </div>
    </div>
@endsection
@section('script')
<script>
	$('#is_parent_cb').change(function() {
		if($(this).is(":checked")){  //Return true/false 
			$("#business_list_form").fadeOut('fast');
		}else{
			$("#business_list_form").fadeIn('fast');
		}
	});
</script>
@endsection