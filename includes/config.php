<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===============================
// CONFIGURAÇÕES DO SISTEMA
// ===============================

define("APP_NAME", "Pedro Valenti");

$basePath = dirname($_SERVER["SCRIPT_NAME"] ?? "/");
if ($basePath === "/" || $basePath === "\\") {
    $basePath = "";
}

$scheme = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$host = $_SERVER["HTTP_HOST"] ?? "localhost";

define("APP_URL", $scheme . "://" . $host . $basePath);
define("APP_ROOT", dirname(__DIR__));
define("APP_VERSION", "1.0.0");

// Banco de Dados

define("DB_HOST", "localhost");
define("DB_NAME", "landing");
define("DB_USER", "root");
define("DB_PASS", "");

// WhatsApp

define("WHATSAPP", "5511999999999");

// OpenAI (iremos utilizar depois)

define("OPENAI_KEY", "");

// Timezone

date_default_timezone_set("America/Sao_Paulo");