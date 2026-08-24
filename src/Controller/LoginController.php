<?php

namespace App\Controller;

use App\Repositories\UsuariosRepository;


class LoginController implements Controller
{
    public function __construct(private UsuariosRepository $usuariosRepository) {}

    public function requestProcess()
    {
        if (isset($_POST["submit"])) {

            session_start();
            $email = filter_input(INPUT_POST, "email_usuario", FILTER_SANITIZE_EMAIL);
            $senha = filter_input(INPUT_POST, "senha_usuario");
            $usuario = $this->usuariosRepository->buscaEmail($email);

            if ($usuario && $email === $usuario['email_usuario'] && password_verify($senha, $usuario['senha_usuario'])) {
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
                header('Location: /dashboard');
                exit();
            }

            header('Location: /');
        }
    }
}
