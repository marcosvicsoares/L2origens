<h2>Loja de Itens</h2>
<div class="shop-items">
    <?php foreach ($items as $item): ?>
        <div class="shop-card">
            <img src="/assets/images/items/<?= $item['item_id'] ?>.png" alt="item">
            <p><?= $item['name'] ?></p>
            <p><?= $item['price'] ?> Moedas</p>
            <form method="POST" action="/loja/comprar">
                <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
                <button type="submit">Comprar</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
