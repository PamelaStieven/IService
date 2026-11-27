@extends('main')

@section('titulo', 'Módulos - IService')

@section('conteudo')
<div class="container my-4">
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1">Módulos</h1>
        <p class="text-muted mb-0">Acesse as áreas do IService organizadas por categoria.</p>
    </div>
    <div class="row g-3">
        @foreach($categorias as $slug => $categoria)
            <div class="col-md-6 col-xl-3">
                <a href="{{ route('modulos.show', $slug) }}" class="card h-100 p-4 text-decoration-none text-dark shadow-sm border-0">
                    <h2 class="h5 fw-bold text-primary">{{ $categoria['titulo'] }}</h2>
                    <p class="text-muted mb-0">{{ $categoria['descricao'] }}</p>
                    <span class="small text-primary mt-3">{{ count($categoria['modulos']) }} módulos →</span>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
