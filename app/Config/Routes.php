<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'ProductController::index');
$routes->get('/produits', 'ProductController::index');
$routes->get('/produits/categorie/(:any)', 'ProductController::parCategorie/$1');
$routes->get('/produits/genre/(:any)', 'ProductController::parGenre/$1');
$routes->get('/produit/(:any)', 'ProductController::detail/$1');

$routes->get('/panier', 'CartController::index');
$routes->post('/panier/ajouter', 'CartController::ajouter');
$routes->post('/panier/modifier', 'CartController::modifier');
$routes->get('/panier/supprimer/(:num)', 'CartController::supprimer/$1');
$routes->get('/panier/vider', 'CartController::vider');

$routes->get('/commande', 'OrderController::formulaire', ['filter' => 'auth']);
$routes->post('/commande/confirmer', 'OrderController::confirmer', ['filter' => 'auth']);
$routes->get('/commande/succes/(:num)', 'OrderController::succes/$1');

$routes->get('/connexion', 'AuthController::connexion');
$routes->post('/connexion', 'AuthController::login');
$routes->get('/inscription', 'AuthController::inscription');
$routes->post('/inscription', 'AuthController::register');
$routes->get('/deconnexion', 'AuthController::deconnexion');

// ADMIN (protégé par filtre)
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'AdminController::dashboard');
    $routes->get('produits', 'AdminController::produits');
    $routes->get('produits/ajouter', 'AdminController::ajouterProduit');
    $routes->post('produits/ajouter', 'AdminController::creerProduit');
    $routes->get('produits/modifier/(:num)', 'AdminController::modifierProduit/$1');
    $routes->post('produits/modifier/(:num)', 'AdminController::mettreAJourProduit/$1');
    $routes->get('produits/supprimer/(:num)', 'AdminController::supprimerProduit/$1');
    $routes->get('commandes', 'AdminController::commandes');
    $routes->get('commande/(:num)', 'AdminController::detailCommande/$1');
    $routes->get('utilisateurs', 'AdminController::utilisateurs');
});
