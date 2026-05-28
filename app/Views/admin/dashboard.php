<?= view('layouts/header') ?>
<h1>Tableau de bord Admin</h1>
<div class="stats">
    <div class="stat-card">📦 Produits : <?= $nbProduits ?></div>
    <div class="stat-card">📦 Commandes : <?= $nbCommandes ?></div>
    <div class="stat-card">👥 Utilisateurs : <?= $nbUtilisateurs ?></div>
</div>
<?= view('layouts/footer') ?>