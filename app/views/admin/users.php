<h2>Contas Registradas</h2>
<table>
    <thead>
        <tr>
            <th>Login</th>
            <th>Email</th>
            <th>Access Level</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach (\App\Models\User::all() as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['login']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= $user['accessLevel'] ?></td>
            <td><a href="/admin/characters?login=<?= $user['login'] ?>">Personagens</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
