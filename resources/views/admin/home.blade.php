@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ route('admin.places') }}" class="btn btn-info">{{ __('Places') }}</a>
                    <a href="{{ route('admin.timetables') }}" class="btn btn-info">{{ __('Timetables') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
