<h2>Painel Administrativo</h2>
<div class="admin-stats">
    <div class="card">
        <h3>Total de Contas</h3>
        <p><?= \App\Models\User::count(); ?></p>
    </div>
    <div class="card">
        <h3>Jogadores Online</h3>
        <p><?= \App\Models\Server::onlinePlayers(); ?></p>
    </div>
    <div class="card">
        <h3>Prêmios Enviados</h3>
        <p><?= \App\Models\Logs::countType('reward'); ?></p>
    </div>
</div>
<h3>Resumo</h3>
<ul>
    <li>Total de votos registrados: <?= $votos ?></li>
    <li>Total de doações registradas: <?= $doacoes ?></li>
</ul>

