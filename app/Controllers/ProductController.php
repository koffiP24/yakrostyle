<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\CategorieModel;

class ProductController extends BaseController
{
    public function index()
    {
        $model = new ProduitModel();
        $data = [
            'titre'      => 'YakroStyle – Vêtements de qualité à Yamoussoukro',
            'produits'   => $model->tousAvecCategorie(),
            'categories' => (new CategorieModel())->toutes()
        ];
        return view('products/index', $data);
    }

    public function parCategorie($slug)
    {
        $model = new ProduitModel();
        $data = [
            'titre'      => 'Catégorie : ' . ucfirst($slug),
            'produits'   => $model->parCategorie($slug),
            'categories' => (new CategorieModel())->toutes()
        ];
        return view('products/index', $data);
    }

    public function parGenre($genre)
    {
        $model = new ProduitModel();
        $data = [
            'titre'      => 'Genre : ' . ucfirst($genre),
            'produits'   => $model->parGenre($genre),
            'categories' => (new CategorieModel())->toutes()
        ];
        return view('products/index', $data);
    }

    public function detail($slug)
    {
        $produit = (new ProduitModel())->parSlug($slug);
        if (!$produit) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('products/detail', [
            'titre'      => $produit['nom'],
            'produit'    => $produit,
            'categories' => (new CategorieModel())->toutes()
        ]);
    }
}