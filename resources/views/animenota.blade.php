@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Animes</h1>
    
    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('animes.index') }}">
                <div class="row">
                    <!-- Filtro por Gênero -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Gêneros:</label>
                        <div class="generos-container" style="max-height: 200px; overflow-y: auto;">
                            @foreach($allGeneros as $genero)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" 
                                           name="generos[]" 
                                           id="genero_{{ Str::slug($genero) }}" 
                                           value="{{ $genero }}"
                                           {{ in_array($genero, request('generos', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="genero_{{ Str::slug($genero) }}">
                                        {{ $genero }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Filtro por Ano -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ano de Lançamento:</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" placeholder="De" 
                                       name="ano_inicio" value="{{ request('ano_inicio') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" placeholder="Até" 
                                       name="ano_fim" value="{{ request('ano_fim') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filtro por Nota -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nota:</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" step="0.1" min="0" max="10" class="form-control" 
                                       placeholder="Mínima" name="nota_min" value="{{ request('nota_min') }}">
                            </div>
                            <div class="col">
                                <input type="number" step="0.1" min="0" max="10" class="form-control" 
                                       placeholder="Máxima" name="nota_max" value="{{ request('nota_max') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filtro por Popularidade -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Popularidade:</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" 
                                       placeholder="Mínima" name="popularidade_min" value="{{ request('popularidade_min') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" 
                                       placeholder="Máxima" name="popularidade_max" value="{{ request('popularidade_max') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filtro por Episódios -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Episódios:</label>
                        <div class="row">
                            <div class="col">
                                <input type="number" class="form-control" 
                                       placeholder="Mínimo" name="episodios_min" value="{{ request('episodios_min') }}">
                            </div>
                            <div class="col">
                                <input type="number" class="form-control" 
                                       placeholder="Máximo" name="episodios_max" value="{{ request('episodios_max') }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ordenação -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ordenar por:</label>
                        <select class="form-select" name="order_by">
                            <option value="rank" {{ request('order_by', 'rank') == 'rank' ? 'selected' : '' }}>Rank</option>
                            <option value="nota" {{ request('order_by') == 'nota' ? 'selected' : '' }}>Nota</option>
                            <option value="popularidade" {{ request('order_by') == 'popularidade' ? 'selected' : '' }}>Popularidade</option>
                            <option value="ano_lancamento" {{ request('order_by') == 'ano_lancamento' ? 'selected' : '' }}>Ano de Lançamento</option>
                            <option value="episodios" {{ request('order_by') == 'episodios' ? 'selected' : '' }}>Episódios</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Direção:</label>
                        <select class="form-select" name="order_direction">
                            <option value="asc" {{ request('order_direction', 'asc') == 'asc' ? 'selected' : '' }}>Crescente</option>
                            <option value="desc" {{ request('order_direction') == 'desc' ? 'selected' : '' }}>Decrescente</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <a href="{{ route('animes.index') }}" class="btn btn-outline-secondary">Limpar Filtros</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Lista de Animes -->
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Nome</th>
                    <th>Gêneros</th>
                    <th>Nota</th>
                    <th>Popularidade</th>
                    <th>Ano</th>
                    <th>Episódios</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animes as $anime)
                    <tr>
                        <td>{{ $anime->rank }}</td>
                        <td>{{ $anime->nome }}</td>
                        <td>{{ $anime->generos }}</td>
                        <td>{{ $anime->nota }}</td>
                        <td>{{ $anime->popularidade }}</td>
                        <td>{{ $anime->ano_lancamento }}</td>
                        <td>{{ $anime->episodios }}</td>
                        <td>
                            <a href="{{ route('animes.edit', $anime->id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <!-- Adicione o botão de deletar com confirmação -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Paginação -->
    <div class="d-flex justify-content-center mt-4">
        {{ $animes->appends(request()->query())->links() }}
    </div>
</div>

<!-- JavaScript para transformar checkboxes em lista de gêneros no parâmetro GET -->
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const generosCheckboxes = document.querySelectorAll('input[name="generos[]"]:checked');
    const generosValues = Array.from(generosCheckboxes).map(cb => cb.value);
    
    // Cria um input hidden para enviar os gêneros como string separada por vírgulas
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'generos';
    hiddenInput.value = generosValues.join(',');
    this.appendChild(hiddenInput);
});
</script>
@endsection