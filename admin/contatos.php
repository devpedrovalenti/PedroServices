<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../classes/auth.php";
require_once __DIR__ . "/../classes/contato.php";

$auth = new Auth();
$auth->requireLogin();

$contatoModel = new Contato();
$contatos = $contatoModel->all();

include __DIR__ . "/../includes/header.php";
?>

<section class="section">
    <div class="container">
        <div class="section-title">
            <span class="tag">Mensagens</span>
            <h2>Contatos recebidos</h2>
        </div>
        <?php if (empty($contatos)): ?>
            <p>Nenhuma mensagem recebida ainda.</p>
        <?php else: ?>
            <?php foreach ($contatos as $contato): ?>
                <article class="card" style="margin-bottom:15px;">
                    <h3><?= htmlspecialchars($contato["nome"] ?? "") ?></h3>
                    <p><strong>E-mail:</strong> <?= htmlspecialchars($contato["email"] ?? "") ?></p>
                    <p><strong>Assunto:</strong> <?= htmlspecialchars($contato["assunto"] ?? "") ?></p>
                    <p><?= htmlspecialchars($contato["mensagem"] ?? "") ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . "/../includes/footer.php"; ?>
