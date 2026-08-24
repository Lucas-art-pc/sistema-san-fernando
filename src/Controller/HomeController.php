<?php

namespace App\Controller;

use App\Controller\Controller;

class HomeController implements Controller
{
    public function requestProcess()
    {
        require_once __DIR__ . '/../../Views/login.php';
    }
}