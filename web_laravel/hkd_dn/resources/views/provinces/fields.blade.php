<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Tên tỉnh thành:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Code Field -->
<div class="form-group col-sm-6">
    {!! Form::label('code', 'Mã:') !!}
    {!! Form::text('code', null, ['class' => 'form-control']) !!}
</div>

<!-- 'bootstrap / Toggle Switch Status Field' -->
<div class="d-flex align-items-center form-group col-sm-6">
 {!! Form::label('status', 'Trạng thái kích hoạt:') !!}
    <label class="switch switch-label switch-pill switch-primary  ml-2">
        {!! Form::hidden('status', 0) !!}
        {!! Form::checkbox('status', 1, null,  ['class' => 'switch-input']) !!}
        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
    </label>
</div>


<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Ghi', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('provinces.index') }}" class="btn btn-secondary">Hủy</a>
</div>
