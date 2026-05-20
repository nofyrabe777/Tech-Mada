<?php

namespace App\Controllers;

use App\Models\DepartementModel;
use App\Models\EmployeModel;
use CodeIgniter\Controller;

class AdminController extends Controller {

    public function users() {
        $model = new EmployeModel();
        // Utilisation de la méthode de ton binôme corrigée
        $data['employes'] = $model->getEmployesWithDept();
        return view('admin/utilisateurs', $data);
    }

    public function create() {
        $depModel = new \App\Models\DepartementModel();
        $data['departements'] = $depModel->findAll();
        return view('admin/form_employe', $data);
    }

    public function creer() {
        $congeModel = new \App\Models\CongeModel();
        
        $insertData = [
            'employe_id'    => session()->get('user')['id'], 
            'type_conge_id' => $this->request->getPost('type_id'), 
            'date_debut'    => $this->request->getPost('date_debut'),
            'date_fin'      => $this->request->getPost('date_fin'),
            'statut'        => 'en_attente'
        ];

        if ($congeModel->insert($insertData)) {
            return redirect()->to('/employer/dashboard')->with('success', 'Demande enregistrée !');
        }
    }

    public function save() {
        $model = new \App\Models\EmployeModel(); // Vérifie bien que c'est l'EmployeModel ici
        
        $data = [
            'nom'            => $this->request->getPost('nom'),
            'prenom'         => $this->request->getPost('prenom'),
            'email'          => $this->request->getPost('email'),
            'password'       => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'           => $this->request->getPost('role'),
            'departement_id' => $this->request->getPost('departement_id'),
            'date_embauche'  => $this->request->getPost('date_embauche'),
            'actif'          => 1
        ];

        $model->insert($data);
        return redirect()->to('/admin/utilisateurs');
    }

    public function delete($id) {
        $model = new \App\Models\EmployeModel();
        $currentUserId = session()->get('user')['id']; // On récupère l'ID de celui qui est connecté

        // Vérification : l'ID à supprimer est-il le même que celui de la session ?
        if ($id == $currentUserId) {
            return redirect()->back()->with('error', 'Action impossible : vous ne pouvez pas supprimer votre propre compte.');
        }

        $model->delete($id);
        return redirect()->to('/admin/utilisateurs')->with('success', 'Employé supprimé.');
    }
}