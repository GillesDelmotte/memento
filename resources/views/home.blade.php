@extends('layouts.app')

@section('content')
<div class="background"></div>
<div>
    <home-component route="{{$route}}"></home-component>
</div>
@endsection
