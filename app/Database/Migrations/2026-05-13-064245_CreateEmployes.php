<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nom' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'prenom' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'email' => ['type' => 'VARCHAR', 'constraint' => '150', 'unique' => true],
            'password' => ['type' => 'VARCHAR', 'constraint' => '255'],
            'role' => ['type' => 'ENUM', 'constraint' => ['admin', 'rh', 'employe'], 'default' => 'employe'],
            'departement_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'date_embauche' => ['type' => 'DATE'],
            'actif' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('departement_id', 'departements', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employes');
    }

    public function down()
    {
        $this->forge->dropTable('employes');
    }
}
