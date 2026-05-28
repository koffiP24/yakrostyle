<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController extends BaseController
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function connexion()
    {
        return view('auth/connexion', ['titre' => 'Connexion']);
    }

    /**
     * Traite la tentative de connexion.
     */
    public function login()
    {
        $email = $this->request->getPost('email');
        $mdp   = $this->request->getPost('mot_de_passe');

        $user = (new UtilisateurModel())->verifier($email, $mdp);

        if (!$user) {
            return redirect()->to('/connexion')->with('erreur', 'Email ou mot de passe incorrect.');
        }

        // Stockage en session
        session()->set([
            'user_id'   => $user['id'],
            'user_nom'  => $user['nom'],
            'user_role' => $user['role']
        ]);

        // Redirection éventuelle après connexion (ex: panier)
        $redirect = session()->get('redirect_url') ?? '/produits';
        session()->remove('redirect_url');

        return redirect()->to($redirect)->with('succes', "Bienvenue, {$user['nom']} !");
    }

    /**
     * Affiche le formulaire d'inscription.
     */
    public function inscription()
    {
        return view('auth/inscription', ['titre' => 'Créer un compte']);
    }

    /**
     * Traite l'inscription d'un nouvel utilisateur.
     */
    public function register()
    {
        $model = new UtilisateurModel();

        $id = $model->creer(
            $this->request->getPost('nom'),
            $this->request->getPost('email'),
            $this->request->getPost('mot_de_passe')
        );

        if (!$id) {
            return redirect()->to('/inscription')
                ->withInput()
                ->with('erreur', implode(' ', $model->errors()));
        }

        return redirect()->to('/connexion')->with('succes', 'Compte créé avec succès. Connectez-vous.');
    }

    /**
     * Déconnexion : détruit la session.
     */
    public function deconnexion()
    {
        session()->destroy();
        return redirect()->to('/')->with('succes', 'Vous êtes déconnecté.');
    }
}
