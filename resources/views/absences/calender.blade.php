@extends('layouts.app')

@section('content')
    {!! $calendar->calendar() !!}
    {!! $calendar->script() !!}
@endsection
