<?php

namespace App\Controllers;
use App\Models\CongeModel;
use App\Models\SoldeModel;

class RHController extends BaseController {

    public function dashboardRH() {
        $congeModel = new CongeModel();
        $db = \Config\Database::connect();
        $data['demandes'] = $congeModel->getDemandesEnAttente();

        $statsType = $db->table('conges')
                        ->select('types_conge.libelle, COUNT(conges.id) as total')
                        ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                        ->groupBy('conges.type_conge_id')
                        ->get()->getResultArray();
        
        $data['camembert_labels'] = array_column($statsType, 'libelle');
        $data['camembert_values'] = array_column($statsType, 'total');

        // 3. STATS PAR MOIS
        $statsMois = $db->query("SELECT strftime('%m', date_debut) as mois, COUNT(id) as total FROM conges GROUP BY mois")->getResultArray();
        $moisValues = array_fill_keys(['01','02','03','04','05','06','07','08','09','10','11','12'], 0);
        foreach($statsMois as $row) { if(isset($moisValues[$row['mois']])) $moisValues[$row['mois']] = (int)$row['total']; }
        $data['stats_mois'] = array_values($moisValues);

        // 4. STATS PAR JOUR DE LA SEMAINE (Pas en camembert : Histogramme classique)
        $statsJours = $db->query("SELECT strftime('%w', date_debut) as jour, COUNT(id) as total FROM conges GROUP BY jour")->getResultArray();
        $joursValues = array_fill_keys(['1','2','3','4','5'], 0); // Lundi à Vendredi
        foreach($statsJours as $row) { if(isset($joursValues[$row['jour']])) $joursValues[$row['jour']] = (int)$row['total']; }
        $data['stats_jours'] = array_values($joursValues);


        return view('RH/dashboard', $data);
    }

    public function validerConge($id) { // 'id' au lieu de 'id_conge'
        $congeModel = new CongeModel();
        $conge = $congeModel->find($id);
        if ($conge) {
            $congeModel->update($id, [
                'statut' => 'approuvee',
                'traite_par' => session()->get('user')['nom'] // CORRECTION : match avec ta migration
            ]);
            $db = \Config\Database::connect();
            $db->table('soldes')
               ->where('employe_id', $conge['employe_id'])
               ->where('type_conge_id', $conge['type_conge_id'])
               ->where('annee', 2026)
               ->increment('jours_pris', $conge['nb_jours']);
        }
        

        return redirect()->back()->with('success', 'Congé validé.');
    }

    public function refuserConge($id) {
        $congeModel = new CongeModel();
        
        $congeModel->update($id, [
            'statut' => 'refusee',
            'traite_par' => session()->get('user')['nom']
        ]);

        return redirect()->back()->with('success', 'Congé refusé.');
    }
}