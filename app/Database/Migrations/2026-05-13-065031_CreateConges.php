<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConges extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'employe_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'type_conge_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'date_debut' => ['type' => 'DATE'],
            'date_fin' => ['type' => 'DATE'],
            'nb_jours' => ['type' => 'INT', 'constraint' => 11],
            'motif' => ['type' => 'TEXT', 'null' => true],
            'statut' => ['type' => 'ENUM', 'constraint' => ['en_attente', 'approuvee', 'refusee', 'annulee'], 'default' => 'en_attente'],
            'commentaire_rh' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'traite_par' => ['type' => 'INT', 'null' => true]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employe_id', 'employes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('type_conge_id', 'types_conge', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('conges');
    }

    public function down()
    {
        $this->forge->dropTable('conges');
    }
}
