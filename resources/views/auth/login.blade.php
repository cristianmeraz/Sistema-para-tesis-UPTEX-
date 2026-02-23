<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - UPTEX Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(0.75rem, 4vw, 2rem);
        }
        
        .login-container {
            max-width: 1100px;
            width: 100%;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .login-left {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            color: white;
            padding: clamp(1.5rem, 5vw, 3rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .login-logo {
            font-size: clamp(2rem, 8vw, 3rem);
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
        }
        
        .login-left h2 {
            font-size: clamp(1.3rem, 4vw, 2rem);
            font-weight: 700;
            margin-bottom: clamp(0.75rem, 2vw, 1rem);
        }
        
        .login-left p {
            font-size: clamp(0.9rem, 2.5vw, 1.1rem);
            opacity: 0.9;
            margin-bottom: clamp(1.5rem, 4vw, 2rem);
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: clamp(0.5rem, 2vw, 1rem);
            margin-bottom: clamp(0.75rem, 2vw, 1rem);
            font-size: clamp(0.85rem, 2vw, 1rem);
        }
        
        .feature-item i {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            color: #A5F3FC;
            flex-shrink: 0;
        }
        
        .login-right {
            padding: clamp(1.5rem, 5vw, 3rem);
        }
        
        .login-right h3 {
            font-size: clamp(1.3rem, 3vw, 1.75rem);
            font-weight: 700;
            margin-bottom: clamp(0.25rem, 1vw, 0.5rem);
        }
        
        .login-right p {
            color: #64748B;
            margin-bottom: clamp(1.5rem, 3vw, 2rem);
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }
        
        .form-floating {
            margin-bottom: clamp(1rem, 3vw, 1.5rem);
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #E2E8F0;
            padding: clamp(0.5rem, 2vw, 1rem);
            font-size: clamp(0.9rem, 2vw, 0.95rem);
            min-height: 44px;
        }
        
        .form-control:focus {
            border-color: #4F46E5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: clamp(0.75rem, 2vw, 1rem);
            border-radius: 10px;
            font-weight: 600;
            font-size: clamp(0.9rem, 2vw, 1rem);
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            border: none;
            color: white;
            transition: all 0.3s;
            min-height: 44px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.4);
        }
        
        .divider {
            text-align: center;
            margin: clamp(1rem, 3vw, 1.5rem) 0;
            color: #94A3B8;
            position: relative;
            font-size: clamp(0.8rem, 2vw, 0.9rem);
        }
        
        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #E2E8F0;
        }
        
        .divider::before {
            left: 0;
        }
        
        .divider::after {
            right: 0;
        }
        
        .register-link {
            text-align: center;
            margin-top: clamp(1rem, 3vw, 1.5rem);
            color: #64748B;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }
        
        .register-link a {
            color: #4F46E5;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .form-check {
            margin-bottom: clamp(1rem, 2vw, 1.5rem);
        }
        
        .form-check-label {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            margin-left: 0.5rem;
        }
        
        .alert {
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            margin-bottom: clamp(1rem, 2vw, 1.5rem);
        }

        @media (max-width: 991.98px) {
            body {
                align-items: flex-start;
                padding-top: clamp(1rem, 4vw, 2rem);
                padding-bottom: clamp(1rem, 4vw, 2rem);
            }
            .login-left {
                text-align: center;
                align-items: center;
            }
            .login-left p {
                margin-bottom: clamp(0.75rem, 2vw, 1rem);
            }
            .features {
                display: none;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: clamp(0.5rem, 3vw, 1rem);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="row g-0 login-card">
            <div class="col-lg-5 login-left">
                <div class="login-logo">
                    <i class="bi bi-ticket-perforated-fill"></i>
                </div>
                <h2>Sistema de Tickets</h2>
                <p>Universidad Politécnica de Texcoco</p>
                <div class="features">
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Gestión eficiente de solicitudes</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Seguimiento en tiempo real</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Soporte técnico especializado</span>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7 login-right">
                <h3>Bienvenido</h3>
                <p>Ingresa tus credenciales para continuar</p>
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    
                    <div class="form-floating">
                        <input type="email" 
                               class="form-control @error('correo') is-invalid @enderror" 
                               id="correo" 
                               name="correo" 
                               placeholder="correo@uptex.edu.mx"
                               value="{{ old('correo') }}"
                               required>
                        <label for="correo">Correo Electrónico</label>
                    </div>
                    
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Contraseña"
                               required>
                        <label for="password">Contraseña</label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>
                        Iniciar Sesión
                    </button>
                </form>
                
                <div class="divider">o</div>
                
                <div class="register-link">
                    ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>