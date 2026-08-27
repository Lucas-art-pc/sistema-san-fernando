<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Fabrica San Fernando</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css" />
    
</head>

<body>
    <div class="login-page">
        <div class="login-left">
            <div class="brand">
                <div class="logo">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="32" height="32" rx="8" fill="#C1121F" />
                        <text x="16" y="21" text-anchor="middle" font-family="Poppins, sans-serif" font-size="16" font-weight="700" fill="#FFF">SF</text>
                    </svg>
                    <span>Finanças<br><strong>San Fernando</strong></span>
                </div>
                <h1>Gestão financeira com foco na sua fábrica</h1>
                <p>Controle fluxo de caixa, metas e desempenho com mais clareza e rapidez.</p>
            </div>

        </div>


        <div class="login-right">
            <div class="login-box">
                <div class="login-header">
                    <h2>Bem-vindo de volta</h2>
                    <p>Entre com suas credenciais para acessar o dashboard</p>
                </div>

                <form id="loginForm" class="login-form" action="/login" method="post" novalidate>
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <div class="input-wrapper">
                            <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <input type="email" id="email" name="email_usuario" placeholder="seu@email.com" required autocomplete="email" />
                        </div>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <div class="input-group">
                        <label for="password">Senha</label>
                        <div class="input-wrapper">
                            <svg class="icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            <input type="password" id="password" name="senha_usuario" placeholder="••••••••" required autocomplete="current-password" />
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Mostrar senha">
                                <svg class="eye" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg class="eye-off hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>
                        <span class="error-message" id="passwordError"></span>
                    </div>

                    <div class="form-options">
                        <span class="forgot"><a href="mailto:suporte@fabrica-sf.com?subject=Recuperacao de Senha" target="_blank" rel="noopener noreferrer">Esqueceu a senha?</a></span>
                    </div>

                    <button type="submit" name="submit" class="btn-login" id="btnLogin">
                        <span class="btn-text">Entrar no sistema</span>
                        <span class="spinner hidden"></span>
                    </button>
                </form>


            </div>


        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script src="../js/script.js"></script>
</body>

</html>