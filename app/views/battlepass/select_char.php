<h2>Selecione seu personagem</h2>
<form method="GET" action="/battlepass">
    <select name="char" required>
        <?php foreach ($characters as $char): ?>
            <option value="<?= htmlspecialchars($char['char_name']) ?>"><?= htmlspecialchars($char['char_name']) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Acessar Battle Pass</button>
</form>
