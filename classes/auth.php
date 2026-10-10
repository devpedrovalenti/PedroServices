<?php

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/usuario.php";

class Auth
{
    private ?Usuario $usuario = null;

    // O Usuario (e a conexão com o banco) só é criado quando realmente precisa,
    // assim verificar se há sessão ativa não depende do banco estar no ar.
    private function usuarios(): Usuario
    {
        return $this->usuario ??= new Usuario();
    }

    public function login(string $email, string $senha): bool
    {
        $usuario = $this->usuarios()->validarLogin($email, $senha);

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
            header("Location: " . url("login.php"));
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