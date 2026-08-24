<?php

namespace App\Repositories;

use PDO;

class UsuariosRepository
{
  
  public function __construct(private \PDO $pdo)
  {
  }

  public function buscaEmail($email)
  {
    $sql = "SELECT * FROM tb_usuario WHERE email_usuario = :email";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario ?: null;
  }

  
}
