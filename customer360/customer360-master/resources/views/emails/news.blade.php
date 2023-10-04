@extends('layouts.email')
@section('content')
<p><strong>Dear {{ $user->username }}</strong></p>
<table>
@foreach($hits as $aHit)
    <tr>
        <td>{{$loop->index+1}}</td>
        <td>    
            <a target="_blank" href="https://bid-khdn.vinaphone.vn/dashboard/detail-packages?so_tbmt={{ $aHit->so_tbmt}}"><b>{{ $aHit->so_tbmt}} - {{ $aHit->ten_goi_thau}} - {{ $aHit->ben_moi_thau}}</b></a>
        </td>
    </tr>
@endforeach
</table>
@stop
