@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('you are logged in to the Admin dashboard') }}
                </div>
            </div>
            <a href="{{ route('hpbase.index') }}" class="btn btn-md btn-success mb-3">Data</a>
            <a href="{{ route('mod.index') }}" class="btn btn-md btn-success mb-3">Kategori</a>
            <a href="{{ route('suplai.index') }}" class="btn btn-md btn-success mb-3">Suplier</a>
        </div>
    </div>
</div>
@endsection