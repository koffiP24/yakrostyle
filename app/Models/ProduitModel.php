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
                    ->findAll();
    }

    public function parGenre($genre)
    {
        return $this->select('produits.*, categories.nom as categorie_nom')
                    ->join('categories', 'categories.id = produits.categorie_id')
                    ->where('produits.genre', $genre)
                    ->where('produits.actif', 1)
                    ->findAll();
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