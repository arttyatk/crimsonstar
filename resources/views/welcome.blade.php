<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnimeFlare | Explosão de Cores</title>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;700&family=Poppins:wght@900&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-pink: #ff00ff;
            --electric-blue: #00f7ff;
            --lime-green: #00ff9d;
            --violet: #9600ff;
            --sun-yellow: #ffde00;
            --black: #000000;
            --dark-gray: #111111;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Oxanium', sans-serif;
        }
        
        body {
            background-color: var(--black);
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
        }
        
        .hero-container {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            isolation: isolate;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            max-width: 1200px;
        }
        
        .logo {
            font-family: 'Poppins', sans-serif;
            font-size: 4rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, 
                var(--neon-pink) 0%, 
                var(--electric-blue) 33%, 
                var(--lime-green) 66%, 
                var(--violet) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
            animation: logoGlow 2s infinite alternate;
        }
        
        @keyframes logoGlow {
            from { text-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
            to { text-shadow: 0 0 25px rgba(255, 255, 255, 0.6); }
        }
        
        .tagline {
            font-size: 1.8rem;
            margin-bottom: 2rem;
            background: linear-gradient(90deg, 
                var(--sun-yellow), 
                var(--neon-pink));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .description {
            font-size: 1.2rem;
            line-height: 1.6;
            margin-bottom: 3rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-button {
            display: inline-block;
            padding: 1.2rem 3rem;
            font-size: 1.3rem;
            font-weight: bold;
            text-decoration: none;
            color: white;
            background: linear-gradient(45deg, 
                var(--neon-pink), 
                var(--violet));
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(150, 0, 255, 0.4);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: none;
            cursor: pointer;
        }
        
        .cta-button:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(150, 0, 255, 0.6);
        }
        
        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, 
                transparent, 
                rgba(255, 255, 255, 0.2), 
                transparent);
            transition: 0.5s;
            z-index: -1;
        }
        
        .cta-button:hover::before {
            left: 100%;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: 0.7;
            animation: float 15s infinite linear;
        }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, 50px) rotate(90deg); }
            50% { transform: translate(0, 100px) rotate(180deg); }
            75% { transform: translate(-50px, 50px) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
        
        .element-1 {
            width: 300px;
            height: 300px;
            background: var(--neon-pink);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .element-2 {
            width: 400px;
            height: 400px;
            background: var(--electric-blue);
            bottom: 15%;
            right: 10%;
            animation-delay: 2s;
            animation-duration: 20s;
        }
        
        .element-3 {
            width: 250px;
            height: 250px;
            background: var(--lime-green);
            top: 50%;
            left: 30%;
            animation-delay: 4s;
            animation-duration: 18s;
        }
        
        .element-4 {
            width: 350px;
            height: 350px;
            background: var(--violet);
            top: 30%;
            right: 25%;
            animation-delay: 1s;
            animation-duration: 25s;
        }
        
        .element-5 {
            width: 200px;
            height: 200px;
            background: var(--sun-yellow);
            bottom: 20%;
            left: 20%;
            animation-delay: 3s;
            animation-duration: 22s;
        }
        
        .social-links {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            gap: 1rem;
            z-index: 100;
        }
        
        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            color: white;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-icon:hover {
            transform: translateY(-5px) scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .nav-links {
            position: fixed;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 1.5rem;
            z-index: 100;
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            position: relative;
            padding: 0.5rem 0;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--neon-pink), var(--electric-blue));
            transition: width 0.3s ease;
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .cursor-follower {
            position: fixed;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: radial-gradient(circle, 
                rgba(255, 0, 255, 0.5) 0%, 
                rgba(0, 247, 255, 0.3) 50%, 
                transparent 70%);
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 999;
            mix-blend-mode: screen;
            transition: transform 0.1s ease;
        }
        
        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }
            
            .tagline {
                font-size: 1.3rem;
            }
            
            .description {
                font-size: 1rem;
            }
            
            .cta-button {
                padding: 1rem 2rem;
                font-size: 1.1rem;
            }
            
            .floating-elements {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="cursor-follower"></div>
    
    <div class="hero-container">
        <div class="floating-elements">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
            <div class="floating-element element-4"></div>
            <div class="floating-element element-5"></div>
        </div>
        
        <nav class="nav-links">
            <a href="#" class="nav-link">Sobre</a>
            <a href="#" class="nav-link">Contato</a>
        </nav>
        
        <div class="hero-content">
            <h1 class="logo">NAKAMALIST</h1>
            <p class="tagline">Onde os animes ganham vida</p>
            <p class="description">Descubra o universo vibrante dos animes em nossa plataforma exclusiva. Acompanhe aos melhores títulos e leia suas sinopses.</p>
            <a href="/login" class="cta-button">ENTRAR AGORA</a>
        </div>
        
    </div>

    <script>
        // Efeito de cursor personalizado
        const cursor = document.querySelector('.cursor-follower');
        
        document.addEventListener('mousemove', (e) => {
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            
            // Efeito de interação com botões
            const target = e.target;
            if (target.classList.contains('cta-button') {
                cursor.style.transform = 'translate(-50%, -50%) scale(2)';
                cursor.style.background = 'radial-gradient(circle, rgba(255, 0, 255, 0.7) 0%, rgba(0, 247, 255, 0.5) 50%, transparent 70%)';
            } else if (target.classList.contains('social-icon') || target.classList.contains('nav-link')) {
                cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
                cursor.style.background = 'radial-gradient(circle, rgba(0, 255, 157, 0.7) 0%, rgba(150, 0, 255, 0.5) 50%, transparent 70%)';
            } else {
                cursor.style.transform = 'translate(-50%, -50%) scale(1)';
                cursor.style.background = 'radial-gradient(circle, rgba(255, 0, 255, 0.5) 0%, rgba(0, 247, 255, 0.3) 50%, transparent 70%)';
            }
        });
        
        // Efeito de digitação no título (opcional)
        const tagline = document.querySelector('.tagline');
        const originalText = tagline.textContent;
        tagline.textContent = '';
        
        let i = 0;
        const typingEffect = setInterval(() => {
            if (i < originalText.length) {
                tagline.textContent += originalText.charAt(i);
                i++;
            } else {
                clearInterval(typingEffect);
            }
        }, 100);
    </script>
</body>
</html>