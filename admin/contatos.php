<?php
require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/database.php";
require_once __DIR__ . "/../classes/auth.php";
require_once __DIR__ . "/../classes/contato.php";

$auth = new Auth();
$auth->requireLogin();

$contatoModel = new Contato();

// Ações (sempre via POST + CSRF)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (csrfValido($_POST["csrf"] ?? null)) {
        $id = (int)($_POST["id"] ?? 0);
        if ($id > 0) {
            if (($_POST["acao"] ?? "") === "lido") {
                $contatoModel->marcarComoLido($id);
            } elseif (($_POST["acao"] ?? "") === "excluir") {
                $contatoModel->delete($id);
            }
        }
    }
    header("Location: " . url("admin/contatos.php"));
    exit;
}

$contatos = array_reverse($contatoModel->all()); // mais recentes primeiro

$pageTitle  = "Mensagens — " . APP_NAME;
$pageRobots = "noindex,nofollow";

include __DIR__ . "/../includes/header.php";
?>

<main id="conteudo">
<section class="section" style="padding-top:140px;">
    <div class="container">
        <div class="section-title">
            <span class="tag">Mensagens</span>
            <h2>Contatos recebidos</h2>
            <p><a class="project-link" href="<?= e(url("admin/index.php")) ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Voltar ao painel</a></p>
        </div>

        <?php if (empty($contatos)): ?>
            <p>Nenhuma mensagem recebida ainda.</p>
        <?php else: ?>
            <?php foreach ($contatos as $c): ?>
                <article class="card" style="margin-bottom:15px;<?= empty($c["lido"]) ? "border-color:rgba(167,139,250,.5);" : "" ?>">
                    <h3>
                        <?= e($c["nome"]) ?>
                        <?php if (empty($c["lido"])): ?><span class="project-category" style="margin-left:8px;">Nova</span><?php endif; ?>
                    </h3>
                    <p>
                        <strong>E-mail:</strong> <a href="mailto:<?= e($c["email"]) ?>"><?= e($c["email"]) ?></a>
                        <?php if (!empty($c["telefone"])): ?> · <strong>Tel:</strong> <?= e($c["telefone"]) ?><?php endif; ?>
                        <?php if (!empty($c["created_at"])): ?> · <?= e(date("d/m/Y H:i", strtotime($c["created_at"]))) ?><?php endif; ?>
                    </p>
                    <?php if (!empty($c["assunto"])): ?><p><strong>Assunto:</strong> <?= e($c["assunto"]) ?></p><?php endif; ?>
                    <p style="margin-top:10px;white-space:pre-wrap;"><?= e($c["mensagem"]) ?></p>

                    <form method="post" style="display:flex;gap:10px;margin-top:16px;">
                        <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                        <input type="hidden" name="id" value="<?= (int)$c["id"] ?>">
                        <?php if (empty($c["lido"])): ?>
                            <button class="filter" type="submit" name="acao" value="lido">Marcar como lida</button>
                        <?php endif; ?>
                        <button class="filter" type="submit" name="acao" value="excluir" onclick="return confirm('Excluir esta mensagem?');">Excluir</button>
                    </form>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
</main>

<?php include __DIR__ . "/../includes/footer.php"; ?>
