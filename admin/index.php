<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/database.php";
require_once __DIR__ . "/../classes/auth.php";
require_once __DIR__ . "/../classes/cliente.php";
require_once __DIR__ . "/../classes/projeto.php";
require_once __DIR__ . "/../classes/contato.php";

$auth = new Auth();
$auth->requireLogin();

$totais = ["clientes" => 0, "projetos" => 0, "contatos" => 0, "novos" => 0];
$erroBanco = false;

try {
    $totais["clientes"] = (new Cliente())->count();
    $totais["projetos"] = (new Projeto())->count();
    $contatoModel       = new Contato();
    $totais["contatos"] = $contatoModel->count();
    $totais["novos"]    = $contatoModel->countNaoLidos();
} catch (Throwable $ex) {
    error_log("[admin] " . $ex->getMessage());
    $erroBanco = true;
}

$pageTitle  = "Painel — " . APP_NAME;
$pageRobots = "noindex,nofollow";

include __DIR__ . "/../includes/header.php";
?>

<main id="conteudo">
<section class="section" style="padding-top:140px;">
    <div class="container">
        <div class="section-title">
            <span class="tag">Admin</span>
            <h2>Olá, <?= e($auth->nome()) ?></h2>
            <p>Resumo do que chegou pelo site.</p>
        </div>

        <?php if ($erroBanco): ?>
            <div class="error-message" role="alert">Não foi possível carregar os dados do banco.</div>
        <?php endif; ?>

        <div class="service-grid">
            <article class="card">
                <h3>Mensagens</h3>
                <p><?= (int)$totais["contatos"] ?> recebidas<?= $totais["novos"] > 0 ? " · <strong>" . (int)$totais["novos"] . " nova(s)</strong>" : "" ?></p>
                <a class="project-link" href="<?= e(url("admin/contatos.php")) ?>">Abrir mensagens <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </article>
            <article class="card">
                <h3>Clientes</h3>
                <p><?= (int)$totais["clientes"] ?> cadastrados</p>
            </article>
            <article class="card">
                <h3>Projetos</h3>
                <p><?= (int)$totais["projetos"] ?> registros</p>
            </article>
        </div>

        <div style="margin-top:30px;">
            <a href="<?= e(url("admin/logout.php")) ?>" class="btn-primary">Sair do painel</a>
        </div>
    </div>
</section>
</main>

<?php include __DIR__ . "/../includes/footer.php"; ?>
