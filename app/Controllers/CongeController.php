<?php

namespace App\Controllers;
use App\Models\CongeModel;
use App\Models\SoldeModel;

class CongeController extends BaseController {
    
    public function index() {
        $congeModel = new \App\Models\CongeModel();
        $soldeModel = new \App\Models\SoldeModel();
        $user = session()->get('user');

        $data = [
            'mes_conges' => $congeModel->where('employe_id', $user['id'])->findAll(),
            'mes_soldes' => $soldeModel->getSoldeRestant($user['id'])
        ];
        return view('employer/dashboard', $data); // Dossier 'employer' (image_4a3679.png)
    }

    public function creer() {
        $congeModel = new \App\Models\CongeModel();
        
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');

        // Calcul du nombre de jours
        $start = new \DateTime($dateDebut);
        $end = new \DateTime($dateFin);
        $diff = $start->diff($end);
        $nbJours = $diff->days + 1; // +1 pour inclure le jour de fin

        $insertData = [
            'employe_id'    => session()->get('user')['id'], 
            'type_conge_id' => $this->request->getPost('type_id'), 
            'date_debut'    => $dateDebut,
            'date_fin'      => $dateFin,
            'nb_jours'      => $nbJours, // ON AJOUTE CETTE LIGNE
            'statut'        => 'en_attente',
            'traite_par'    => 'Non traité' 
        ];

        $congeModel->insert($insertData);
        return redirect()->to('/employer/dashboard')->with('success', 'Demande envoyée !');
    }
}