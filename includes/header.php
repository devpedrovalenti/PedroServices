<?php
$pageTitle       = $pageTitle       ?? APP_NAME . " — " . APP_TAGLINE;
$pageDescription = $pageDescription ?? "Desenvolvo sites, sistemas web, scripts FiveM, bots para Discord e extensões de navegador. Veja projetos e peça seu orçamento.";
$pageRobots      = $pageRobots      ?? "index,follow";
$bodyClass       = $bodyClass       ?? "";
$isHome          = $isHome          ?? false;
$ogImage         = APP_URL . "/assets/img/pedro-valenti.webp";
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#07070B">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="robots" content="<?= e($pageRobots) ?>">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/svg+xml" href="<?= e(asset("assets/img/favicon.svg")) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?= e(asset("assets/css/style.css")) ?>">

<?php if ($isHome): ?>
    <script type="application/ld+json">
    <?= json_encode([
        "@context"    => "https://schema.org",
        "@type"       => "Person",
        "name"        => APP_NAME,
        "jobTitle"    => APP_TAGLINE,
        "url"         => APP_URL . "/",
        "image"       => $ogImage,
        "knowsAbout"  => ["PHP", "JavaScript", "React", "Lua", "FiveM", "Discord.js", "Node.js"],
        "sameAs"      => array_values(array_filter([GITHUB_URL, LINKEDIN_URL, INSTAGRAM_URL])),
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    </script>
<?php endif; ?>
</head>

<body class="<?= e($bodyClass) ?>">

<a class="skip-link" href="#conteudo">Pular para o conteúdo</a>

<div class="background" aria-hidden="true">
    <div class="blur blur1"></div>
    <div class="blur blur2"></div>
</div>

<header>
    <div class="container">

        <a href="<?= e(url("")) ?>#inicio" class="logo" aria-label="<?= e(APP_NAME) ?> — início">
            Pedro<span>.</span>
        </a>

        <button class="menu-toggle" type="button" aria-label="Abrir menu" aria-expanded="false" aria-controls="site-navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="site-navigation" aria-label="Navegação principal">
            <a href="<?= e(url("")) ?>#inicio">Início</a>
            <a href="<?= e(url("")) ?>#servicos">Serviços</a>
            <a href="<?= e(url("")) ?>#projetos">Projetos</a>
            <a href="<?= e(url("")) ?>#processo">Como trabalho</a>
            <a href="<?= e(url("")) ?>#contato">Contato</a>
        </nav>

        <a href="<?= e(url("")) ?>#contato" class="btn-primary header-cta">Solicitar orçamento</a>

    </div>
</header>
