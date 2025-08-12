@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')

<style>
    body {
        background-color: #202120;
        font-family: 'Segoe UI', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .content-wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar será importada de outro arquivo */
    .sidebar-imported {
        width: 280px;
        flex-shrink: 0;
    }

    .catalogo-container {
        flex-grow: 1;
        padding: 30px;
        background-color: #0a0a0a;
        color: #eee;
        position: relative;
        z-index: 1; /* Garante que o conteúdo esteja acima do pseudo-elemento */
    }

    .catalogo-container::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url({{ asset('biblioteca.jpg') }}) no-repeat center center; /* Ajuste aqui para usar asset() */
        background-size: cover;
        opacity: 0.1;
        filter: grayscale(100%) brightness(0.8);
        z-index: 0; /* Garante que o pseudo-elemento esteja por baixo */
        pointer-events: none;
    }

    .header-content {
        margin-bottom: 25px;
        position: relative;
        z-index: 1;
    }

    .page-title {
        font-size: 2rem;
        color: #ff4d94;
        margin: 0 0 20px 0;
        font-weight: 600;
        text-shadow: 0 0 10px rgba(255, 77, 148, 0.3);
    }

    .search-box {
        background: rgba(30, 30, 30, 0.8);
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        border: 1px solid #333;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
        z-index: 1;
    }

    .search-box input {
        width: 98%;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        background: #222;
        color: #fff;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .search-box input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 77, 148, 0.3);
        background: #2a2a2a;
    }

    .anime-lista {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        position: relative;
        z-index: 1;
    }

    .anime-card {
        background: linear-gradient(145deg, #1a1a1a 0%, #141414 100%);
        border-radius: 10px;
        padding: 18px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: 1px solid #2a2a2a;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .anime-card:hover {
        transform: translateY(-5px);
        border-color: #ff4d94;
        box-shadow: 0 8px 20px rgba(255, 77, 148, 0.2);
    }

    .anime-card h3 {
        margin: 12px 0 6px;
        font-size: 1.1rem;
        color: #ff91c6;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .anime-meta-container {
        color: #aaa;
        font-size: 0.85rem;
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
    }

    .anime-card img {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 12px;
        transition: transform 0.3s;
    }

    .anime-card:hover img {
        transform: scale(1.02);
    }

    .anime-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 12px 0;
    }

    .anime-tags span {
        background: #333;
        color: #ddd;
        padding: 4px 10px;
        font-size: 0.75rem;
        border-radius: 12px;
        border: 1px solid #444;
    }

    .anime-desc {
        font-size: 0.85rem;
        line-height: 1.5;
        color: #bbb;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 4.5em;
    }

    .buttons-container {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .ver-mais-btn, .edit-btn-custom { /* Adicionado .edit-btn-custom */
        background: linear-gradient(to right, #ff4d94, #e6399b);
        color: white;
        border: none;
        padding: 10px 15px;
        flex-grow: 1;
        font-size: 0.9rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .ver-mais-btn:hover, .edit-btn-custom:hover { /* Adicionado .edit-btn-custom */
        background: linear-gradient(to right, #e6399b, #ff4d94);
        box-shadow: 0 0 15px rgba(255, 77, 148, 0.3);
    }

    .delete-form {
        flex-grow: 1;
    }

    .delete-btn {
        background: linear-gradient(to right, #dc3545, #c82333);
        color: white;
        border: none;
        padding: 10px 15px;
        width: 100%;
        font-size: 0.9rem;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .delete-btn:hover {
        background: linear-gradient(to right, #c82333, #dc3545);
        box-shadow: 0 0 15px rgba(220, 53, 69, 0.3);
    }

    /* Estilo para o botão de Editar, similar ao ver-mais-btn, mas com uma cor diferente ou ícone */
    .edit-btn-custom {
        background: linear-gradient(to right, #007bff, #0056b3); /* Exemplo de cor azul */
        /* Ou, se quiser mais parecido com o rosa, mas ligeiramente diferente: */
        /* background: linear-gradient(to right, #ff6f8b, #e05e7c); */
    }

    .edit-btn-custom:hover {
        background: linear-gradient(to right, #0056b3, #007bff);
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.3);
    }


    .flash-message {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        border-radius: 5px;
        color: white;
        z-index: 1000;
        animation: slideIn 0.3s, fadeOut 0.5s 2.5s;
    }

    .flash-message.success {
        background-color: #28a745;
    }

    .flash-message.error {
        background-color: #dc3545;
    }

    @keyframes slideIn {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    .rating-badge {
        position: absolute;
        top: 18px;
        right: 18px;
        background: rgba(0, 0, 0, 0.7);
        color: #ffd700;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: bold;
        display: flex;
        align-items: center;
    }

    .rating-badge::before {
        content: "★";
        margin-right: 3px;
    }

    @media (max-width: 1024px) {
        .anime-lista {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        }
        
        .anime-card img {
            height: 280px;
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            flex-direction: column;
        }
        
        .sidebar-imported {
            width: 100%;
        }
        
        .catalogo-container {
            padding: 20px;
        }
        
        .anime-lista {
            grid-template-columns: 1fr;
        }
        
        .anime-card img {
            height: 350px;
        }
    }
</style>

<main class="catalogo-container">
    <div class="header-content">
        <h1 class="page-title">Catálogo de Animes</h1>
    </div>
    
    <div class="search-box">
        <input type="text" placeholder="Pesquisar animes..." id="search-input">
    </div>
    
    <div class="anime-lista">
        @foreach($animes as $anime)
        <div class="anime-card">
            <div class="rating-badge">{{ number_format($anime->nota, 1) }}</div>
            @if($anime->cover_image)
                <img src="{{ asset($anime->cover_image) }}" alt="{{ $anime->nome }}">
            @else
                <img src="https://via.placeholder.com/300x450" alt="{{ $anime->nome }}">
            @endif
            <h3>{{ $anime->nome }}</h3>
            <div class="anime-meta-container">
                <span>{{ $anime->ano_lancamento }}</span>
                <span>{{ $anime->episodios }} episódios</span>
            </div> 
            <div class="anime-tags">
                @foreach(explode(',', $anime->generos) as $genero)
                    <span>{{ trim($genero) }}</span>
                @endforeach
            </div>
            <p class="anime-desc">
                {{ $anime->descricao ?? 'Descrição não disponível' }}
            </p>
            <div class="buttons-container">
                <a href="{{ route('anime.show', $anime->id) }}" class="ver-mais-btn">Ver detalhes</a>
                {{-- Botão de Editar --}}
                <a href="{{ route('anime.edit', $anime->id) }}" class="edit-btn-custom">Editar</a>
                {{-- Fim do Botão de Editar --}}
                <form class="delete-form" action="{{ route('anime.destroy', $anime->id) }}" method="POST" data-anime-id="{{ $anime->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn">Excluir</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</main>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const animeCards = document.querySelectorAll('.anime-card');

        // Prepara uma lista de objetos com nome e o próprio card
        const animesData = Array.from(animeCards).map(card => ({
            nome: card.querySelector('h3').textContent,
            card: card
        }));

        const fuse = new Fuse(animesData, {
            keys: ['nome'],
            threshold: 0.4, // quanto menor, mais preciso (0.0 = exato, 1.0 = qualquer coisa parecida)
        });

        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value;

            if (searchTerm.trim() === '') {
                animeCards.forEach(obj => obj.style.display = 'block');
                return;
            }

            const results = fuse.search(searchTerm);

            animeCards.forEach(obj => obj.style.display = 'none');
            results.forEach(result => {
                result.item.card.style.display = 'block';
            });
        });

        // Adiciona funcionalidade de mensagem flash (se houver)
        @if(session('success'))
            alert("{{ session('success') }}");
        @endif
        @if(session('error'))
            alert("{{ session('error') }}");
        @endif

    });
</script>

@endsection