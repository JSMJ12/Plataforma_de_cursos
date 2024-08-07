@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container">
        @if (session('info'))
            <div class="alert alert-info">
                {{ session('info') }}
            </div>
        @endif
    </div>
</div>
@endsection