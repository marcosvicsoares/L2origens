<h2>Battle Pass - Temporada Atual</h2>

<div class="battlepass-tiers">
    <?php foreach ($tiers as $tier): ?>
        <div class="tier-card <?= $tier['completed'] ? 'completed' : '' ?>">
            <h3>Nível <?= $tier['level'] ?></h3>
            <?php if ($tier['completed']): ?>
                <div class="reward unlocked">
                    <img src="/assets/images/items/<?= $tier['item_id'] ?>.png" alt="Item <?= $tier['item_id'] ?>">
                    <p><?= $tier['amount'] ?>x <?= $tier['item_name'] ?></p>
                    <small>Concluído</small>
                </div>
            <?php else: ?>
                <div class="reward locked">
                    <div class="lock-icon">🔒</div>
                    <p>Recompensa Oculta</p>
                    <small>Complete este tier</small>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<style>
    .battlepass-tiers {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
    }
    .tier-card {
        background: #1c1c1c;
        color: #fff;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
        border: 2px solid #333;
    }
    .tier-card.completed {
        border-color: #4caf50;
    }
    .reward img {
        width: 48px;
        height: 48px;
        margin-bottom: 8px;
    }
    .reward.locked {
        opacity: 0.4;
    }
    .lock-icon {
        font-size: 30px;
        margin-bottom: 10px;
    }
</style>
