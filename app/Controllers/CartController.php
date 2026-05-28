<?php

namespace App\Controllers;

use App\Models\ProduitModel;

class CartController extends BaseController
{
    public function index()
    {
        return view('cart/index', [
            'titre'  => 'Mon panier',
            'panier' => $this->getPanier(),
            'total'  => $this->calcTotal()
        ]);
    }

    public function ajouter()
    {
        $id = (int)$this->request->getPost('produit_id');
        $qte = max(1, (int)$this->request->getPost('quantite'));
        $produit = (new ProduitModel())->find($id);
        if (!$produit || $produit['stock'] < $qte) {
            return redirect()->back()->with('erreur', 'Stock insuffisant');
        }
        $panier = $this->getPanier();
        if (isset($panier[$id])) {
            $panier[$id]['quantite'] += $qte;
        } else {
            $panier[$id] = [
                'id'       => $produit['id'],
                'nom'      => $produit['nom'],
                'prix'     => $produit['prix'],
                'image'    => $produit['image'],
                'quantite' => $qte
            ];
        }
        session()->set('panier', $panier);
        return redirect()->to('/panier')->with('succes', 'Article ajouté');
    }

    public function modifier()
    {
        $id = (int)$this->request->getPost('produit_id');
        $qte = (int)$this->request->getPost('quantite');
        $panier = $this->getPanier();
        if ($qte <= 0) unset($panier[$id]);
        elseif (isset($panier[$id])) $panier[$id]['quantite'] = $qte;
        session()->set('panier', $panier);
        return redirect()->to('/panier');
    }

    public function supprimer(int $id)
    {
        $panier = $this->getPanier();
        unset($panier[$id]);
        session()->set('panier', $panier);
        return redirect()->to('/panier')->with('succes', 'Article supprimé');
    }

    public function vider()
    {
        session()->remove('panier');
        return redirect()->to('/panier')->with('succes', 'Panier vidé');
    }

    private function getPanier(): array
    {
        return session()->get('panier') ?? [];
    }

    private function calcTotal(): float
    {
        return array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $this->getPanier()));
    }
}