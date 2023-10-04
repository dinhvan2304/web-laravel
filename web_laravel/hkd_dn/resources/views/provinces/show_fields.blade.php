<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $province->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Tên tỉnh thành:') !!}
    <p>{{ $province->name }}</p>
</div>

<!-- Code Field -->
<div class="form-group">
    {!! Form::label('code', 'Mã:') !!}
    <p>{{ $province->code }}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Trạng thái kích hoạt:') !!}
    <p>{{ $province->status }}</p>
</div>

