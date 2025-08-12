@extends('layouts.app')

@section('title', 'Bem-vindo - Nakama List')

@section('content')
<style>
    .welcome-page {
        background-color: #202021;
        color: #f0f0f0;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        text-align: center;
        padding: 4rem 2rem;
    }

    .welcome-page::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(rgba(13, 13, 18, 0.9), rgba(13, 13, 18, 0.95)), 
                    url('https://images.unsplash.com/photo-1633613286848-e6f43bbafb8d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
        opacity: 0.1;
        z-index: 0;
        pointer-events: none;
    }

    .welcome-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    .logo {
        width: 200px;
        margin-bottom: 1.5rem;
        filter: drop-shadow(0 0 10px rgba(255, 85, 181, 0.5));
    }

    h1 {
        font-size: 3rem;
        color: #ff55b5;
        margin-bottom: 1rem;
        text-shadow: 0 2px 8px rgba(255, 85, 181, 0.3);
    }

    .tagline {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        color: #b0b0b0;
    }

    .welcome-text {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 3rem;
        color: #ddd;
    }

    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .btn {
        padding: 0.8rem 1.8rem;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: #ff55b5;
        color: #121212;
        border: 2px solid #ff55b5;
    }

    .btn-primary:hover {
        background-color: transparent;
        color: #ff55b5;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 85, 181, 0.4);
    }

    .btn-secondary {
        background-color: transparent;
        color: #ff55b5;
        border: 2px solid #ff55b5;
    }

    .btn-secondary:hover {
        background-color: #ff55b5;
        color: #121212;
        transform: translateY(-3px);
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-top: 4rem;
    }

    .feature-card {
        background: rgba(30, 30, 40, 0.6);
        border-top: 3px solid #ff55b5;
        padding: 1.5rem;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: #ff55b5;
        margin-bottom: 1rem;
    }

    .feature-title {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        color: #fff;
    }

    .feature-desc {
        font-size: 0.95rem;
        color: #aaa;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 2.2rem;
        }
        
        .tagline {
            font-size: 1.2rem;
        }
    }
</style>

<div class="welcome-page">
    <div class="welcome-content">
        <!-- Substitua pelo seu logo real -->
        <img src="logosemfundo.png" alt="Nakama List" class="logo">
        
        <h1>Bem-vindo ao Nakama List</h1>
        <p class="tagline">Sua jornada pelos melhores animes começa aqui!</p>
        
        <p class="welcome-text">
            Descubra animes incríveis, organize sua lista pessoal e encontre recomendações perfeitas 
            para o seu gosto. Nossa comunidade de nakamas está pronta para te ajudar nessa aventura!
        </p>
        
        <div class="cta-buttons">
            <a href="" class="btn btn-primary">Explorar Animes</a>
            <a href="{{ route('register') }}" class="btn btn-secondary">Junte-se a Nós</a>
        </div>
        
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">🎌</div>
                <h3 class="feature-title">Recomendações Personalizadas</h3>
                <p class="feature-desc">Sugestões baseadas no seu gosto e no que você já assistiu.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Listas Organizadas</h3>
                <p class="feature-desc">Classifique os animes que você já viu, está vendo ou planeja ver.</p>
            </div>
        </div>
    </div>
</div>
@endsection