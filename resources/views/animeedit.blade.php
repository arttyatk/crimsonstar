@extends('layouts.app')

@section('title', 'Editar Anime: ' . $anime->nome)

@section('content')
<style>
    /* Estes estilos agora são específicos para a página de edição */

    /* Removido: estilos de body e catalogo-container, que foram para layouts.app */

    /* Centraliza o formulário dentro do catalogo-container */
    .catalogo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* Removido o padding do body original, agora o catalogo-container pode ter seu próprio padding */
        padding: 40px 20px; /* Adiciona padding para o formulário */
        box-sizing: border-box; /* Garante que o padding não aumente o tamanho total */
    }

    .form-container {
        background: linear-gradient(145deg, #1a1a1a 0%, #141414 100%);
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        max-width: 700px;
        width: 100%;
        border: 1px solid #2a2a2a;
        position: relative; /* Garante que o formulário esteja acima do pseudo-elemento do container */
        z-index: 2; /* Para garantir que o formulário seja visível acima do background */
        margin-left: 200px;
    }

    .form-container h1 {
        font-size: 2.2rem;
        color: #ff4d94;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        text-shadow: 0 0 10px rgba(255, 77, 148, 0.3);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #ccc;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group textarea {
        width: calc(100% - 20px);
        padding: 12px;
        border: 1px solid #444;
        border-radius: 8px;
        background-color: #2a2a2a;
        color: #fff;
        font-size: 1rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="number"]:focus,
    .form-group textarea:focus {
        border-color: #ff4d94;
        box-shadow: 0 0 0 2px rgba(255, 77, 148, 0.3);
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-group .image-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .form-group .image-preview {
        width: 100px;
        height: 140px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #444;
        display: block;
    }

    .form-group input[type="file"] {
        background-color: #333;
        color: #fff;
        border: 1px solid #444;
        padding: 10px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-group input[type="file"]:hover {
        background-color: #444;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }

    .submit-btn, .cancel-btn {
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .submit-btn {
        background: linear-gradient(to right, #ff4d94, #e6399b);
        color: white;
    }

    .submit-btn:hover {
        background: linear-gradient(to right, #e6399b, #ff4d94);
        box-shadow: 0 0 15px rgba(255, 77, 148, 0.4);
        transform: translateY(-2px);
    }

    .cancel-btn {
        background-color: #444;
        color: #ddd;
    }

    .cancel-btn:hover {
        background-color: #555;
        transform: translateY(-2px);
    }

    .error-message {
        color: #ff6b6b;
        font-size: 0.85rem;
        margin-top: 5px;
    }

    /* Mensagens flash são tratadas no layouts.app, então não precisam ser duplicadas aqui */
    /* .flash-message { ... } */

    @media (max-width: 600px) {
        .form-container {
            padding: 20px;
        }

        .form-container h1 {
            font-size: 1.8rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .submit-btn, .cancel-btn {
            width: 100%;
        }
    }
</style>

{{-- A div content-wrapper e catalogo-container são definidas no layouts.app. --}}
{{-- O @section('content') irá injetar este HTML DENTRO do catalogo-container. --}}

<div class="form-container"> {{-- Removido o content-wrapper e catalogo-container daqui --}}
    <h1>Editar Anime</h1>

    {{-- Exibe mensagens de sucesso ou erro --}}
    @if(session('success'))
        <div class="flash-message success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash-message error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('anime.updateFromForm', $anime->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Usa o método PUT para atualização --}}

        <div class="form-group">
            <label for="nome">Nome do Anime</label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $anime->nome) }}" required>
            @error('nome') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="titulo_alternativo">Título Alternativo (opcional)</label>
            <input type="text" id="titulo_alternativo" name="titulo_alternativo" value="{{ old('titulo_alternativo', $anime->titulo_alternativo) }}">
            @error('titulo_alternativo') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="nota">Nota (0-10)</label>
            <input type="number" id="nota" name="nota" step="0.1" min="0" max="10" value="{{ old('nota', $anime->nota) }}" required>
            @error('nota') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="popularidade">Popularidade</label>
            <input type="number" id="popularidade" name="popularidade" min="0" value="{{ old('popularidade', $anime->popularidade) }}" required>
            @error('popularidade') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="generos">Gêneros (separados por vírgula)</label>
            <input type="text" id="generos" name="generos" value="{{ old('generos', $anime->generos) }}" required>
            @error('generos') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="autor">Autor (opcional)</label>
            <input type="text" id="autor" name="autor" value="{{ old('autor', $anime->autor) }}">
            @error('autor') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="estudio">Estúdio (opcional)</label>
            <input type="text" id="estudio" name="estudio" value="{{ old('estudio', $anime->estudio) }}">
            @error('estudio') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="ano_lancamento">Ano de Lançamento (opcional)</label>
            <input type="number" id="ano_lancamento" name="ano_lancamento" min="1900" max="{{ date('Y') + 1 }}" value="{{ old('ano_lancamento', $anime->ano_lancamento) }}">
            @error('ano_lancamento') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="episodios">Número de Episódios</label>
            <input type="number" id="episodios" name="episodios" min="0" value="{{ old('episodios', $anime->episodios) }}" required>
            @error('episodios') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required>{{ old('descricao', $anime->descricao) }}</textarea>
            @error('descricao') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="cover_image">Capa do Anime (opcional, deixar em branco para manter a atual)</label>
            <div class="image-upload-wrapper">
                <input type="file" id="cover_image" name="cover_image" accept="image/jpeg, image/png, image/jpg">
                <img id="imagePreview" src="{{ $anime->cover_image ? asset($anime->cover_image) : '#' }}"
                    alt="Pré-visualização da capa"
                    class="image-preview"
                    style="{{ $anime->cover_image ? 'display: block;' : 'display: none;' }}">
            </div>
            @error('cover_image') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="window.location='{{ route('catalogo') }}'">Cancelar</button>
            <button type="submit" class="submit-btn">Salvar Alterações</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const coverImageInput = document.getElementById('cover_image');
        const imagePreview = document.getElementById('imagePreview');

        coverImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                imagePreview.src = URL.createObjectURL(file);
                imagePreview.style.display = 'block';
            } else {
                // Se nenhum arquivo for selecionado, volta para a imagem original ou esconde
                imagePreview.src = "{{ $anime->cover_image ? asset($anime->cover_image) : '#' }}";
                imagePreview.style.display = "{{ $anime->cover_image ? 'block' : 'none' }}";
            }
        });

        // A funcionalidade da mensagem flash agora está no layouts.app,
        // então não precisamos duplicá-la aqui, a menos que você queira
        // um comportamento específico para esta página.
        // Se a lógica da mensagem flash estiver no layouts.app, remova o seguinte bloco:
        /*
        const flashMessage = document.querySelector('.flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.opacity = '0';
                flashMessage.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }, 5000); // 5 segundos
        }
        */
    });
</script>
@endsection