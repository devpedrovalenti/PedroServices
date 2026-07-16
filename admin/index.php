<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../classes/auth.php";
require_once __DIR__ . "/../includes/database.php";

$auth = new Auth();
$auth->requireLogin();

$clienteModel = new Cliente();
$projetoModel = new Projeto();
$contatoModel = new Contato();

$clientes = $clienteModel->all();
$projetos = $projetoModel->all();
$contatos = $contatoModel->all();

include __DIR__ . "/../includes/header.php";
?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <span class="tag">Admin</span>
            <h2>Painel administrativo</h2>
        </div>

        <div class="service-grid">
            <article class="card">
                <h3>Clientes</h3>
                <p><?= count($clientes) ?> cadastrados</p>
            </article>
            <article class="card">
                <h3>Projetos</h3>
                <p><?= count($projetos) ?> registros</p>
            </article>
            <article class="card">
                <h3>Mensagens</h3>
                <p><?= count($contatos) ?> contatos recebidos</p>
            </article>
        </div>

        <div class="contact-form" style="margin-top:30px;">
            <a href="logout.php" class="btn-primary">Sair do painel</a>
        </div>
    </div>
</section>

<?php include __DIR__ . "/../includes/footer.php"; ?>
