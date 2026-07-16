<?php

require_once __DIR__ . "/usuario.php";

class Auth
{
    private Usuario $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function login(string $email, string $senha): bool
    {
        $usuario = $this->usuario->validarLogin($email, $senha);

        if (!$usuario) {
            return false;
        }

        session_regenerate_id(true);

        $_SESSION["user"] = [
            "id" => (int)$usuario["id"],
            "nome" => $usuario["nome"],
            "email" => $usuario["email"]
        ];

        return true;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                "",
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    public function check(): bool
    {
        return isset($_SESSION["user"]);
    }

    public function requireLogin(): void
    {
        if (!$this->check()) {
            header("Location: login.php");
            exit;
        }
    }

    public function user(): ?array
    {
        return $_SESSION["user"] ?? null;
    }

    public function id(): ?int
    {
        return $_SESSION["user"]["id"] ?? null;
    }

    public function nome(): ?string
    {
        return $_SESSION["user"]["nome"] ?? null;
    }

    public function email(): ?string
    {
        return $_SESSION["user"]["email"] ?? null;
    }

    public function isGuest(): bool
    {
        return !$this->check();
    }
}