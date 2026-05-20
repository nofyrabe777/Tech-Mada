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
}