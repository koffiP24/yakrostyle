<?php

namespace App\Models;

use CodeIgniter\Model;

class ProduitModel extends Model
{
    protected $table = 'produits';
    protected $primaryKey = 'id';
    protected $allowedFields = ['categorie_id', 'genre', 'nom', 'slug', 'description', 'prix', 'stock', 'image', 'style', 'tissu', 'actif', 'promo'];
    protected $useTimestamps = true;

    public function tousAvecCategorie()
    {
        return $this->select('produits.*, categories.nom as categorie_nom, categories.slug as categorie_slug')
            ->join('categories', 'categories.id = produits.categorie_id')
            ->where('produits.actif', 1)
            ->orderBy('produits.created_at', 'DESC')
            ->findAll();
    }

    public function parCategorie($slug)
    {
        return $this->select('produits.*, categories.nom as categorie_nom')
            ->join('categories', 'categories.id = produits.categorie_id')
            ->where('categories.slug', $slug)
            ->where('produits.actif', 1)
            ->orderBy('produits.created_at', 'DESC')
            ->findAll();
    }

    public function parGenre($genre)
    {
        $builder = $this->select('produits.*, categories.nom as categorie_nom')
            ->join('categories', 'categories.id = produits.categorie_id')
            ->where('produits.actif', 1);

        if (in_array($genre, ['homme', 'femme'], true)) {
            $builder->groupStart()
                ->where('produits.genre', $genre)
                ->orWhere('produits.genre', 'mixte')
                ->groupEnd();
        } else {
            $builder->where('produits.genre', $genre);
        }

        return $builder->orderBy('produits.created_at', 'DESC')->findAll();
    }

    public function parSlug($slug)
    {
        return $this->select('produits.*, categories.nom as categorie_nom')
            ->join('categories', 'categories.id = produits.categorie_id')
            ->where('produits.slug', $slug)
            ->where('produits.actif', 1)
            ->first();
    }

    public function diminuerStock($id, $quantite)
    {
        return $this->set('stock', "stock - $quantite", false)
            ->where('id', $id)
            ->update();
    }
}
