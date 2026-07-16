<?php
require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/classes/auth.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $auth = new Auth();
    if ($auth->login($_POST["email"] ?? "", $_POST["senha"] ?? "")) {
        header("Location: admin/index.php");
        exit;
    }
    $message = "E-mail ou senha inválidos.";
}

include __DIR__ . "/includes/header.php";
?>

<section class="section">
    <div class="container contact-grid">
        <div>
            <span class="tag">Painel</span>
            <h2>Acesse o painel administrativo</h2>
            <p>Use o usuário padrão criado no banco: admin@localhost com a senha admin123.</p>
        </div>
        <form class="contact-form" method="post">
            <?php if ($message !== ""): ?>
                <div class="error-message"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn-primary">Entrar</button>
        </form>
    </div>
</section>

<?php include __DIR__ . "/includes/footer.php"; ?>
