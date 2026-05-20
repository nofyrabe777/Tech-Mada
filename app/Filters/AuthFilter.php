<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponsableInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if(!$session->get('user')){
            return redirect()->to('/login')->with('erreur' , 'Connectez-vous pour acceder à cette page');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

}