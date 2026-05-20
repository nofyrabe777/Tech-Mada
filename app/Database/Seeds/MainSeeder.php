<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 1. Insertion des Départements
        $depData = [
            ['nom' => 'Informatique', 'description' => 'Dév & IT'],
            ['nom' => 'Ressources Humaines', 'description' => 'Gestion du personnel'],
        ];
        $this->db->table('departements')->insertBatch($depData);

        // 2. Insertion des Types de Congés
        $typeData = [
            ['libelle' => 'Congé Annuel', 'jours_annuels' => 30, 'deductible' => 1],
            ['libelle' => 'Maladie', 'jours_annuels' => 5, 'deductible' => 0],
        ];
        $this->db->table('types_conge')->insertBatch($typeData);

        // 3. Insertion des Employés (1 Admin, 1 RH, 1 Employé)
        // Note : On utilise password_hash pour que ton AuthFilter fonctionne !
        $empData = [
            [
                'nom' => 'moi',
                'prenom' => 'Admin',
                'email' => 'admin@techmada.mg',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'departement_id' => 1,
                'date_embauche' => '2026-01-01'
            ],
            [
                'nom' => 'RAVAO',
                'prenom' => 'Sitraka',
                'email' => 'rh@techmada.mg',
                'password' => password_hash('rh123', PASSWORD_DEFAULT),
                'role' => 'rh',
                'departement_id' => 2,
                'date_embauche' => '2026-02-01'
            ],
            [
                'nom' => 'RAKOTO',
                'prenom' => 'Jean',
                'email' => 'employe@techmada.mg',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'employe', // TRÈS IMPORTANT
                'departement_id' => 1,
                'date_embauche' => '2026-03-01'
            ],
            [
                'nom' => 'RAKOTO',
                'prenom' => 'Jean',
                'email' => 'Administrator@techmada.mg',
                'password' => password_hash('administrator12', PASSWORD_DEFAULT),
                'role' => 'admin', // TRÈS IMPORTANT
                'departement_id' => 1,
                'date_embauche' => '2026-04-01'
            ],
        ];
        $this->db->table('employes')->insertBatch($empData);
    }
}
