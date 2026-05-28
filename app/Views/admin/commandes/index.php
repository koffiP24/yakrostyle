<?= view('layouts/header', ['titre' => 'Gestion des commandes']) ?>
<?php $commandes = $commandes ?? []; ?>
<h1>📦 Commandes</h1>
<table class="table-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($commandes as $cmd): ?>
            <tr>
                <td><?= $cmd['id'] ?></td>
                <td><?= esc($cmd['client_nom']) ?></td>
                <td><?= number_format($cmd['total'], 0, ',', ' ') ?> FCFA</td>
                <td><?= esc($cmd['statut']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($cmd['created_at'])) ?></td>
                <td><a href="/admin/commande/<?= $cmd['id'] ?>" class="btn-primary btn-sm">Voir détail</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= view('layouts/footer') ?>