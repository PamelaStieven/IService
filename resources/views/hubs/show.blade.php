@extends('main')

@section('titulo', $grupo['titulo'] . ' - IService')

@section('conteudo')
<div class="container my-4">
    <a href="{{ route('modulos.index') }}" class="text-decoration-none small">&larr; Todas as categorias</a>
    <div class="my-3">
        <h1 class="h3 fw-bold mb-1">{{ $grupo['titulo'] }}</h1>
        <p class="text-muted mb-0">{{ $grupo['descricao'] }}</p>
    </div>
    <div class="row g-3">
        @foreach($grupo['modulos'] as $modulo)
            <div class="col-md-6 col-xl-4">
                <a href="{{ route($modulo['route']) }}" class="card h-100 p-4 text-decoration-none text-dark shadow-sm border-0">
                    <h2 class="h5 fw-bold text-primary">{{ $modulo['nome'] }}</h2>
                    <p class="text-muted mb-0">{{ $modulo['descricao'] }}</p>
                    <span class="small text-primary mt-3">Abrir módulo &rarr;</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
