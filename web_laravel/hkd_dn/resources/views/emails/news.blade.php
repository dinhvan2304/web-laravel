@extends('layouts.email')
@section('content')
<p><strong>Dear {{ $user->username }}</strong></p>
<table>
@foreach($hits as $aHit)
    <tr>
        <td>{{$loop->index+1}}</td>
        <td>    
            @if($aHit->_index == 'vbpl')
            <a target="_blank" href="{{ $aHit->_source->href}}"><b>{{ $aHit->_source->title}}</b></a>
            @elseif($aHit->_index == 'newspaper_news')
            <a target="_blank" href="{{ $aHit->_source->href}}"><b>{{ $aHit->_source->topic}}</b></a>
            @endif
        </td>
    </tr>
@endforeach
</table>
@stop
