<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema Moderno</title>
    <style>
        :root {
            --primary-black: #121212;
            --primary-pink: #ff2d6b;
            --pink-light: #ff7b9c;
            --pink-lighter: #ffb3c6;
            --gray-dark: #2a2a2a;
            --gray-light: #e0e0e0;
        }
        
   body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: var(--primary-black);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    color: white;
    position: relative;
    overflow: hidden;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('fundo22.png') no-repeat center center fixed;
    background-size: cover;
    filter: brightness(0.11) blur(3px); /* escurece e desfoca a imagem */
    z-index: -1; /* garante que fique atrás do conteúdo */
}


        .login-container {
            background: var(--gray-dark);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transform: scale(1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .login-container:hover {
            transform: scale(1.01);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .login-header h1 {
            color: white;
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .login-header p {
            color: var(--pink-lighter);
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }
        
        .input-label {
            display: block;
            margin-bottom: 0.6rem;
            color: white;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .text-input {
            width: 95%;
            padding: 0.9rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            font-size: 0.95rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .text-input:focus {
            outline: none;
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 3px rgba(255, 45, 107, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }
        
        .text-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        
        .btn-login {
            width: 103%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-pink), var(--pink-light));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 45, 107, 0.3);
            margin-top: 0.5rem;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, var(--pink-light), var(--primary-pink));
            box-shadow: 0 6px 20px rgba(255, 45, 107, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-container input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-pink);
            margin-right: 0.7rem;
            cursor: pointer;
        }
        
        .checkbox-container span {
            color: var(--gray-light);
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: var(--pink-lighter);
        }
        
        .login-footer a {
            color: var(--pink-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        
        .login-footer a:hover {
            color: white;
        }
        
        .login-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--pink-light);
            transition: width 0.3s;
        }
        
        .login-footer a:hover::after {
            width: 100%;
        }
        
        .login-footer p {
            margin: 0.7rem 0;
        }
        
        .input-error {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }
        
        
        @media (max-width: 480px) {
            .login-container {
                padding: 1.8rem;
                margin: 0 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Acesse sua conta</h1>
            <p>Entre com suas credenciais para continuar</p>
        </div>


        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="input-label">E-mail</label>
                <input id="email" class="text-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seu@email.com">
                @if($errors->has('email'))
                    <span class="input-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="input-label">Senha</label>
                <input id="password" class="text-input" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                @if($errors->has('password'))
                    <span class="input-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="checkbox-container">
                <input id="remember_me" type="checkbox" name="remember">
                <span>Lembrar-me</span>
            </div>

            <button type="submit" class="btn-login">
                Entrar
            </button>
        </form>

        <div class="login-footer">
            <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
            @if (Route::has('password.request'))
                <p><a href="{{ route('password.request') }}">Esqueceu sua senha?</a></p>
            @endif
        </div>
    </div>
</body>
</html>