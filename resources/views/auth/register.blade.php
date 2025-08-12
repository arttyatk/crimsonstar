<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar - Sistema Moderno</title>
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
            min-height: 100vh;
            margin: 0;
            color: white;
            padding: 1rem;
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
        
        .register-container {
            background: var(--gray-dark);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transform: scale(1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .register-container:hover {
            transform: scale(1.01);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        
        .register-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .register-header h1 {
            color: white;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .register-header p {
            color: var(--pink-lighter);
            font-size: 1rem;
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
            width: 100%;
            padding: 0.9rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
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

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.6);
            padding: 0;
        }

        .toggle-password:hover {
            color: white;
        }
        
        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-pink), var(--pink-light));
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 45, 107, 0.3);
            margin-top: 0.5rem;
            letter-spacing: 0.5px;
        }
        
        .btn-register:hover {
            background: linear-gradient(135deg, var(--pink-light), var(--primary-pink));
            box-shadow: 0 6px 20px rgba(255, 45, 107, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-register:active {
            transform: translateY(0);
        }
        
        .register-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.9rem;
            color: var(--pink-lighter);
        }
        
        .register-footer a {
            color: var(--pink-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        
        .register-footer a:hover {
            color: white;
        }
        
        .register-footer a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--pink-light);
            transition: width 0.3s;
        }
        
        .register-footer a:hover::after {
            width: 100%;
        }
        
        .register-footer p {
            margin: 0.7rem 0;
        }
        
        .input-error {
            color: #ff6b6b;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }
        
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: var(--gray-dark);
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: var(--primary-pink);
            transition: width 0.3s;
        }
        
        @media (max-width: 480px) {
            .register-container {
                padding: 1.8rem;
            }
            
            .register-header h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Crie sua conta</h1>
            <p>Preencha os dados abaixo para se registrar</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <div class="form-group">
                <label for="name" class="input-label">Nome completo</label>
                <input id="name" class="text-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Seu nome completo">
                @if($errors->has('name'))
                    <span class="input-error">{{ $errors->first('name') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="email" class="input-label">E-mail</label>
                <input id="email" class="text-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="seu@email.com">
                @if($errors->has('email'))
                    <span class="input-error">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="input-label">Senha</label>
                <div style="position: relative;">
                    <input id="password" class="text-input" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" oninput="checkPasswordStrength(this.value)">
                    <button type="button" class="toggle-password" onclick="togglePassword('password', this)">👁️</button>
                </div>
                <div class="password-strength">
                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                </div>
                @if($errors->has('password'))
                    <span class="input-error">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="input-label">Confirme a senha</label>
                <div style="position: relative;">
                    <input id="password_confirmation" class="text-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', this)">👁️</button>
                </div>
                @if($errors->has('password_confirmation'))
                    <span class="input-error">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <button type="submit" class="btn-register">
                Criar conta
            </button>
        </form>

        <div class="register-footer">
            <p>Já tem uma conta? <a href="{{ route('login') }}">Faça login</a></p>
        </div>
    </div>

    <script>
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('passwordStrengthBar');
            let strength = 0;

            if (password.length >= 8) strength += 1;
            if (password.length >= 12) strength += 1;
            if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 1;
            if (/\d/.test(password)) strength += 1;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;

            const width = strength * 20;
            strengthBar.style.width = width + '%';

            if (width <= 40) {
                strengthBar.style.backgroundColor = '#ff6b6b';
            } else if (width <= 80) {
                strengthBar.style.backgroundColor = '#ffb347';
            } else {
                strengthBar.style.backgroundColor = '#4ade80';
            }
        }

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            btn.textContent = isHidden ? "🙈" : "👁️";
        }
    </script>
</body>
</html>