<?php

namespace App\Models;
use CodeIgniter\Model;

class SoldeModel extends Model { 
    protected $table = 'soldes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['employe_id', 'type_conge_id', 'annee', 'jours_attribues', 'jours_pris'];

   
    public function getSoldeRestant($employe_id, $annee = 2026) { 
        $data = $this->where(['employe_id' => $employe_id, 'annee' => $annee])->findAll();
        foreach ($data as &$row) {
            $row['restant'] = $row['jours_attribues'] - $row['jours_pris'];
        }
        return $data;
    }
}