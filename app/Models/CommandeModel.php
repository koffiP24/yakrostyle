<?php

namespace App\Models;

use CodeIgniter\Model;

class CommandeModel extends Model
{
    protected $table = 'commandes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'statut', 'total', 'adresse'];

    public function creerDepuisPanier(int $userId, string $adresse, array $panier): int|false
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));
        $db->table('commandes')->insert([
            'user_id'    => $userId,
            'adresse'    => $adresse,
            'total'      => $total,
            'statut'     => 'en_attente',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        $commandeId = $db->insertID();

        foreach ($panier as $ligne) {
            $db->table('commande_lignes')->insert([
                'commande_id' => $commandeId,
                'produit_id'  => $ligne['id'],
                'quantite'    => $ligne['quantite'],
                'prix_unit'   => $ligne['prix']
            ]);
        }

        $db->transComplete();
        return $db->transStatus() ? $commandeId : false;
    }

    public function detail(int $id): ?array
    {
        $cmd = $this->find($id);
        if (!$cmd) return null;
        $cmd['lignes'] = $this->db->table('commande_lignes cl')
            ->select('cl.*, p.nom, p.image')
            ->join('produits p', 'p.id = cl.produit_id')
            ->where('cl.commande_id', $id)
            ->get()->getResultArray();
        return $cmd;
    }

    public function toutesAvecUser()
    {
        return $this->select('commandes.*, utilisateurs.nom as client_nom')
                    ->join('utilisateurs', 'utilisateurs.id = commandes.user_id')
                    ->orderBy('commandes.created_at', 'DESC')
                    ->findAll();
    }
}