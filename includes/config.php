<?php

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        "httponly" => true,
        "samesite" => "Lax",
        "secure"   => !empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off",
    ]);
    session_start();
}

// ===============================
// .env (credenciais fora do código)
// ===============================

function carregarEnv(string $caminho): void
{
    if (!is_readable($caminho)) {
        return;
    }

    foreach (file($caminho, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        $linha = trim($linha);
        if ($linha === "" || $linha[0] === "#" || !str_contains($linha, "=")) {
            continue;
        }
        [$nome, $valor] = explode("=", $linha, 2);
        $_ENV[trim($nome)] = trim($valor, " \t\"'");
    }
}

function env(string $chave, string $padrao = ""): string
{
    return $_ENV[$chave] ?? $padrao;
}

carregarEnv(dirname(__DIR__) . "/.env");

// ===============================
// CONFIGURAÇÕES DO SISTEMA
// ===============================

define("APP_NAME", "Pedro Valenti");
define("APP_TAGLINE", "Desenvolvedor Full Stack");
define("APP_VERSION", "2.0.0");
define("APP_ROOT", dirname(__DIR__));

// Caminho base calculado a partir da raiz do projeto (funciona em / ou em /subpasta,
// e também dentro de /admin, onde o SCRIPT_NAME antigo quebrava os links).
$docRoot  = rtrim(str_replace("\\", "/", realpath($_SERVER["DOCUMENT_ROOT"] ?? "") ?: ""), "/");
$appRoot  = str_replace("\\", "/", APP_ROOT);
$basePath = ($docRoot !== "" && str_starts_with($appRoot, $docRoot)) ? substr($appRoot, strlen($docRoot)) : "";

$scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$host   = $_SERVER["HTTP_HOST"] ?? "localhost";

define("APP_BASE", $basePath);
define("APP_URL", $scheme . "://" . $host . $basePath);

// Banco de dados (valores vêm do .env)
define("DB_HOST", env("DB_HOST", "localhost"));
define("DB_NAME", env("DB_NAME", "landing"));
define("DB_USER", env("DB_USER", "root"));
define("DB_PASS", env("DB_PASS", ""));

// Contato público (edite aqui ou no .env)
define("WHATSAPP", env("WHATSAPP", "5511999999999")); // formato: DDI + DDD + número
define("EMAIL_CONTATO", env("EMAIL_CONTATO", ""));
define("GITHUB_URL", env("GITHUB_URL", ""));
define("LINKEDIN_URL", env("LINKEDIN_URL", ""));
define("INSTAGRAM_URL", env("INSTAGRAM_URL", ""));

define("OPENAI_KEY", env("OPENAI_KEY", ""));

date_default_timezone_set("America/Sao_Paulo");

// ===============================
// HELPERS
// ===============================

function e(?string $texto): string
{
    return htmlspecialchars($texto ?? "", ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function asset(string $caminho): string
{
    $arquivo = APP_ROOT . "/" . ltrim($caminho, "/");
    $versao  = is_file($arquivo) ? filemtime($arquivo) : APP_VERSION;
    return APP_BASE . "/" . ltrim($caminho, "/") . "?v=" . $versao;
}

function url(string $caminho = ""): string
{
    return APP_BASE . "/" . ltrim($caminho, "/");
}

// Conta caracteres (UTF-8) sem depender da extensão mbstring
function tamanho(string $texto): int
{
    return (int)preg_match_all("/./su", $texto);
}

function whatsappPlaceholder(): bool
{
    return WHATSAPP === "" || str_ends_with(WHATSAPP, "999999999");
}

function csrfToken(): string
{
    if (empty($_SESSION["csrf"])) {
        $_SESSION["csrf"] = bin2hex(random_bytes(32));
    }
    return $_SESSION["csrf"];
}

function csrfValido(?string $token): bool
{
    return is_string($token) && !empty($_SESSION["csrf"]) && hash_equals($_SESSION["csrf"], $token);
}

function flash(string $tipo, ?string $mensagem = null): ?string
{
    if ($mensagem !== null) {
        $_SESSION["flash"][$tipo] = $mensagem;
        return null;
    }
    $valor = $_SESSION["flash"][$tipo] ?? null;
    unset($_SESSION["flash"][$tipo]);
    return $valor;
}
