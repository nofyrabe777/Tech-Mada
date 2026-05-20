<?php

namespace App\Controllers;
use App\Models\EmployeModel;

class AuthController extends BaseController {
    public function login() {
        return view('auth/login');
    }

    public function attemptLogin() {  
        $session = session();
        $model = new \App\Models\EmployeModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $session->set(['user' => $user, 'isLoggedIn' => true]);
            
            // Redirection intelligente selon le rôle
            if ($user['role'] === 'rh') {
                return redirect()->to('/rh/demandes');
            }else if($user['role'] === 'admin'){
                return redirect()->to('/admin/utilisateurs');
            }
            return redirect()->to('/employer/dashboard');
        }
        return redirect()->back()->with('error', 'Identifiants invalides');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/');
    }

}