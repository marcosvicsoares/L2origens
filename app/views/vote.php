<h2>Votação</h2>

<ul>
    <?php foreach ($status as $site => $canVote): ?>
        <li>
            <?= $site ?>:
            <?php if ($canVote): ?>
                <a href="/vote/votar?site=<?= urlencode($site) ?>" target="_blank">Votar agora</a>
            <?php else: ?>
                Aguarde <?= $cooldowns[$site] ?> para votar novamente.
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
