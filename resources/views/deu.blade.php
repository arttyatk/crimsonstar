<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Confirmado - Nakamalist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Poppins:wght@400;600&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #300000 0%, #690202 100%);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow-x: hidden;
            position: relative;
        }
        
        .glow-effect {
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(190, 6, 6, 0.4) 0%, rgba(255,45,110,0) 70%);
            z-index: 0;
            border-radius: 50%;
            animation: pulse 4s infinite ease-in-out;
        }
        
        .glow-1 {
            top: -100px;
            left: -100px;
            animation-delay: 0.5s;
        }
        
        .glow-2 {
            bottom: -100px;
            right: -100px;
            animation-delay: 1.5s;
        }
        
        .glow-3 {
            top: 50%;
            right: 20%;
            width: 150px;
            height: 150px;
            animation-delay: 2.5s;
        }
        
        .container {
            max-width: 600px;
            background: rgba(8, 8, 8, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            z-index: 1;
            overflow: hidden;
            animation: containerAppear 1s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #300000, #8d0000, #300000);
            z-index: 2;
        }
        
        .confetti {
            position: absolute;
            width: 15px;
            height: 15px;
            background: linear-gradient(45deg, #8d0000, #ff2d2d);
            opacity: 0.8;
            z-index: 0;
        }
        
        .logo {
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        
        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 32px;
            background: linear-gradient(to right, #bf0606, #8d0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1px;
            position: relative;
            display: inline-block;
            animation: textGlow 2s infinite alternate;
        }
        
        .icon-success {
            color: #4BB543;
            font-size: 80px;
            margin: 20px 0;
            text-shadow: 0 0 20px rgba(75, 181, 67, 0.6);
            animation: iconBounce 1s ease-out, pulseGreen 2s infinite 1s;
            display: inline-block;
            margin-left: 30px;
            margin-top: 20px;
        }
        
        h1 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 32px;
            background: linear-gradient(to right, #bf0606, #8d0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin: 0 0 20px 0;
            text-align: center;
            letter-spacing: -1px;
            animation: fadeIn 1s forwards;
            animation-delay: 0.3s;
            opacity: 0;
        }
        
        p {
            font-size: 16px;
            line-height: 1.7;
            color: rgba(255,255,255,0.8);
            margin-bottom: 25px;
            animation: fadeIn 1s forwards;
            animation-delay: 0.5s;
            opacity: 0;
        }
        
        .btn-dashboard {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(45deg, #740303 0%, #8d0000 100%);
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 18px;
            border-radius: 50px;
            box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s forwards, pulseRed 3s infinite;
            animation-delay: 0.7s;
            opacity: 0;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        
        .btn-dashboard:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(160, 0, 0, 0.4);
        }
        
        .btn-dashboard:active {
            transform: translateY(1px);
        }
        
        .btn-dashboard::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
        }
        
        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            animation: fadeIn 1s forwards;
            animation-delay: 0.9s;
            opacity: 0;
        }
        
        /* Animações */
        @keyframes containerAppear {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes iconBounce {
            0% {
                transform: scale(0);
            }
            70% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: scale(1);
                opacity: 0.6;
            }
        }
        
        @keyframes pulseRed {
            0% {
                box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
            }
            50% {
                box-shadow: 0 10px 30px rgba(255, 0, 0, 0.5);
            }
            100% {
                box-shadow: 0 10px 20px rgba(255, 0, 0, 0.3);
            }
        }
        
        @keyframes pulseGreen {
            0% {
                text-shadow: 0 0 20px rgba(75, 181, 67, 0.6);
            }
            50% {
                text-shadow: 0 0 30px rgba(75, 181, 67, 0.9);
            }
            100% {
                text-shadow: 0 0 20px rgba(75, 181, 67, 0.6);
            }
        }
        
        @keyframes textGlow {
            0% {
                text-shadow: 0 0 5px rgba(191, 6, 6, 0.5);
            }
            100% {
                text-shadow: 0 0 20px rgba(191, 6, 6, 0.8), 0 0 30px rgba(191, 6, 6, 0.6);
            }
        }
        
        /* Responsividade */
        @media (max-width: 650px) {
            .container {
                margin: 20px;
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .btn-dashboard {
                padding: 14px 30px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="glow-effect glow-1"></div>
    <div class="glow-effect glow-2"></div>
    <div class="glow-effect glow-3"></div>
    
    <div class="container">
        <div class="logo">
            <span class="logo-text" style="margin-bottom: 50px;">CRIMSON STAR</span>
        </div>
        
        <div class="icon-success">
            <i class="fas fa-check-circle"></i>
        </div>
        
        <h1>E-mail Confirmado com Sucesso!</h1>
        
        <p>Parabéns Viajante! Seu endereço de e-mail foi confirmado com sucesso. Agora você tem acesso completo a todos os recursos da CrimsonStar.</p>
        
        <p>Estamos felizes em tê-lo(a) como parte de nossa comunidade. Prepare-se para explorar todos os conteúdos exclusivos que preparamos para você!</p>
        
        <a class="btn-dashboard" href="http://127.0.0.1:5501/login.html">
            <i class="fas fa-sign-in-alt"></i> Realizar o Login
        </a>
        
        <div class="footer">
            Equipe Nakamalist · Obrigado por se juntar à nossa jornada
        </div>
    </div>

    <script>
        // Criar confetti
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.container');
            const colors = ['#8d0000', '#bf0606', '#740303', '#ff2d2d'];
            
            for (let i = 0; i < 20; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = Math.random() * 100 + '%';
                confetti.style.transform = 'rotate(' + (Math.random() * 360) + 'deg)';
                confetti.style.background = `linear-gradient(45deg, ${colors[Math.floor(Math.random() * colors.length)]}, ${colors[Math.floor(Math.random() * colors.length)]})`;
                confetti.style.animation = `pulse ${2 + Math.random() * 2}s infinite ease-in-out`;
                confetti.style.animationDelay = Math.random() * 2 + 's';
                container.appendChild(confetti);
            }
        });
    </script>
</body>
</html>