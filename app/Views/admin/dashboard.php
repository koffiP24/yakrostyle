<?= view('layouts/header', ['titre' => $titre ?? 'Tableau de bord Admin']) ?>

<section class="admin-dashboard">
    <div class="dashboard-top">
        <div>
            <h1>Tableau de bord Admin</h1>
            <p class="dashboard-subtitle">Vue d'ensemble en temps réel des produits, commandes et utilisateurs.</p>
        </div>
        <div class="dashboard-search">
            <label for="admin-search">Recherche rapide</label>
            <input id="admin-search" type="search" placeholder="Rechercher produits, commandes ou utilisateurs..." data-search-target="admin-dashboard">
        </div>
    </div>

    <div class="stats">
        <a href="/admin/produits" class="stat-card stat-card-link">
            <div class="stat-icon">📦</div>
            <div>
                <div class="stat-label">Produits</div>
                <div class="stat-value"><?= esc($nbProduits) ?></div>
            </div>
        </a>
        <a href="/admin/commandes" class="stat-card stat-card-link">
            <div class="stat-icon">📝</div>
            <div>
                <div class="stat-label">Commandes</div>
                <div class="stat-value"><?= esc($nbCommandes) ?></div>
            </div>
        </a>
        <a href="/admin/utilisateurs" class="stat-card stat-card-link">
            <div class="stat-icon">👥</div>
            <div>
                <div class="stat-label">Utilisateurs</div>
                <div class="stat-value"><?= esc($nbUtilisateurs) ?></div>
            </div>
        </a>
        <a href="/admin/produits" class="stat-card stat-card-warning">
            <div class="stat-icon">⚠️</div>
            <div>
                <div class="stat-label">Stock faible</div>
                <div class="stat-value"><?= esc($nbStockFaible) ?></div>
            </div>
        </a>
        <a href="/admin/produits" class="stat-card stat-card-danger">
            <div class="stat-icon">🚫</div>
            <div>
                <div class="stat-label">Rupture de stock</div>
                <div class="stat-value"><?= esc($nbRuptureStock) ?></div>
            </div>
        </a>
    </div>

    <div class="dashboard-grid" data-search-list="admin-dashboard">
        <div class="dashboard-panel">
            <div class="panel-header">
                <h2>Produits récents</h2>
                <a href="/admin/produits">Voir tous</a>
            </div>
            <div class="panel-list">
                <?php if (empty($produitsRecents)): ?>
                    <p class="empty-state">Aucun produit disponible.</p>
                <?php else: ?>
                    <?php foreach ($produitsRecents as $produit): ?>
                        <div class="list-item" data-search-content>
                            <strong><?= esc($produit['nom']) ?></strong>
                            <span><?= esc($produit['genre']) ?> • <?= number_format($produit['prix'], 0, ',', ' ') ?> FCFA</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="empty-result empty-state" style="display:none;">Aucun résultat.</p>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <h2>Commandes récentes</h2>
                <a href="/admin/commandes">Voir toutes</a>
            </div>
            <div class="panel-list">
                <?php if (empty($commandesRecentes)): ?>
                    <p class="empty-state">Aucune commande à afficher.</p>
                <?php else: ?>
                    <?php foreach ($commandesRecentes as $commande): ?>
                        <div class="list-item" data-search-content>
                            <strong>Commande #<?= esc($commande['id']) ?></strong>
                            <span>User <?= esc($commande['user_id']) ?> • <?= number_format($commande['total'], 0, ',', ' ') ?> FCFA</span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="empty-result empty-state" style="display:none;">Aucun résultat.</p>
            </div>
        </div>

        <div class="dashboard-panel">
            <div class="panel-header">
                <h2>Derniers utilisateurs</h2>
                <a href="/admin/utilisateurs">Voir tous</a>
            </div>
            <div class="panel-list">
                <?php if (empty($utilisateursRecents)): ?>
                    <p class="empty-state">Aucun utilisateur pour le moment.</p>
                <?php else: ?>
                    <?php foreach ($utilisateursRecents as $user): ?>
                        <div class="list-item" data-search-content>
                            <strong><?= esc($user['nom']) ?></strong>
                            <span><?= esc($user['email']) ?> • <?= esc($user['role']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <p class="empty-result empty-state" style="display:none;">Aucun résultat.</p>
            </div>
        </div>
    </div>
</section>

<?= view('layouts/footer') ?>