<?php 

namespace App\Model;
class Usuario {
  private $id_usuario;
    private $nome_usuario;
    private $email_usuario;
    private $senha_usuario;

    public function __construct($id_usuario, $nome_usuario, $email_usuario, $senha_usuario){
        $this->id_usuario = $id_usuario;
        $this->nome_usuario = $nome_usuario;
        $this->email_usuario = $email_usuario;
        $this->senha_usuario = $senha_usuario;
    }

    public function getId(){
        return $this->id_usuario;
    }

    public function getNome(){
        return $this->nome_usuario;
    }

    public function getEmail(){
        return $this->email_usuario;
    }

    public function getSenha(){
        return $this->senha_usuario;
    }
}