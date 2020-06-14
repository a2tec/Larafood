@extends('adminlte::page')

@section('title', "Editar o usuário {$user->name}")

@section('content_header')
    <h1>Editar o usuário {{ $user->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $user->id) }}" class="form" method="POST">
                @csrf
                @method('PUT')

                @include('admin.paginas.usuarios._partials.form')
            </form>
        </div>
    </div>
@endsection
