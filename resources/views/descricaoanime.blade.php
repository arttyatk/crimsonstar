@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<style>
    .anime-details {
        padding: 2rem 1.5rem;
        background-color: #0d0d12;
        color: #f0f0f0;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    }

    .anime-details::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(13, 13, 18, 0.9), rgba(13, 13, 18, 0.95)), 
                    url('animewallpaper.jpg') no-repeat center center/cover;
        opacity: 0.15;
        z-index: 0;
        pointer-events: none;
    }

    .anime-details > * {
        position: relative;
        z-index: 2;
    }

    .anime-header {
        display: flex;
        gap: 2.5rem;
        align-items: flex-start;
        flex-wrap: wrap;
        padding-bottom: 2rem;
        margin: 0 auto;
        max-width: 1200px;
    }

    .anime-poster {
        position: relative;
        flex-shrink: 0;
    }

    .anime-poster img {
        width: 100%;
        max-width: 280px;
        border-radius: 12px;
        box-shadow: 0 12px 30px -10px rgba(255, 85, 181, 0.3);
        transition: transform 0.3s ease;
    }

    .anime-poster:hover img {
        transform: scale(1.02);
    }

    .anime-poster::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 12px;
        box-shadow: inset 0 0 30px rgba(0, 0, 0, 0.6);
        pointer-events: none;
    }

    .anime-info {
        flex: 1;
        min-width: 250px;
    }

    .anime-info h2 {
        font-size: 2.2rem;
        color: #ff55b5;
        margin: 0 0 0.5rem;
        font-weight: 700;
        text-shadow: 0 2px 8px rgba(255, 85, 181, 0.3);
    }

    .anime-info h3 {
        margin: 0;
        font-weight: 400;
        color: #b0b0b0;
        font-size: 1.1rem;
    }

    .anime-meta {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .meta-item {
        background: rgba(30, 30, 40, 0.6);
        border-left: 3px solid #ff55b5;
        padding: 0.6rem 0.8rem;
        border-radius: 0 4px 4px 0;
    }

    .meta-item strong {
        display: block;
        font-size: 0.85rem;
        color: #aaa;
        margin-bottom: 0.3rem;
    }

    .meta-item span {
        font-size: 1rem;
        color: #ffd0ec;
    }

    .anime-description,
    .anime-background {
        max-width: 1200px;
        margin: 3rem auto 0;
        padding: 0 1rem;
    }

    .section-title {
        color: #fff;
        font-size: 1.5rem;
        margin-bottom: 1.2rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .section-title::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ff55b5, transparent);
    }

    .anime-description p,
    .anime-background p {
        margin-top: 0;
        line-height: 1.8;
        font-size: 1.05rem;
        color: #ddd;
        text-align: justify;
    }

    @media (max-width: 768px) {
        .anime-header {
            gap: 1.5rem;
            justify-content: center;
            text-align: center;
        }

        .anime-poster {
            margin: 0 auto;
        }

        .anime-info h2 {
            font-size: 1.8rem;
        }

        .section-title::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .meta-item {
            text-align: center;
            border-left: none;
            border-bottom: 2px solid #ff55b5;
            border-radius: 0 0 4px 4px;
        }
    }

    @media (max-width: 480px) {
        .anime-details {
            padding: 1.5rem 1rem;
        }

        .anime-meta {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="anime-details">
    <section class="anime-header">
        <div class="anime-poster">
            <img src="{{ $anime->cover_image ? asset($anime->cover_image) : 'https://via.placeholder.com/300x450' }}" alt="Capa de {{ $anime->nome }}">
        </div>
        <div class="anime-info">
            <h2>{{ $anime->nome }}</h2>
            <h3>{{ $anime->titulo_alternativo ?? 'Nome alternativo não disponível' }}</h3>

            <div class="anime-meta">
                <div class="meta-item">
                    <strong>Nota</strong>
                    <span>{{ number_format($anime->nota, 1) }}/10</span>
                </div>
                <div class="meta-item">
                    <strong>Rank</strong>
                    <span>{{ $anime->rank ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <strong>Popularidade</strong>
                    <span>{{ $anime->popularidade ?? 'N/A' }}</span>
                </div>
                <div class="meta-item">
                    <strong>Episódios</strong>
                    <span>{{ $anime->episodios }}</span>
                </div>
                <div class="meta-item">
                    <strong>Estúdio</strong>
                    <span>{{ $anime->estudio ?? 'Desconhecido' }}</span>
                </div>
                <div class="meta-item">
                    <strong>Lançamento</strong>
                    <span>{{ $anime->ano_lancamento }}</span>
                </div>
                <div class="meta-item">
                    <strong>Autor</strong>
                    <span>{{ $anime->autor }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="anime-description">
        <h3 class="section-title">Sinopse</h3>
        <p>{{ $anime->descricao ?? 'Sinopse não disponível.' }}</p>
    </section>
</main>
@endsection