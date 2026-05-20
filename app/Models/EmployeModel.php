<?php

namespace App\Models;
use CodeIgniter\Model;

class EmployeModel extends Model {
    protected $table = 'employes';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['nom', 'prenom', 'email', 'password', 'role', 'departement_id', 'date_embauche', 'actif'];
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[employes.email,id,{id}]',
        'password' => 'required|min_length[5]'
    ];
    
    
    public function getEmployesWithDept() {
        return $this->select('employes.*, departements.nom as nom_departement') // 'nom' est le champ dans ta migration
                    ->join('departements', 'departements.id = employes.departement_id') // 'id' et 'departement_id'
                    ->findAll();
    }

    public function RegisterForAdmin($data){
        return $this->insert($data);
    }

    protected function attribuerSoldesParDefaut(array $data)
    {
        if (isset($data['id'])) {
            $soldeModel = new \App\Models\SoldeModel();
            $anneeActuelle = date('Y'); 

            $soldesParDefaut = [
                [
                    'employe_id'     => $data['id'],
                    'type_conge_id'  => 1, // 1 = Congé Annuel
                    'annee'          => $anneeActuelle,
                    'jours_attribues'=> 30, // Valeur par défaut
                    'jours_pris'     => 0
                ],
                [
                    'employe_id'     => $data['id'],
                    'type_conge_id'  => 2, // 2 = Maladie
                    'annee'          => $anneeActuelle,
                    'jours_attribues'=> 14,  // Valeur par défaut
                    'jours_pris'     => 0
                ]
            ];

            // On insère les droits d'un coup dans la table 'soldes'
            $soldeModel->insertBatch($soldesParDefaut);
        }

        return $data;
    }
}