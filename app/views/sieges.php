<h2>Castelos & Sieges</h2>
<table>
    <thead>
        <tr>
            <th>Castelo</th>
            <th>Donos</th>
            <th>Próxima Siege</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($castelos as $castelo): ?>
            <tr>
                <td><?= $castelo['name'] ?></td>
                <td><?= $castelo['clan_name'] ?? 'Sem dono' ?></td>
                <td><?= $castelo['siege_date'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
