<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'email', 'mot_de_passe', 'role'];
    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[utilisateurs.email]',
        'nom'   => 'required|min_length[2]',
    ];

    public function creer(string $nom, string $email, string $mdp): int|false
    {
        $data = [
            'nom'          => $nom,
            'email'        => $email,
            'mot_de_passe' => password_hash($mdp, PASSWORD_BCRYPT),
            'role'         => 'client'
        ];
        if (!$this->validate($data)) return false;
        $this->insert($data);
        return $this->insertID();
    }

    public function verifier(string $email, string $mdp): ?array
    {
        $user = $this->where('email', $email)->first();
        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            return $user;
        }
        return null;
    }
}