<h2>Battle Pass - <?= date('F Y') ?></h2>
<div class="tiers">
    <?php foreach ($tiers as $tier): ?>
        <div class="tier-card">
            <h3>Nível <?= $tier['id'] ?></h3>
            <p><?= htmlspecialchars($tier['description']) ?></p>
            <div>Item: <?= $tier['item_id'] ?> x<?= $tier['amount'] ?></div>
            <div>Progresso: <?= $progress[$tier['id']] ?? 0 ?>%</div>

            <?php if (in_array($tier['id'], $claimed)): ?>
                <button disabled>Resgatado</button>
            <?php elseif (($progress[$tier['id']] ?? 0) >= 100): ?>
                <form method="POST" action="/battlepass/claim" class="claim-form">
                    <input type="hidden" name="tier_id" value="<?= $tier['id'] ?>">
                    <input type="hidden" name="char_id" value="<?= $char['obj_Id'] ?>">
                    <button type="submit">Resgatar</button>
                </form>
            <?php else: ?>
                <button disabled>Incompleto</button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
