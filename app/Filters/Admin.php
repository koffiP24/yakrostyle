<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Admin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return redirect()->to('/connexion')->with('erreur', 'Accès réservé aux administrateurs');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}