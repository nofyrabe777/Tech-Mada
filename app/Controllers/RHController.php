<?php

namespace App\Controllers;
use App\Models\CongeModel;
use App\Models\SoldeModel;

class RHController extends BaseController {

    public function dashboardRH() {
        $congeModel = new CongeModel();
        $data['demandes'] = $congeModel->getDemandesEnAttente();
        return view('RH/dashboard', $data);
    }

    public function validerConge($id) { // 'id' au lieu de 'id_conge'
        $congeModel = new CongeModel();
        
        $congeModel->update($id, [
            'statut' => 'approuvee',
            'traite_par' => session()->get('user')['nom'] // CORRECTION : match avec ta migration
        ]);

        return redirect()->back()->with('success', 'Congé validé.');
    }
}