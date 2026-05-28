<?php

namespace App\Controllers;

use App\Models\ProduitModel;
use App\Models\CategorieModel;
use App\Models\CommandeModel;
use App\Models\UtilisateurModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $produitModel = new ProduitModel();
        $commandeModel = new CommandeModel();
        $utilisateurModel = new UtilisateurModel();

        $data = [
            'titre' => 'Tableau de bord',
            'nbProduits' => $produitModel->countAll(),
            'nbCommandes' => $commandeModel->countAll(),
            'nbUtilisateurs' => $utilisateurModel->countAll(),
            'nbStockFaible' => (new ProduitModel())->where('stock <', 5)->where('actif', 1)->countAllResults(),
            'nbRuptureStock' => (new ProduitModel())->where('stock', 0)->where('actif', 1)->countAllResults(),
            'produitsRecents' => $produitModel->orderBy('created_at', 'DESC')->findAll(5),
            'commandesRecentes' => $commandeModel->orderBy('created_at', 'DESC')->findAll(5),
            'utilisateursRecents' => $utilisateurModel->orderBy('created_at', 'DESC')->findAll(5),
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
        try {
            $imageName = $this->enregistrerImageProduit($this->request->getFile('image'));
            if ($imageName !== null) {
                $data['image'] = $imageName;
            }
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('erreur', $e->getMessage());
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
        try {
            $imageName = $this->enregistrerImageProduit($this->request->getFile('image'));
            if ($imageName !== null) {
                $data['image'] = $imageName;
            }
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('erreur', $e->getMessage());
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
        return view('admin/commandes/detail', ['titre' => 'Commande #' . $id, 'commande' => $commande]);
    }

    // Gestion utilisateurs
    public function utilisateurs()
    {
        $users = (new UtilisateurModel())->findAll();
        return view('admin/utilisateurs/index', ['titre' => 'Utilisateurs', 'utilisateurs' => $users]);
    }

    private function enregistrerImageProduit(?UploadedFile $file): ?string
    {
        if (!$file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!$file->isValid() || $file->hasMoved()) {
            throw new \RuntimeException('Image invalide ou impossible à traiter.');
        }

        if (!str_starts_with((string) $file->getMimeType(), 'image/')) {
            throw new \RuntimeException('Le fichier envoyé doit être une image.');
        }

        $uploadPath = ROOTPATH . 'public/images';
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0755, true)) {
            throw new \RuntimeException('Impossible de créer le dossier des images.');
        }

        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $targetPath = $uploadPath . DIRECTORY_SEPARATOR . $newName;

        try {
            service('image')
                ->withFile($targetPath)
                ->fit(600, 800, 'center')
                ->save($targetPath, 85);
        } catch (\Throwable $e) {
            // Si le redimensionnement échoue, on conserve l'image originale
            // pour ne pas bloquer l'ajout du produit.
            return $newName;
        }

        return $newName;
    }
}
