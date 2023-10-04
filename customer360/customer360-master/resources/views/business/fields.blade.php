<div class="form-group col-sm-6">
	{!! Form::label('name', 'Tên lĩnh vực') !!}
	{!! Form::text('name', null, ['class'=>'form-control'])!!}
</div>
 
<div class="form-group col-sm-6">
	{!! Form::label('code', 'Code:') !!}
	{!! Form::text('code', null, ['class'=>'form-control']) !!}
</div>


<div class="d-flex align-items-center form-group col-sm-6">
	{!! Form::label('is_parent', 'Là thư mục cha:') !!}
	   <label class="switch switch-label switch-pill switch-primary ml-2">
		   {!! Form::hidden('is_parent', 0) !!}
		   {!! Form::checkbox('is_parent', 1, $is_parent,  ['class' => 'switch-input', 'id' => 'is_parent_cb']) !!}
		   <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
	   </label>
   </div>

<div class="form-group col-sm-6 business_list" id="business_list_form" style="display:{{$is_show}}">
	{!! Form::label('parent_id', 'Là lĩnh vực con của:') !!}
	{!! Form::select('parent_id', $business_list, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
	{!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
	<a href="{{ route('business.index') }}" class="btn btn-secondary">Cancel</a>
</div>