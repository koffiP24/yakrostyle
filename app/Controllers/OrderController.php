<?php

namespace App\Controllers;

use App\Models\CommandeModel;
use App\Models\ProduitModel;

class OrderController extends BaseController
{
    /**
     * Affiche le formulaire de saisie de l'adresse de livraison.
     * Vérifie que le panier n'est pas vide.
     */
    public function formulaire()
    {
        $panier = session()->get('panier');
        if (empty($panier)) {
            return redirect()->to('/produits')->with('erreur', 'Votre panier est vide.');
        }

        $userId = session()->get('user_id');
        $commandeModel = new CommandeModel();
        $quantiteAchetee = $commandeModel->quantiteAcheteeParUtilisateur($userId);
        $reduction = $commandeModel->tauxReduction($userId);

        $total = array_sum(array_map(fn($i) => $i['prix'] * $i['quantite'], $panier));
        $montantRemise = round($total * $reduction / 100, 2);
        $totalApresRemise = max(0, $total - $montantRemise);

        return view('cart/commande', [
            'titre'           => 'Validation de la commande',
            'panier'          => $panier,
            'total'           => $total,
            'quantiteAchetee' => $quantiteAchetee,
            'reduction'       => $reduction,
            'montantRemise'   => $montantRemise,
            'totalApresRemise' => $totalApresRemise,
        ]);
    }

    /**
     * Traite la confirmation de commande.
     * - Vérifie l'utilisateur connecté
     * - Crée la commande et ses lignes dans une transaction
     * - Diminue le stock
     * - Vide le panier
     */
    public function confirmer()
    {
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to('/connexion')->with('erreur', 'Veuillez vous connecter pour passer commande.');
        }

        $adresse = trim($this->request->getPost('adresse'));
        if (empty($adresse)) {
            return redirect()->back()->with('erreur', 'L\'adresse de livraison est obligatoire.');
        }

        $panier = session()->get('panier');
        if (empty($panier)) {
            return redirect()->to('/produits')->with('erreur', 'Votre panier est vide.');
        }

        $commandeModel = new CommandeModel();
        $reduction = $commandeModel->tauxReduction($userId);
        $commandeId = $commandeModel->creerDepuisPanier($userId, $adresse, $panier);

        if (!$commandeId) {
            return redirect()->to('/commande')->with('erreur', 'Une erreur est survenue. Veuillez réessayer.');
        }

        if ($reduction > 0) {
            session()->setFlashdata('succes', "Votre commande bénéficie d'une réduction de {$reduction}%.");
        }

        // Diminution des stocks
        $produitModel = new ProduitModel();
        foreach ($panier as $item) {
            $produitModel->diminuerStock($item['id'], $item['quantite']);
        }

        // Vidage du panier
        session()->remove('panier');

        return redirect()->to("/commande/succes/{$commandeId}");
    }

    /**
     * Page de confirmation après commande réussie.
     */
    public function succes(int $id)
    {
        $commande = (new CommandeModel())->detail($id);
        if (!$commande || $commande['user_id'] != session()->get('user_id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('cart/succes', [
            'titre'    => 'Commande confirmée',
            'commande' => $commande
        ]);
    }
}
