<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('utilisateurs');
        $email = 'admin@yakrostyle.ci';
        $data = [
            'nom'          => 'Admin Yakro',
            'email'        => $email,
            'mot_de_passe' => password_hash('Admin12345!', PASSWORD_BCRYPT),
            'role'         => 'admin',
            'created_at'   => date('Y-m-d H:i:s'),
        ];

        $existing = $builder->where('email', $email)->get()->getRowArray();
        if ($existing) {
            $builder->where('id', $existing['id'])->update($data);
        } else {
            $builder->insert($data);
        }
    }
}
