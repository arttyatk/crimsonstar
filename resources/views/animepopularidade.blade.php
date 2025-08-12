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
    }

    .catalogo-container::before {
        content: "";
        position: absolute;
        inset: 0;
        background: url(biblioteca.jpg) no-repeat center center;
        background-size: cover;
        opacity: 0.1;
        filter: grayscale(100%) brightness(0.8);
        z-index: 0;
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

    .ver-mais-btn {
        background: linear-gradient(to right, #ff4d94, #e6399b);
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

    .ver-mais-btn:hover {
        background: linear-gradient(to right, #e6399b, #ff4d94);
        box-shadow: 0 0 15px rgba(255, 77, 148, 0.3);
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
            <input type="text" placeholder="Pesquisar animes...">
        </div>
        
        <div class="anime-lista">
            <div class="anime-card">
                <div class="rating-badge">8.5</div>
                <img src="https://via.placeholder.com/300x450" alt="Attack on Titan">
                <h3>Attack on Titan: The Final Season</h3>
                <div class="anime-meta-container">
                    <span>2020</span>
                    <span>24 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Drama</span>
                    <span>Fantasia</span>
                </div>
                <p class="anime-desc">
                    A batalha final pela liberdade da humanidade chega ao clímax enquanto Eren avança com seu plano radical.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>

            <div class="anime-card">
                <div class="rating-badge">9.1</div>
                <img src="https://via.placeholder.com/300x450" alt="Demon Slayer">
                <h3>Demon Slayer: Kimetsu no Yaiba</h3>
                <div class="anime-meta-container">
                    <span>2019</span>
                    <span>26 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Histórico</span>
                    <span>Sobrenatural</span>
                </div>
                <p class="anime-desc">
                    Tanjiro embarca em uma jornada para se tornar um caçador de demônios e curar sua irmã após sua família ser massacrada.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            <div class="anime-card">
                <div class="rating-badge">9.0</div>
                <img src="https://via.placeholder.com/300x450" alt="Fullmetal Alchemist: Brotherhood">
                <h3>Fullmetal Alchemist: Brotherhood</h3>
                <div class="anime-meta-container">
                    <span>2009</span>
                    <span>64 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Aventura</span>
                    <span>Fantasia</span>
                    <span>Drama</span>
                </div>
                <p class="anime-desc">
                    Os irmãos Elric buscam a Pedra Filosofal para restaurar seus corpos perdidos em uma tentativa fracassada de alquimia proibida.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">8.7</div>
                <img src="https://via.placeholder.com/300x450" alt="My Hero Academia">
                <h3>My Hero Academia</h3>
                <div class="anime-meta-container">
                    <span>2016</span>
                    <span>88 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Superpoderes</span>
                    <span>Escolar</span>
                </div>
                <p class="anime-desc">
                    Em um mundo onde a maioria possui poderes, Izuku Midoriya sonha em se tornar um herói, mesmo sem nascença com um dom.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">9.3</div>
                <img src="https://via.placeholder.com/300x450" alt="Death Note">
                <h3>Death Note</h3>
                <div class="anime-meta-container">
                    <span>2006</span>
                    <span>37 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Suspense</span>
                    <span>Psicológico</span>
                    <span>Mistério</span>
                </div>
                
                <p class="anime-desc">
                    Light Yagami encontra um caderno sobrenatural capaz de matar qualquer pessoa, e inicia sua jornada para criar um mundo "perfeito".
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            <div class="anime-card">
                <div class="rating-badge">8.9</div>
                <img src="https://via.placeholder.com/300x450" alt="One Punch Man">
                <h3>One Punch Man</h3>
                <div class="anime-meta-container">
                    <span>2015</span>
                    <span>24 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Comédia</span>
                    <span>Superpoderes</span>
                </div>
                <p class="anime-desc">
                    Saitama é um herói tão poderoso que derrota qualquer inimigo com um único soco, mas sofre com o tédio de ser invencível.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">9.0</div>
                <img src="https://via.placeholder.com/300x450" alt="Steins;Gate">
                <h3>Steins;Gate</h3>
                <div class="anime-meta-container">
                    <span>2011</span>
                    <span>24 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ficção Científica</span>
                    <span>Suspense</span>
                    <span>Drama</span>
                </div>
                <p class="anime-desc">
                    Um grupo de amigos descobre uma forma de enviar mensagens ao passado, colocando-se no centro de um dilema temporal perigoso.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">8.6</div>
                <img src="https://via.placeholder.com/300x450" alt="Tokyo Ghoul">
                <h3>Tokyo Ghoul</h3>
                <div class="anime-meta-container">
                    <span>2014</span>
                    <span>12 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Horror</span>
                    <span>Ação</span>
                    <span>Sobrenatural</span>
                </div>
                <p class="anime-desc">
                    Após um encontro fatal, Kaneki se torna meio-ghoul e luta para manter sua humanidade enquanto vive entre dois mundos.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">9.1</div>
                <img src="https://via.placeholder.com/300x450" alt="Hunter x Hunter">
                <h3>Hunter x Hunter (2011)</h3>
                <div class="anime-meta-container">
                    <span>2011</span>
                    <span>148 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Aventura</span>
                    <span>Ação</span>
                    <span>Shounen</span>
                </div>
                <p class="anime-desc">
                    Gon parte em uma jornada para se tornar um caçador e encontrar seu pai, descobrindo um mundo cheio de perigos e desafios.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">8.3</div>
                <img src="https://via.placeholder.com/300x450" alt="Blue Exorcist">
                <h3>Blue Exorcist</h3>
                <div class="anime-meta-container">
                    <span>2011</span>
                    <span>25 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Fantasia</span>
                    <span>Demônios</span>
                </div>
                <p class="anime-desc">
                    Rin Okumura descobre ser filho de Satanás e decide se tornar um exorcista para lutar contra seu destino demoníaco.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            
            <div class="anime-card">
                <div class="rating-badge">9.0</div>
                <img src="https://via.placeholder.com/300x450" alt="Code Geass">
                <h3>Code Geass: Lelouch of the Rebellion</h3>
                <div class="anime-meta-container">
                    <span>2006</span>
                    <span>50 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Estratégia</span>
                    <span>Ficção Científica</span>
                </div>
                <p class="anime-desc">
                    Após adquirir um poder misterioso chamado Geass, Lelouch lidera uma rebelião contra o império que oprime o Japão.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
            <div class="anime-card">
                <div class="rating-badge">8.8</div>
                <img src="https://via.placeholder.com/300x450" alt="Jujutsu Kaisen">
                <h3>Jujutsu Kaisen</h3>
                <div class="anime-meta-container">
                    <span>2020</span>
                    <span>24 episódios</span>
                </div>
                <div class="anime-tags">
                    <span>Ação</span>
                    <span>Horror</span>
                    <span>Escolar</span>
                </div>
                <p class="anime-desc">
                    Yuji Itadori engole um poderoso talismã amaldiçoado e se torna hospedeiro de uma maldição poderosa, entrando no mundo dos feiticeiros.
                </p>
                <button class="ver-mais-btn">Ver detalhes</button>
            </div>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Efeito de hover nos cards
        const cards = document.querySelectorAll('.anime-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
        
        // Simulação de busca
        const searchInput = document.querySelector('.search-box input');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const animeCards = document.querySelectorAll('.anime-card');
            
            animeCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                card.style.display = title.includes(searchTerm) ? 'block' : 'none';
            });
        });
    });
</script>

@endsection