<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail Confirmado - Nakamalist</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000000;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 600px;
            background-color: #1a1a1a;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(255, 20, 147, 0.2);
            text-align: center;
        }
        .logo {
            color: #ff1493;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        h1 {
            color: #ff1493;
            margin-bottom: 20px;
        }
        .icon-success {
            color: #4BB543;
            font-size: 72px;
            margin: 20px 0;
        }
        p {
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn-dashboard {
            display: inline-block;
            background: linear-gradient(135deg, #ff1493, #ff6b9d);
            color: white;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(255, 20, 147, 0.3);
            margin-top: 20px;
        }
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 20, 147, 0.4);
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-success">✓</div>
        <h1>E-mail Confirmado com Sucesso!</h1>
        
        <p>Parabéns nakama! Seu endereço de e-mail foi confirmado com sucesso. Agora você tem acesso completo a todos os recursos da Nakamalist.</p>
        
        <p>Estamos felizes em tê-lo(a) como parte de nossa comunidade. Prepare-se para explorar todos os conteúdos exclusivos que preparamos para você!</p>
        
         <a class="btn-dashboard" href="http://127.0.0.1:5500/login.html">Realizar o Login</a>
        
        <div class="footer">
            Equipe Nakamalist · Obrigado por se juntar à nossa jornada
        </div>
    </div>
</body>
</html>