<h2>Heróis da Semana</h2>
<ul class="heroes-list">
    <?php foreach ($heroes as $hero): ?>
        <li>
            <?= $hero['char_name'] ?> - <?= $hero['class_name'] ?>
        </li>
    <?php endforeach; ?>
</ul>
