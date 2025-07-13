<?php
// Supondo $characters vindo do controller
?>

<h2>Roleta da Sorte</h2>

<form id="formRoleta" method="POST" action="/roleta/spin">
    <label for="charSelect">Escolha seu personagem:</label>
    <select id="charSelect" name="char_id" required>
        <?php foreach ($characters as $char): ?>
            <option value="<?= htmlspecialchars($char['obj_Id']) ?>"><?= htmlspecialchars($char['char_name']) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Girar Roleta</button>
</form>

<div id="resultado" style="margin-top:20px;"></div>

<audio id="somGirar" src="/sounds/roleta-spin.mp3" preload="auto"></audio>
<audio id="somPremio" src="/sounds/roleta-win.mp3" preload="auto"></audio>

<script>
document.getElementById('formRoleta').addEventListener('submit', function(e) {
    e.preventDefault();

    const charId = document.getElementById('charSelect').value;
    if (!charId) {
        alert('Selecione um personagem!');
        return;
    }

    const somGirar = document.getElementById('somGirar');
    const somPremio = document.getElementById('somPremio');
    const resultadoDiv = document.getElementById('resultado');

    somGirar.play();

    fetch('/roleta/spin', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `char_id=${encodeURIComponent(charId)}`
    })
    .then(response => response.json())
    .then(data => {
        somGirar.pause();
        somGirar.currentTime = 0;

        if (data.error) {
            resultadoDiv.innerHTML = '<span style="color:red;">Erro: ' + data.error + '</span>';
            return;
        }

        somPremio.play();

        resultadoDiv.innerHTML = '<strong>' + data.message + '</strong>';
        // Aqui pode adicionar animação visual da roleta apontando o prêmio
    })
    .catch(() => {
        resultadoDiv.innerHTML = '<span style="color:red;">Erro ao conectar com o servidor.</span>';
    });
});
</script>

