<?php

require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/includes/database.php";

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_submit"])) {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $assunto = trim($_POST["assunto"] ?? "");
    $mensagem = trim($_POST["mensagem"] ?? "");

    if ($nome === "" || $email === "" || $mensagem === "") {
        $errorMessage = "Preencha nome, e-mail e mensagem para enviar sua proposta.";
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO contatos (nome, email, telefone, assunto, mensagem, lido) VALUES (:nome, :email, :telefone, :assunto, :mensagem, 0)");
            $stmt->execute([
                ":nome" => $nome,
                ":email" => $email,
                ":telefone" => $telefone,
                ":assunto" => $assunto,
                ":mensagem" => $mensagem
            ]);
            $successMessage = "Mensagem enviada com sucesso! Responderemos em breve.";
        } catch (PDOException $e) {
            $errorMessage = "Não foi possível enviar a mensagem no momento.";
        }
    }
}

include __DIR__ . "/includes/header.php";
?>

<main>
    <section class="hero" id="inicio">
        <div class="container hero-content">
            <div class="hero-left">
                <span class="tag">🚀 Desenvolvedor Full Stack</span>
                <h1>Transformo ideias em <span>Sites</span>, <span>Sistemas</span> e <span>Automações</span></h1>
                <p>Desenvolvo soluções modernas para empresas, empreendedores e criadores que desejam crescer através da tecnologia.</p>

                <div class="hero-buttons">
                    <a href="#contato" class="btn-primary">Solicitar orçamento</a>
                    <a href="#projetos" class="btn-secondary">Ver projetos</a>
                </div>

                <div class="hero-stats">
                    <div>
                        <h2>100+</h2>
                        <span>Projetos</span>
                    </div>
                    <div>
                        <h2>5★</h2>
                        <span>Avaliação</span>
                    </div>
                    <div>
                        <h2>24/7</h2>
                        <span>Suporte</span>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <div class="terminal">
                    <div class="terminal-header">
                        <span class="dot red"></span>
                        <span class="dot yellow"></span>
                        <span class="dot green"></span>
                    </div>
                    <div class="terminal-body">
                        <pre id="typing"></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="servicos">
        <div class="container">
            <div class="section-title">
                <span class="tag">Serviços</span>
                <h2>O que eu posso construir para você</h2>
            </div>
            <div class="service-grid">
                <article class="card">
                    <h3>Landing Pages</h3>
                    <p>Estruturas rápidas, persuasivas e otimizadas para converter visitantes em clientes.</p>
                </article>
                <article class="card">
                    <h3>Sistemas Web</h3>
                    <p>Dashboards, cadastros e automações com segurança e performance para o seu negócio.</p>
                </article>
                <article class="card">
                    <h3>Integrações</h3>
                    <p>Conexão com WhatsApp, APIs, bancos de dados e ferramentas que você já usa.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" id="projetos">
        <div class="container">
            <div class="section-title">
                <span class="tag">Projetos</span>
                <h2>Exemplos de entregas modernas</h2>
            </div>
            <div class="service-grid">
                <article class="card">
                    <h3>Portal de clientes</h3>
                    <p>Sistemas completos para gestão de leads, projetos e comunicação com o cliente.</p>
                </article>
                <article class="card">
                    <h3>Automação comercial</h3>
                    <p>Fluxos inteligentes para acelerar atendimento, vendas e organização interna.</p>
                </article>
                <article class="card">
                    <h3>Aplicações personalizadas</h3>
                    <p>Solucões pensadas para o seu processo, sem depender de ferramentas genéricas.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" id="contato">
        <div class="container contact-grid">
            <div>
                <span class="tag">Contato</span>
                <h2>Pronto para transformar sua ideia em realidade?</h2>
                <p>Preencha o formulário e eu retorno com uma proposta alinhada ao seu objetivo.</p>
            </div>
            <form class="contact-form" method="post">
                <?php if ($successMessage !== ""): ?>
                    <div class="success-message"><?= htmlspecialchars($successMessage) ?></div>
                <?php endif; ?>
                <?php if ($errorMessage !== ""): ?>
                    <div class="error-message"><?= htmlspecialchars($errorMessage) ?></div>
                <?php endif; ?>
                <input type="text" name="nome" placeholder="Seu nome" required>
                <input type="email" name="email" placeholder="Seu e-mail" required>
                <input type="text" name="telefone" placeholder="Telefone">
                <input type="text" name="assunto" placeholder="Assunto">
                <textarea name="mensagem" rows="5" placeholder="Descreva o que você precisa" required></textarea>
                <button type="submit" name="contact_submit" class="btn-primary">Enviar mensagem</button>
            </form>
        </div>
    </section>
</main>

<?php include __DIR__ . "/includes/footer.php"; ?>