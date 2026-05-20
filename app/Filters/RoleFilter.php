<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user = $session->get('user');
        //$argument contient tout (les) rôle(s) autorisé(s) . Ex: ['admin'] ou ['admin','bibliothècaire']
        if(!$user || !in_array($user['role'],$arguments ?? [])){
            return redirect()->to('/')->with('erreur', 'Acces refusé : droit insuffisants');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}