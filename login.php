<?php
require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/includes/database.php";
require_once __DIR__ . "/classes/auth.php";

$auth = new Auth();

if ($auth->check()) {
    header("Location: " . url("admin/index.php"));
    exit;
}

$message = "";
$maxTentativas = 5;
$janela = 300; // 5 minutos

$_SESSION["login_falhas"] = array_filter(
    $_SESSION["login_falhas"] ?? [],
    fn($t) => $t > time() - $janela
);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!csrfValido($_POST["csrf"] ?? null)) {
        $message = "Sessão expirada. Recarregue a página e tente novamente.";
    } elseif (count($_SESSION["login_falhas"]) >= $maxTentativas) {
        $message = "Muitas tentativas. Aguarde alguns minutos antes de tentar de novo.";
    } else {
        try {
            if ($auth->login(trim($_POST["email"] ?? ""), $_POST["senha"] ?? "")) {
                unset($_SESSION["login_falhas"]);
                header("Location: " . url("admin/index.php"));
                exit;
            }
            $_SESSION["login_falhas"][] = time();
            $message = "E-mail ou senha inválidos.";
        } catch (Throwable $ex) {
            error_log("[login] " . $ex->getMessage());
            $message = "Não foi possível acessar o painel agora.";
        }
    }
}

$pageTitle  = "Painel administrativo — " . APP_NAME;
$pageRobots = "noindex,nofollow";

include __DIR__ . "/includes/header.php";
?>

<main id="conteudo">
<section class="section" style="padding-top:140px;">
    <div class="container contact-grid">
        <div>
            <span class="tag">Painel</span>
            <h2>Acesse o painel administrativo</h2>
            <p>Área restrita para gerenciar as mensagens recebidas pelo site.</p>
        </div>
        <form class="contact-form" method="post" action="<?= e(url("login.php")) ?>">
            <?php if ($message !== ""): ?>
                <div class="error-message" role="alert"><?= e($message) ?></div>
            <?php endif; ?>
            <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
            <label class="field">
                <span>E-mail</span>
                <input type="email" name="email" autocomplete="username" required>
            </label>
            <label class="field">
                <span>Senha</span>
                <input type="password" name="senha" autocomplete="current-password" required>
            </label>
            <button type="submit" class="btn-primary">Entrar</button>
        </form>
    </div>
</section>
</main>

<?php include __DIR__ . "/includes/footer.php"; ?>
