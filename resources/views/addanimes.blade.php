@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div class="container">
    <h1>Cadastrar Novo Anime</h1>
    
    <form action="{{ route('animes.store.form') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Foto de Capa -->
        <div class="form-group">
            <label for="cover_image">Foto de Capa</label>
            <div class="file-input">
                <input type="file" id="cover_image" name="cover_image" accept="image/*">
                <label for="cover_image" class="file-input-label">Selecione uma imagem...</label>
            </div>
        </div>

        <!-- Nome e Título Alternativo -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="nome">Nome do Anime*</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="titulo_alternativo">Título Alternativo</label>
                    <input type="text" id="titulo_alternativo" name="titulo_alternativo">
                </div>
            </div>
        </div>

        <!-- Nota e Popularidade -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="nota">Nota (0-10)*</label>
                    <input type="number" id="nota" name="nota" min="0" max="10" step="0.1" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="popularidade">Popularidade*</label>
                    <input type="number" id="popularidade" name="popularidade" min="0" required>
                </div>
            </div>
        </div>

        <!-- Gêneros -->
        <div class="form-group">
            <label for="generos">Gêneros* (separados por vírgula)</label>
            <input type="text" id="generos" name="generos" required placeholder="Ex: Ação, Aventura, Fantasia">
        </div>

        <!-- Autor e Estúdio -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="autor">Autor</label>
                    <input type="text" id="autor" name="autor">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="estudio">Estúdio</label>
                    <input type="text" id="estudio" name="estudio">
                </div>
            </div>
        </div>

        <!-- Ano e Episódios -->
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="ano_lancamento">Ano de Lançamento</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" min="1900">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="episodios">Número de Episódios*</label>
                    <input type="number" id="episodios" name="episodios" min="0" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" name="descricao" required placeholder="Ex: O protagonista encontra um tesouro...">
        </div>

        <button type="submit">Cadastrar Anime</button>
    </form>
</div>

<style>
    :root {
        --neon-pink: #ff1493;
        --neon-purple: #ff69b4;
        --dark-bg: #1a001a;
        --darker-bg: #250025;
        --light-text: #ffe6f0;
        --gray-text: #ffc2e2;
    }

    body {
        background-color: var(--dark-bg);
        color: var(--light-text);
        padding: 20px;
    }

    .container {
        max-width: 8000px;
        margin: 0 auto;
        padding: 30px;
        background-color: var(--darker-bg);
        border-radius: 10px;
        border: 2px solid var(--neon-pink);
        box-shadow: 0 0 15px var(--neon-pink),
                    inset 0 0 15px rgba(255, 105, 180, 0.2);
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2.5rem;
        background: linear-gradient(90deg, var(--neon-pink), var(--neon-purple));
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        text-shadow: 0 0 10px rgba(255, 105, 180, 0.4);
    }

    .form-group {
        margin-bottom: 20px;
        margin-right: 25px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: var(--neon-pink);
        font-weight: bold;
    }

    input, textarea {
        width: 100%;
        padding: 12px;
        background-color: rgba(0, 0, 0, 0.5);
        border: 1px solid var(--neon-pink);
        border-radius: 5px;
        color: var(--light-text);
        font-size: 16px;
    }

    input:focus, textarea:focus {
        outline: none;
        border-color: var(--neon-purple);
        box-shadow: 0 0 10px var(--neon-pink);
    }

    .row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .col {
        flex: 1;
    }

    button {
        width: 100%;
        padding: 15px;
        background: linear-gradient(90deg, var(--neon-pink), var(--neon-purple));
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 30px;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    button:hover {
        transform: scale(1.03);
        box-shadow: 0 0 15px var(--neon-pink);
    }

    .file-input {
        position: relative;
        overflow: hidden;
    }

    .file-input input[type="file"] {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-input-label {
        padding: 12px;
        background-color: rgba(0, 0, 0, 0.5);
        border: 1px dashed var(--neon-pink);
        border-radius: 5px;
        text-align: center;
        color: var(--gray-text);
        cursor: pointer;
    }

    .file-input-label:hover {
        background-color: rgba(255, 105, 180, 0.1);
    }

    @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
    }
</style>

<script>
    document.getElementById('cover_image').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Selecione uma imagem...';
        document.querySelector('.file-input-label').textContent = fileName;
    });
</script>
@endsection
