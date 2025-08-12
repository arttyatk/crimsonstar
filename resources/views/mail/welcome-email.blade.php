<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Poppins:wght@400;600&display=swap');
        
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
            font-family: 'Poppins', sans-serif;
        }
        
        .container {
            max-width: 600px;
            margin: 40px auto;
            overflow: hidden;
            position: relative;
        }
        
        .glow-effect {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,45,110,0.3) 0%, rgba(255,45,110,0) 70%);
            z-index: 0;
        }
        
        .glow-1 {
            top: -100px;
            left: -100px;
        }
        
        .glow-2 {
            bottom: -100px;
            right: -100px;
        }
        
        .card {
            position: relative;
            background: rgba(20, 20, 20, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
            z-index: 1;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }
        
        .header {
            background: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80') center/cover;
            height: 180px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(255,45,110,0.3) 0%, rgba(0,0,0,0.7) 100%);
        }
        
        .logo {
            position: relative;
            z-index: 2;
            width: 200px;
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.5));
        }
        
        .content {
            padding: 40px;
            color: #ffffff;
        }
        
        h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 32px;
            background: linear-gradient(to right, #ff2d6e, #ff6b9e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0 0 20px 0;
            text-align: center;
            letter-spacing: -1px;
        }
        
        p {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255,255,255,0.8);
            margin-bottom: 30px;
            margin-left: 25px;
        }
        
        .button-container {
            text-align: center;
            margin: 40px 0;
        }
        
        .cta-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(45deg, #ff2d6e 0%, #ff6b9e 100%);
            color: white !important;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            border-radius: 50px;
            box-shadow: 0 10px 20px rgba(255,45,110,0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(255,45,110,0.4);
        }
        
        .cta-button:active {
            transform: translateY(1px);
        }
        
        .cta-button::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        }
        
        .footer {
            padding: 30px;
            text-align: center;
            background: rgba(0,0,0,0.3);
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .footer-links {
            margin-bottom: 20px;
        }
        
        .footer-links a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #ff2d6e;
        }
        
        .copyright {
            color: rgba(255,255,255,0.5);
            font-size: 12px;
            margin-top: 10px;
        }
        
        .disclaimer {
            font-size: 12px;
            color: rgba(255,255,255,0.4);
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="glow-effect glow-1"></div>
        <div class="glow-effect glow-2"></div>
        
        <div class="card">
            <div class="header">
                <div class="header-overlay"></div>
                <img src="{{ asset('logonakama.png') }}" class="logo">
            </div>
            
            <div class="content">
                <h1>CONFIRME SEU E-MAIL</h1>
                
                <p>E aí, Nakama! Estamos tão animados para tê-lo a bordo! Estamos prestes a embarcar em uma jornada incrível, mas antes, precisamos que você confirme seu e-mail para liberar todo o conteúdo exclusivo que preparamos para você.</p>
                
                <div class="button-container">
                    <a href="http://127.0.0.1:8000/valida_email/{{$user->codigo}}" class="cta-button"> Autenticar email </a>
                </div>
                
                <p class="disclaimer">Se você não se cadastrou no Nakama List, pode ignorar este e-mail. Alguém deve ter digitado o e-mail errado. Se foi um engano, não se preocupe - nenhuma ação é necessária de sua parte.</p>
            </div>
            
            <div class="footer">
                <div class="footer-links">
                    <a href="#">Ajuda</a>
                    <a href="#">Suporte</a>
                    <a href="#">Termos</a>
                    <a href="#">Privacidade</a>
                </div>
                <div class="copyright">
                    © 2025 Nakama List. Todos os direitos reservados.
                </div>
            </div>
        </div>
    </div>
</body>
</html>