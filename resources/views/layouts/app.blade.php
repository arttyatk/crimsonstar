<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Título Padrão')</title>

  <style>
    :root {
      --primary: #ff4d94;
      --primary-dark: #e6399b;
      --bg-dark: #121212;
      --bg-darker: #0a0a0a;
      --text-light: #e0e0e0;
      --text-lighter: #ffffff;
      --text-gray: #b0b0b0;
      --border-radius: 12px;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
      margin: 0;
      font-family: 'Inter', 'Segoe UI', sans-serif;
      display: flex;
      height: 100vh;
      overflow-x: hidden;
      background-color: var(--bg-dark);
      color: var(--text-light);
    }

    .layout-sidebar {
      width: 300px;
      min-height: 100vh;
      height: 100vh;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: var(--primary) transparent;
      background: rgba(10, 10, 10, 0.85);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      color: var(--text-light);
      padding: 30px 25px;
      box-sizing: border-box;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1000;
      border-right: 1px solid rgba(255, 255, 255, 0.05);
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease;
    }

    .layout-content {
      margin-left: 300px;
      flex: 1;
      background-color: var(--bg-dark);
      overflow-x: hidden;
      height: 100vh;
      box-sizing: border-box;
    }

    .layout-favicon {
      width: 140px;
      height: 140px;
      background-image: url('logosemfundo.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      margin: 0 auto 40px;
      filter: drop-shadow(0 0 15px rgba(255, 77, 148, 0.6));
      transition: var(--transition);
    }

    .layout-sidebar nav {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .layout-sidebar nav h2 {
      margin: 20px 0 15px;
      font-size: 0.9rem;
      color: var(--primary);
      text-transform: uppercase;
      letter-spacing: 1.5px;
      font-weight: 600;
      position: relative;
      padding-bottom: 8px;
      opacity: 0.8;
    }

    .layout-sidebar nav h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 30px;
      height: 2px;
      background: linear-gradient(90deg, var(--primary) 0%, transparent 100%);
    }

    .layout-sidebar nav ul {
      list-style: none;
      padding: 0;
      margin: 0 0 20px 0;
    }

    .layout-sidebar nav ul li {
      margin: 8px 0;
      transition: var(--transition);
    }

    .layout-sidebar nav ul li a {
      color: var(--text-gray);
      text-decoration: none;
      transition: var(--transition);
      display: flex;
      align-items: center;
      padding: 12px 15px;
      border-radius: var(--border-radius);
      font-size: 15px;
      font-weight: 500;
    }

    .layout-sidebar nav ul li a:hover {
      color: var(--text-lighter);
      background-color: rgba(255, 77, 148, 0.15);
      transform: translateX(5px);
    }

    .layout-sidebar nav ul li a i {
      width: 24px;
      text-align: center;
      margin-right: 12px;
      font-size: 14px;
    }

    .sidebar-footer {
      margin-top: auto;
      padding-top: 20px;
      border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    .user-profile {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      margin-right: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
    }

    .user-info {
      flex: 1;
    }

    .user-name {
      font-weight: 600;
      color: var(--text-lighter);
      margin-bottom: 2px;
      font-size: 14px;
      cursor: pointer;
      transition: var(--transition);
    }

    .user-name:hover {
      color: var(--primary);
      text-decoration: underline;
    }

    .user-email {
      font-size: 12px;
      color: var(--text-gray);
      opacity: 0.8;
    }

    .logout-btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: var(--border-radius);
      background: rgba(255, 77, 148, 0.2);
      color: var(--text-lighter);
      cursor: pointer;
      transition: var(--transition);
      font-weight: 500;
      font-size: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .logout-btn:hover {
      background: rgba(255, 77, 148, 0.3);
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(255, 77, 148, 0.2);
    }

    /* Estilos expandidos para o perfil do usuário */
    .user-profile-expanded {
        text-align: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .user-avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 15px;
    }

    .user-avatar-large {
        width: 100%;
        height: 100%;
        border-radius: 12px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
        border: 3px solid var(--primary);
        box-shadow: 0 5px 20px rgba(255, 77, 148, 0.3);
        transition: var(--transition);
        cursor: pointer;
    }

    .user-avatar-large:hover {
        transform: scale(1.03);
        box-shadow: 0 8px 25px rgba(255, 77, 148, 0.5);
    }

    .avatar-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition);
    }

    .user-avatar-large:hover .avatar-hover-overlay {
        opacity: 1;
    }

    .avatar-hover-overlay i {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .avatar-hover-overlay span {
        font-size: 12px;
        font-weight: 500;
    }

    .user-info-expanded {
        margin-top: 15px;
    }

    .user-info-expanded h3 {
        color: var(--text-lighter);
        margin: 0 0 10px 0;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .user-bio {
        color: var(--text-gray);
        font-size: 0.85rem;
        line-height: 1.5;
        margin-bottom: 15px;
        padding: 0 10px;
    }

    .user-genres-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        margin-bottom: 15px;
    }

    .genre-tag {
        background: rgba(255, 77, 148, 0.2);
        color: var(--primary);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 500;
        border: 1px solid var(--primary);
    }

    .edit-profile-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 15px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-light);
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.85rem;
        transition: var(--transition);
        margin-top: 10px;
    }

    .edit-profile-btn:hover {
        background: rgba(255, 77, 148, 0.2);
        color: var(--primary);
        transform: translateY(-2px);
    }

    /* Estilos para o perfil horizontal */
    .user-profile-horizontal {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .user-avatar-small {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        background-size: cover;
        background-position: center;
        border: 2px solid var(--primary);
        flex-shrink: 0;
    }

    .user-info-side {
        flex: 1;
        overflow: hidden;
    }

    .user-name-side {
        color: var(--text-lighter);
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-bio-side {
        color: var(--text-gray);
        font-size: 0.75rem;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .user-genres-tags-side {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .genre-tag-side {
        background: rgba(255, 77, 148, 0.2);
        color: var(--primary);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.65rem;
        font-weight: 500;
        border: 1px solid var(--primary);
        white-space: nowrap;
    }

    /* Estilos para os botões lado a lado */
    .sidebar-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .sidebar-btn {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: var(--border-radius);
        color: var(--text-lighter);
        cursor: pointer;
        transition: var(--transition);
        font-weight: 500;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .edit-btn {
        background: rgba(255, 77, 148, 0.2);
    }

    .logout-btn {
        background: rgba(255, 77, 148, 0.2);
    }

    .sidebar-btn:hover {
        background: rgba(255, 77, 148, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 77, 148, 0.2);
    }

    /* Ajuste para mobile */
    @media (max-width: 768px) {
        .sidebar-buttons {
            flex-direction: column;
            gap: 8px;
        }
    }

    

    @media (max-width: 768px) {
      .layout-sidebar {
        width: 250px;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }

      .layout-sidebar.active {
        transform: translateX(0);
      }

      .layout-content {
        margin-left: 0;
      }
    }
  </style>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  @stack('styles')
</head>
<body>
  @php use Illuminate\Support\Facades\Storage; @endphp

  <!-- Sidebar fixa -->
  <aside class="layout-sidebar">
    <nav>
      <div class="layout-favicon"></div>
      
      <h2>Navegação</h2>
      <ul>
        <li><a href="{{ route('inicio') }}"><i class="fas fa-home"></i> Início</a></li>
      </ul>
      

      <h2>Animes</h2>
      <ul>
        <li><a href="/catalogo"><i class="fas fa-list"></i> Todos os Animes</a></li>
        <li><a href="{{ route('addanimes') }}"><i class="fas fa-plus"></i> Adicionar Animes</a></li>
      </ul>

      <div class="sidebar-footer">
        @auth
        <div class="user-profile-horizontal">
            <div class="user-avatar-small" 
                 style="background-image: url('{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : asset('images/default-avatar.jpg') }}');">
            </div>
            
            <div class="user-info-side">
                <h3 class="user-name-side">{{ Auth::user()->name }}</h3>
                <p class="user-bio-side">{{ Str::limit(Auth::user()->bio ?? 'Sem biografia', 50) }}</p>
                
                @if(Auth::user()->generos)
                <div class="user-genres-tags-side">
                    @foreach(array_slice(explode(',', Auth::user()->generos), 0, 2) as $genero)
                        <span class="genre-tag-side">{{ trim($genero) }}</span>
                    @endforeach
                    @if(count(explode(',', Auth::user()->generos)) > 2)
                        <span class="genre-tag-side">+{{ count(explode(',', Auth::user()->generos)) - 2 }}</span>
                    @endif
                </div>
                @endif
            </div>
        </div>

        @else
        <div class="user-profile">
            <div class="user-avatar">
                <img src="{{ asset('images/default-avatar.jpg') }}" alt="Avatar Padrão">
            </div>
        </div>
        @endauth
    </div>

       <div class="sidebar-buttons">
    <a href="{{ route('profile.edit') }}" class="sidebar-btn edit-btn">
        <i class="fas fa-user-edit"></i>
        Editar
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-btn logout-btn">
            <i class="fas fa-sign-out-alt"></i>
            Sair
        </button>
    </form>
</div>
      </div>
    </nav>
  </aside>

  <!-- Conteúdo dinâmico da view -->
  <div class="layout-content">
    @yield('content')
  </div>

  @stack('scripts')
</body>
</html>
