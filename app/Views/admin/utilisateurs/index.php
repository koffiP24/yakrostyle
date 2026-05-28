<?= view('layouts/header', ['titre' => 'Gestion des utilisateurs']) ?>
<h1>👥 Utilisateurs</h1>
<table class="table-admin">
    <thead>
        <tr><th>ID</th><th>Nom</th><th>Email</th><th>Rôle</th><th>Date d'inscription</th></tr>
    </thead>
    <tbody>
    <?php foreach ($utilisateurs as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= esc($user['nom']) ?></td>
            <td><?= esc($user['email']) ?></td>
            <td><?= esc($user['role']) ?></td>
            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?= view('layouts/footer') ?>