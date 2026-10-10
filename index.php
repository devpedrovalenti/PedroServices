<?php

require_once __DIR__ . "/includes/config.php";
require_once __DIR__ . "/includes/database.php";
require_once __DIR__ . "/classes/portfolio.php";

// ===============================
// FORMULÁRIO DE CONTATO (padrão POST → redirect → GET)
// ===============================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["contact_submit"])) {
    $dados = [
        "nome"     => trim($_POST["nome"] ?? ""),
        "email"    => trim($_POST["email"] ?? ""),
        "telefone" => trim($_POST["telefone"] ?? ""),
        "assunto"  => trim($_POST["assunto"] ?? ""),
        "mensagem" => trim($_POST["mensagem"] ?? ""),
    ];

    $erro = null;

    if (!csrfValido($_POST["csrf"] ?? null)) {
        $erro = "Sua sessão expirou. Recarregue a página e tente de novo.";
    } elseif (trim($_POST["website"] ?? "") !== "") {
        // Honeypot preenchido: provavelmente um robô. Finge sucesso e não grava nada.
        flash("sucesso", "Mensagem enviada com sucesso! Eu respondo em breve.");
        header("Location: " . url("") . "#contato");
        exit;
    } elseif (time() - (int)($_POST["ts"] ?? 0) < 3) {
        $erro = "Calma! Confira os campos e envie novamente.";
    } elseif (time() - (int)($_SESSION["ultimo_envio"] ?? 0) < 60) {
        $erro = "Você acabou de enviar uma mensagem. Aguarde um minuto para enviar outra.";
    } elseif ($dados["nome"] === "" || $dados["email"] === "" || $dados["mensagem"] === "") {
        $erro = "Preencha nome, e-mail e mensagem para enviar sua proposta.";
    } elseif (tamanho($dados["nome"]) < 2 || tamanho($dados["nome"]) > 150) {
        $erro = "Informe um nome válido (até 150 caracteres).";
    } elseif (!filter_var($dados["email"], FILTER_VALIDATE_EMAIL) || tamanho($dados["email"]) > 150) {
        $erro = "Informe um e-mail válido.";
    } elseif (tamanho($dados["telefone"]) > 20 || tamanho($dados["assunto"]) > 255) {
        $erro = "Telefone ou assunto muito longo.";
    } elseif (tamanho($dados["mensagem"]) < 10 || tamanho($dados["mensagem"]) > 5000) {
        $erro = "Descreva o que você precisa com pelo menos 10 caracteres (máximo de 5000).";
    }

    if ($erro === null) {
        try {
            (new Contato())->create($dados);
            $_SESSION["ultimo_envio"] = time();
            unset($_SESSION["csrf"], $_SESSION["old"]);
            flash("sucesso", "Mensagem enviada com sucesso! Eu respondo em breve.");
        } catch (Throwable $ex) {
            error_log("[contato] " . $ex->getMessage());
            $erro = "Não foi possível enviar a mensagem agora. Tente pelo WhatsApp ou mais tarde.";
        }
    }

    if ($erro !== null) {
        flash("erro", $erro);
        $_SESSION["old"] = $dados;
    }

    header("Location: " . url("") . "#contato");
    exit;
}

require_once __DIR__ . "/classes/contato.php";

$successMessage = flash("sucesso");
$errorMessage   = flash("erro");
$old            = $_SESSION["old"] ?? [];
unset($_SESSION["old"]);

// ===============================
// DADOS DA PÁGINA
// ===============================

$servicos = require __DIR__ . "/includes/servicos.php";
$projetos = require __DIR__ . "/includes/projetos.php";

// Se existirem itens em destaque no banco, eles substituem a lista do arquivo.
try {
    $doBanco = (new Portfolio())->getDestaques();
    if ($doBanco) {
        $projetos = array_map(fn($p) => [
            "titulo"      => $p["titulo"] ?? "",
            "descricao"   => $p["descricao"] ?? "",
            "categoria"   => $p["categoria"] ?: "Projetos",
            "tecnologias" => [],
            "link"        => $p["link"] ?? "",
        ], $doBanco);
    }
} catch (Throwable $ex) {
    // Sem banco, a página continua funcionando com a lista do arquivo.
}

$categorias = array_values(array_unique(array_column($projetos, "categoria")));

$whatsLink = whatsappPlaceholder()
    ? ""
    : "https://wa.me/" . preg_replace("/\D/", "", WHATSAPP) . "?text=" . rawurlencode("Olá, Pedro! Vi seu portfólio e quero conversar sobre um projeto.");

$etapas = [
    ["titulo" => "Conversa inicial", "texto" => "Você me conta a ideia, o objetivo e o prazo. Eu faço as perguntas que ajudam a definir o escopo."],
    ["titulo" => "Proposta clara", "texto" => "Você recebe o que será entregue, o prazo e o valor antes de qualquer desenvolvimento começar."],
    ["titulo" => "Desenvolvimento com acompanhamento", "texto" => "Eu construo em etapas e mostro o progresso para você validar e ajustar no caminho."],
    ["titulo" => "Entrega e ajustes", "texto" => "Publicação, testes finais e os ajustes necessários para tudo funcionar como combinado."],
];

$pageTitle = APP_NAME . " — Desenvolvedor Full Stack | Sites, Sistemas, FiveM e Bots";
$isHome    = true;

include __DIR__ . "/includes/header.php";
?>

<main id="conteudo">

    <!-- HERO -->
    <section class="hero" id="inicio">
        <div class="container hero-content">

            <div class="hero-left">
                <span class="tag"><i class="fa-solid fa-code" aria-hidden="true"></i> Desenvolvedor Full Stack</span>

                <h1>Transformo ideias em <span>sites</span>, <span>sistemas</span> e <span>automações</span></h1>

                <p>Desenvolvo soluções sob medida para empresas, comunidades e criadores: da landing page ao sistema completo, de scripts FiveM a bots para Discord.</p>

                <div class="hero-buttons">
                    <a href="#contato" class="btn-primary">Solicitar orçamento</a>
                    <a href="#projetos" class="btn-secondary">Ver projetos</a>
                </div>

                <dl class="hero-stats">
                    <div>
                        <dt>Projetos em destaque</dt>
                        <dd><?= count($projetos) ?></dd>
                    </div>
                    <div>
                        <dt>Áreas de atuação</dt>
                        <dd>4</dd>
                    </div>
                    <div>
                        <dt>Atendimento</dt>
                        <dd>Direto</dd>
                    </div>
                </dl>
            </div>

            <div class="hero-right">
                <div class="profile-visual">
                    <div class="profile-glow"></div>
                    <img class="profile-photo"
                         src="<?= e(asset("assets/img/pedro-valenti.webp")) ?>"
                         srcset="<?= e(asset("assets/img/pedro-valenti-480.webp")) ?> 480w, <?= e(asset("assets/img/pedro-valenti.webp")) ?> 768w"
                         sizes="(max-width: 900px) 82vw, 490px"
                         width="768" height="1024"
                         fetchpriority="high"
                         alt="Retrato de Pedro Valenti, desenvolvedor Full Stack">
                    <div class="profile-badge">
                        <span class="availability-dot" aria-hidden="true"></span>
                        <span>Disponível para novos projetos</span>
                    </div>
                    <div class="terminal profile-code-card" aria-hidden="true">
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

        </div>
    </section>

    <!-- STACK -->
    <section class="stack" aria-label="Tecnologias">
        <div class="container stack-list">
            <span>PHP</span><span>JavaScript</span><span>React</span><span>Node.js</span><span>Lua</span><span>MySQL</span><span>discord.js</span><span>HTML &amp; CSS</span>
        </div>
    </section>

    <!-- SERVIÇOS -->
    <section class="section" id="servicos">
        <div class="container">
            <div class="section-title reveal">
                <span class="tag">Serviços</span>
                <h2>O que eu posso construir para você</h2>
                <p>Cada projeto é feito sob medida, sem depender de ferramentas genéricas.</p>
            </div>
            <div class="service-grid">
                <?php foreach ($servicos as $s): ?>
                    <article class="card reveal">
                        <span class="card-icon"><i class="fa-solid <?= e($s["icone"]) ?>" aria-hidden="true"></i></span>
                        <h3><?= e($s["titulo"]) ?></h3>
                        <p><?= e($s["texto"]) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- PROJETOS -->
    <section class="section" id="projetos">
        <div class="container">
            <div class="section-title reveal">
                <span class="tag">Projetos</span>
                <h2>Alguns trabalhos que eu já desenvolvi</h2>
                <p>Filtre por área para ver o que mais combina com a sua necessidade.</p>
            </div>

            <?php if (count($categorias) > 1): ?>
                <div class="filters reveal" role="group" aria-label="Filtrar projetos por área">
                    <button type="button" class="filter is-active" data-filter="todos" aria-pressed="true">Todos</button>
                    <?php foreach ($categorias as $cat): ?>
                        <button type="button" class="filter" data-filter="<?= e($cat) ?>" aria-pressed="false"><?= e($cat) ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="project-grid">
                <?php foreach ($projetos as $p): ?>
                    <article class="card project-card reveal" data-category="<?= e($p["categoria"]) ?>">
                        <span class="project-category"><?= e($p["categoria"]) ?></span>
                        <h3><?= e($p["titulo"]) ?></h3>
                        <p><?= e($p["descricao"]) ?></p>
                        <?php if (!empty($p["tecnologias"])): ?>
                            <ul class="chips" aria-label="Tecnologias">
                                <?php foreach ($p["tecnologias"] as $t): ?>
                                    <li><?= e($t) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if (!empty($p["link"])): ?>
                            <a class="project-link" href="<?= e($p["link"]) ?>" target="_blank" rel="noopener noreferrer">
                                Ver projeto <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- PROCESSO -->
    <section class="section" id="processo">
        <div class="container">
            <div class="section-title reveal">
                <span class="tag">Como trabalho</span>
                <h2>Do primeiro contato à entrega</h2>
            </div>
            <ol class="steps">
                <?php foreach ($etapas as $i => $etapa): ?>
                    <li class="card reveal">
                        <span class="step-number"><?= $i + 1 ?></span>
                        <h3><?= e($etapa["titulo"]) ?></h3>
                        <p><?= e($etapa["texto"]) ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </section>

    <!-- CONTATO -->
    <section class="section" id="contato">
        <div class="container contact-grid">

            <div class="reveal">
                <span class="tag">Contato</span>
                <h2>Pronto para transformar sua ideia em realidade?</h2>
                <p>Preencha o formulário e eu retorno com uma proposta alinhada ao seu objetivo.</p>

                <ul class="contact-methods">
                    <?php if ($whatsLink !== ""): ?>
                        <li><a href="<?= e($whatsLink) ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Chamar no WhatsApp</a></li>
                    <?php endif; ?>
                    <?php if (EMAIL_CONTATO !== ""): ?>
                        <li><a href="mailto:<?= e(EMAIL_CONTATO) ?>"><i class="fa-regular fa-envelope" aria-hidden="true"></i> <?= e(EMAIL_CONTATO) ?></a></li>
                    <?php endif; ?>
                    <?php if (GITHUB_URL !== ""): ?>
                        <li><a href="<?= e(GITHUB_URL) ?>" target="_blank" rel="noopener noreferrer"><i class="fa-brands fa-github" aria-hidden="true"></i> GitHub</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <form class="contact-form reveal" method="post" action="<?= e(url("")) ?>#contato" novalidate>
                <?php if ($successMessage): ?>
                    <div class="success-message" role="status"><?= e($successMessage) ?></div>
                <?php endif; ?>
                <?php if ($errorMessage): ?>
                    <div class="error-message" role="alert"><?= e($errorMessage) ?></div>
                <?php endif; ?>

                <input type="hidden" name="csrf" value="<?= e(csrfToken()) ?>">
                <input type="hidden" name="ts" value="<?= time() ?>">
                <input type="hidden" name="contact_submit" value="1">

                <!-- Campo-armadilha para robôs: humanos não veem -->
                <div class="hp-field" aria-hidden="true">
                    <label>Não preencha este campo <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>

                <label class="field">
                    <span>Nome</span>
                    <input type="text" name="nome" autocomplete="name" maxlength="150" required value="<?= e($old["nome"] ?? "") ?>">
                </label>
                <label class="field">
                    <span>E-mail</span>
                    <input type="email" name="email" autocomplete="email" maxlength="150" required value="<?= e($old["email"] ?? "") ?>">
                </label>
                <div class="field-row">
                    <label class="field">
                        <span>Telefone / WhatsApp <small>(opcional)</small></span>
                        <input type="tel" name="telefone" autocomplete="tel" maxlength="20" value="<?= e($old["telefone"] ?? "") ?>">
                    </label>
                    <label class="field">
                        <span>Assunto <small>(opcional)</small></span>
                        <input type="text" name="assunto" maxlength="255" value="<?= e($old["assunto"] ?? "") ?>">
                    </label>
                </div>
                <label class="field">
                    <span>O que você precisa?</span>
                    <textarea name="mensagem" rows="5" maxlength="5000" required><?= e($old["mensagem"] ?? "") ?></textarea>
                </label>

                <button type="submit" class="btn-primary">Enviar mensagem</button>
            </form>

        </div>
    </section>

</main>

<?php include __DIR__ . "/includes/footer.php"; ?>
