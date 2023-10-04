<!-- So Dkkd Field -->
<div class="form-group col-sm-6">
    {!! Form::label('so_dkkd', 'So Dkkd:') !!}
    {!! Form::text('so_dkkd', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Vi Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_vi', 'Name Vi:') !!}
    {!! Form::text('name_vi', null, ['class' => 'form-control']) !!}
</div>

<!-- Name En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_en', 'Name En:') !!}
    {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
</div>

<!-- C Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_status', 'C Status:') !!}
    {!! Form::text('c_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Linh Vuc Field -->
<div class="form-group col-sm-6">
    {!! Form::label('linh_vuc', 'Linh Vuc:') !!}
    {!! Form::text('linh_vuc', null, ['class' => 'form-control']) !!}
</div>

<!-- Loai Doanh Nghiep Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loai_doanh_nghiep', 'Loai Doanh Nghiep:') !!}
    {!! Form::text('loai_doanh_nghiep', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Fax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fax', 'Fax:') !!}
    {!! Form::text('fax', null, ['class' => 'form-control']) !!}
</div>

<!-- C Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_address', 'C Address:') !!}
    {!! Form::text('c_address', null, ['class' => 'form-control']) !!}
</div>

<!-- Province Field -->
<div class="form-group col-sm-6">
    {!! Form::label('province', 'Province:') !!}
    {!! Form::text('province', null, ['class' => 'form-control']) !!}
</div>

<!-- Country Field -->
<div class="form-group col-sm-6">
    {!! Form::label('country', 'Country:') !!}
    {!! Form::text('country', null, ['class' => 'form-control']) !!}
</div>

<!-- Nganh Nghe Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nganh_nghe', 'Nganh Nghe:') !!}
    {!! Form::text('nganh_nghe', null, ['class' => 'form-control']) !!}
</div>

<!-- C Group Field -->
<div class="form-group col-sm-6">
    {!! Form::label('c_group', 'C Group:') !!}
    {!! Form::text('c_group', null, ['class' => 'form-control']) !!}
</div>

<!-- Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('link', 'Link:') !!}
    {!! Form::text('link', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('competitors.index') }}" class="btn btn-secondary">Cancel</a>
</div>
