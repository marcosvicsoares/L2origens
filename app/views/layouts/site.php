<nav style="padding: 1rem; background: #111; color: #fff;">
    <a href="/">Home</a> |
    <a href="/?page=ranking">Ranking</a> |
    <a href="/?page=loja">Loja</a> |
    <a href="/?page=bosses">Bosses</a> |
    <a href="/?page=sieges">Sieges</a> |
    <a href="/?page=heroes">Heróis</a> |
    <a href="/?page=vote">Votar</a> |
    <a href="/?page=donate">Donate</a> |
    <?php if (isset($_SESSION['user'])): ?>
        <a href="/?page=painel">Painel</a> |
        <a href="/?page=logout">Sair</a>
    <?php else: ?>
        <a href="/?page=login">Login</a>
    <?php endif; ?>
</nav>
