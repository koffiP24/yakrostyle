<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\CategorieModel;
use App\Models\CommandeModel;
use App\Models\UtilisateurModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $produitModel = new ProduitModel();
        $commandeModel = new CommandeModel();
        $data = [
            'titre' => 'Tableau de bord',
            'nbProduits' => $produitModel->countAll(),
            'nbCommandes' => $commandeModel->countAll(),
            'nbUtilisateurs' => (new UtilisateurModel())->countAll()
        ];
        return view('admin/dashboard', $data);
    }

    // Gestion des produits
    public function produits()
    {
        $produits = (new ProduitModel())->tousAvecCategorie();
        return view('admin/produits/index', ['titre' => 'Gestion des produits', 'produits' => $produits]);
    }

    public function ajouterProduit()
    {
        $categories = (new CategorieModel())->toutes();
        return view('admin/produits/ajouter', ['titre' => 'Ajouter un produit', 'categories' => $categories]);
    }

    public function creerProduit()
    {
        $model = new ProduitModel();
        $slug = url_title($this->request->getPost('nom'), '-', true);
        $data = [
            'categorie_id' => $this->request->getPost('categorie_id'),
            'genre'        => $this->request->getPost('genre'),
            'nom'          => $this->request->getPost('nom'),
            'slug'         => $slug,
            'description'  => $this->request->getPost('description'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'style'        => $this->request->getPost('style'),
            'tissu'        => $this->request->getPost('tissu'),
            'promo'        => $this->request->getPost('promo') ?? 0
        ];
        // Gestion de l'image
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/images', $newName);
            $data['image'] = $newName;
        }
        if ($model->save($data)) {
            return redirect()->to('/admin/produits')->with('succes', 'Produit ajouté');
        } else {
            return redirect()->back()->with('erreur', 'Erreur lors de l\'ajout');
        }
    }

    public function modifierProduit($id)
    {
        $produit = (new ProduitModel())->find($id);
        $categories = (new CategorieModel())->toutes();
        if (!$produit) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('admin/produits/modifier', ['titre' => 'Modifier produit', 'produit' => $produit, 'categories' => $categories]);
    }

    public function mettreAJourProduit($id)
    {
        $model = new ProduitModel();
        $slug = url_title($this->request->getPost('nom'), '-', true);
        $data = [
            'categorie_id' => $this->request->getPost('categorie_id'),
            'genre'        => $this->request->getPost('genre'),
            'nom'          => $this->request->getPost('nom'),
            'slug'         => $slug,
            'description'  => $this->request->getPost('description'),
            'prix'         => $this->request->getPost('prix'),
            'stock'        => $this->request->getPost('stock'),
            'style'        => $this->request->getPost('style'),
            'tissu'        => $this->request->getPost('tissu'),
            'promo'        => $this->request->getPost('promo') ?? 0
        ];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/images', $newName);
            $data['image'] = $newName;
        }
        if ($model->update($id, $data)) {
            return redirect()->to('/admin/produits')->with('succes', 'Produit modifié');
        } else {
            return redirect()->back()->with('erreur', 'Erreur');
        }
    }

    public function supprimerProduit($id)
    {
        (new ProduitModel())->delete($id);
        return redirect()->to('/admin/produits')->with('succes', 'Produit supprimé');
    }

    // Gestion des commandes
    public function commandes()
    {
        $commandes = (new CommandeModel())->toutesAvecUser();
        return view('admin/commandes/index', ['titre' => 'Commandes', 'commandes' => $commandes]);
    }

    public function detailCommande($id)
    {
        $commande = (new CommandeModel())->detail($id);
        return view('admin/commandes/detail', ['titre' => 'Commande #'.$id, 'commande' => $commande]);
    }

    // Gestion utilisateurs
    public function utilisateurs()
    {
        $users = (new UtilisateurModel())->findAll();
        return view('admin/utilisateurs/index', ['titre' => 'Utilisateurs', 'utilisateurs' => $users]);
    }
}