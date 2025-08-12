<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Editar Perfil - Anime</title>
  <style>
    :root {
      --primary: #FF2D75;
      --primary-light: #FF5CA2;
      --primary-dark: #D81B60;
      --dark: #121212;
      --darker: #0A0A0A;
      --light: #F0F0F0;
      --gray: #2A2A2A;
      --card-bg: rgba(30, 30, 30, 0.9);
      --text-muted: #888;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', 'Segoe UI', system-ui, -apple-system, sans-serif;
      background-color: var(--dark);
      color: var(--light);
      line-height: 1.6;
      position: relative;
      overflow-x: hidden;
    }

    /* Fundo com imagem de anime esmaecida */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url(fundow.png);
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      opacity: 0.15;
      z-index: -1;
      filter: grayscale(80%) brightness(1.0);
    }

    .main-content {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 2rem;
    }

    .container {
      width: 100%;
      max-width: 600px;
      background-color: var(--card-bg);
      border-radius: 16px;
      padding: 2.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      border: 1px solid rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(5px);
      position: relative;
      overflow: hidden;
    }

    /* Detalhe decorativo anime */
    .container::before {
      content: '';
      position: absolute;
      top: 0;
      right: 0;
      width: 100px;
      height: 100px;
      background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
      opacity: 0.1;
      z-index: -1;
    }

    h1 {
      color: var(--primary);
      font-size: 2rem;
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 700;
      position: relative;
      display: inline-block;
      width: 100%;
    }

    h1::after {
      content: '';
      display: block;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), transparent);
      margin: 0.5rem auto 0;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 500;
      color: var(--light);
      font-size: 0.95rem;
    }

    input, textarea {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid var(--gray);
      border-radius: 8px;
      background-color: rgba(40, 40, 40, 0.7);
      color: var(--light);
      font-size: 1rem;
      transition: all 0.2s ease;
    }

    input:focus, textarea:focus {
      outline: none;
      border-color: var(--primary-light);
      box-shadow: 0 0 0 3px rgba(255, 92, 162, 0.2);
      background-color: rgba(50, 50, 50, 0.7);
    }

    textarea {
      min-height: 120px;
      resize: vertical;
    }

    .button-group {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-save {
      background-color: var(--primary);
      color: white;
      box-shadow: 0 4px 15px rgba(255, 45, 117, 0.3);
    }

    .btn-save:hover {
      background-color: var(--primary-light);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(255, 45, 117, 0.4);
    }

    .btn-save:active {
      transform: translateY(0);
    }

    .btn-cancel {
      background-color: transparent;
      color: var(--text-muted);
      border: 1px solid var(--gray);
    }

    .btn-cancel:hover {
      background-color: rgba(255, 255, 255, 0.05);
      color: var(--light);
    }

    /* Estilos para os gêneros */
    .genres-container {
      margin-top: 1rem;
    }

    .genres-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
      gap: 0.75rem;
      margin-top: 0.5rem;
    }

    .genre-tag {
      display: inline-block;
      padding: 0.5rem 1rem;
      background-color: rgba(40, 40, 40, 0.7);
      border-radius: 20px;
      font-size: 0.85rem;
      cursor: pointer;
      transition: all 0.2s ease;
      text-align: center;
      border: 1px solid transparent;
      position: relative;
      overflow: hidden;
    }

    .genre-tag:hover {
      background-color: rgba(255, 45, 117, 0.1);
      border-color: var(--primary-light);
    }

    .genre-tag.selected {
      background-color: var(--primary);
      color: white;
      font-weight: 600;
      box-shadow: 0 4px 10px rgba(255, 45, 117, 0.3);
    }

    .genre-tag.selected::after {
      content: '✓';
      position: absolute;
      right: 8px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 0.8rem;
    }

    .search-genres {
      width: 100%;
      margin-bottom: 1rem;
      padding: 0.75rem 1.5rem;
      border-radius: 50px;
      background-color: rgba(40, 40, 40, 0.7);
      border: 1px solid var(--gray);
      color: var(--light);
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23888' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 1rem center;
      padding-left: 3rem;
    }

    .selected-genres {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      margin-top: 1rem;
      min-height: 40px;
      align-items: center;
    }

    .selected-tag {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.4rem 0.8rem 0.4rem 1rem;
      background-color: var(--primary-dark);
      border-radius: 20px;
      font-size: 0.8rem;
      animation: fadeIn 0.3s ease-out;
    }

    .remove-tag {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font-size: 0.9rem;
      display: flex;
      align-items: center;
      transition: transform 0.2s ease;
    }

    .remove-tag:hover {
      transform: scale(1.2);
    }

    .no-genres {
      color: var(--text-muted);
      font-size: 0.9rem;
      font-style: italic;
    }

        /* Avatar Upload Styles */
    .avatar-upload {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        position: relative;
        border: 3px solid var(--gray);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
    }

    .image-preview {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: all 0.3s ease;
    }

    .avatar-upload-controls {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }

    .btn-upload, .btn-remove {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-upload {
        background-color: var(--primary);
        color: white;
        border: none;
    }

    .btn-upload:hover {
        background-color: var(--primary-light);
    }

    .btn-remove {
        background-color: var(--gray);
        color: var(--light);
        border: none;
    }

    .btn-remove:hover {
        background-color: #333;
    }

    /* Animação */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }

    .container {
      animation: fadeIn 0.5s ease-out;
    }

    .btn-save:hover {
      animation: pulse 1.5s infinite;
    }

    /* Ícones */
    .icon {
      width: 18px;
      height: 18px;
    }
  </style>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <div class="main-content">
    <div class="container">
      <h1>Editar Perfil </h1>

      <!-- Formulário de Atualização -->
      <form action="{{ route('perfil.atualizar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label for="avatar">Avatar Otaku</label>
          <div class="avatar-upload">
              <div class="avatar-preview" id="avatarPreview">
                  <div class="image-preview" style="background-image: url('{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/default-avatar.jpg') }}');"></div>
              </div>
              <div class="avatar-upload-controls">
                  <label for="avatar" class="btn-upload">
                      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                      </svg>
                      Escolher Imagem
                  </label>
                  <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;">
                  <button type="button" class="btn-remove" id="removeAvatar">
                      <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                      </svg>
                      Remover
                  </button>
              </div>
          </div>
      </div>

      <div class="form-group">
        <label for="username">Nome de Usuário</label>
        <input type="text" id="username" name="username" placeholder="ex: otaku_123">
      </div>

      <div class="form-group">
        <label for="bio">Biografia Otaku</label>
        <textarea id="bio" name="bio" rows="4" maxlength="250" placeholder="Conte sobre seus animes favoritos, personagens que ama e seu estilo otaku..."></textarea>
      </div>

      <div class="form-group">
        <label>Gêneros de Anime Preferidos</label>
        <input type="text" class="search-genres" placeholder="Busque por gêneros..." id="genreSearch">
        <div class="selected-genres" id="selectedGenres">
          <div class="no-genres">Selecione seus gêneros favoritos</div>
          <input type="hidden" name="generos" id="generosInput">
        </div>
        <div class="genres-container">
          <div class="genres-grid" id="genresGrid"></div>
        </div>
      </div>

      <div class="button-group">
        <button type="submit" class="btn btn-save">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Salvar Perfil
        </button>
      </div>
    </form>

<!-- Formulário separado para exclusão -->
  <form action="{{ route('perfil.excluir') }}" method="POST" style="margin-top: 1rem;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-cancel">Excluir Perfil</button>
  </form>      

  <script>
    const genres = [
      "Ação", "Aventura", "Comédia", "Drama", "Fantasia",
      "Slice of Life", "Terror", "Esporte", "Mecha", "Romance",
      "Sci-Fi", "Isekai", "Mistério", "Psicológico", "Shounen",
      "Shoujo", "Seinen", "Josei", "Cyberpunk", "Histórico",
      "Musical", "Gourmet", "Artes Marciais", "Super Poderes",
      "Magia", "Vampiros", "Zumbis", "Apocalipse", "Escolar",
      "Idols", "Jogos", "Samurai", "Yokai", "Harem",
      "Reverse Harem", "Demônios", "Anjos", "Viagem no Tempo"
    ];

    const selectedGenres = new Set();
    const genresGrid = document.getElementById('genresGrid');
    const selectedGenresContainer = document.getElementById('selectedGenres');
    const genreSearch = document.getElementById('genreSearch');
    const saveButton = document.querySelector('.btn-save');

    // Função para renderizar gêneros
    function renderGenres(filter = '') {
      genresGrid.innerHTML = '';
      const filtered = filter
        ? genres.filter(genre => genre.toLowerCase().includes(filter.toLowerCase()))
        : genres;

      filtered.forEach(genre => {
        const tag = document.createElement('div');
        tag.className = `genre-tag ${selectedGenres.has(genre) ? 'selected' : ''}`;
        tag.textContent = genre;
        tag.addEventListener('click', () => toggleGenre(genre));
        genresGrid.appendChild(tag);
      });
    }

    function toggleGenre(genre) {
      if (selectedGenres.has(genre)) {
        selectedGenres.delete(genre);
      } else {
        selectedGenres.add(genre);
      }
      renderGenres(genreSearch.value);
      renderSelectedGenres();
    }

    function renderSelectedGenres() {
      selectedGenresContainer.innerHTML = '';
      if (selectedGenres.size === 0) {
        const placeholder = document.createElement('div');
        placeholder.className = 'no-genres';
        placeholder.textContent = 'Selecione seus gêneros favoritos';
        selectedGenresContainer.appendChild(placeholder);
        return;
      }

      selectedGenres.forEach(genre => {
        const tag = document.createElement('div');
        tag.className = 'selected-tag';

        const text = document.createElement('span');
        text.textContent = genre;

        const removeBtn = document.createElement('button');
        removeBtn.className = 'remove-tag';
        removeBtn.innerHTML = '&times;';
        removeBtn.addEventListener('click', (e) => {
          e.stopPropagation();
          toggleGenre(genre);
        });

        tag.appendChild(text);
        tag.appendChild(removeBtn);
        selectedGenresContainer.appendChild(tag);
      });
    }

    // Filtrar gêneros enquanto digita
    genreSearch.addEventListener('input', (e) => {
      renderGenres(e.target.value);
    });

    // Botão "Salvar Perfil" - simula salvamento no localStorage
    saveButton.addEventListener('click', () => {
    const savedGenres = Array.from(selectedGenres);
    document.getElementById('generosInput').value = savedGenres.join(',');
    saveButton.closest('form').submit(); // agora envia de verdade
  });

    // Recupera gêneros do localStorage ao carregar
    window.addEventListener('DOMContentLoaded', () => {
      const stored = localStorage.getItem('generosFavoritos');
      if (stored) {
        const storedGenres = JSON.parse(stored);
        storedGenres.forEach(genre => selectedGenres.add(genre));
      }
      renderGenres();
      renderSelectedGenres();
    });

    // Preview da imagem do avatar
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const removeAvatarBtn = document.getElementById('removeAvatar');

    avatarInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.querySelector('.image-preview').style.backgroundImage = `url('${e.target.result}')`;
            }
            reader.readAsDataURL(file);
        }
    });

    removeAvatarBtn.addEventListener('click', function() {
        avatarInput.value = '';
        avatarPreview.querySelector('.image-preview').style.backgroundImage = `url('{{ asset('images/default-avatar.jpg') }}')`;
    });
</script>
</body>
</html>