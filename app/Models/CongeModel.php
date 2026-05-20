<?php

namespace App\Models;
use CodeIgniter\Model;

class CongeModel extends Model { 
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'employe_id', 'type_conge_id', 'date_debut', 'date_fin', 
        'nb_jours', 'motif', 'statut', 'commentaire_rh', 'created_at', 'traite_par'
    ];
    protected $useTimestamps = false; // On gère created_at manuellement ou via DB

    public function getDemandesEnAttente() {
        return $this->where('statut', 'en_attente')
                    ->select('conges.*, employes.nom, employes.prenom, types_conge.libelle')
                    ->join('employes', 'employes.id = conges.employe_id') // Corrigé : id et employe_id
                    ->join('types_conge', 'types_conge.id = conges.type_conge_id') // Corrigé : id et type_conge_id
                    ->findAll();
    }
}