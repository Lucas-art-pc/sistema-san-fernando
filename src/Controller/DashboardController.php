<?php

namespace App\Controller;

use App\Controller\Controller;

class DashboardController implements Controller
{
    public function requestProcess()
    {
        
        require_once __DIR__ . '/../../Views/dashboard.php';
    }
}