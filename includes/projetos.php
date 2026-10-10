<?php

/**
 * Projetos exibidos no portfólio.
 *
 * Edite livremente: titulo, descricao, categoria, tecnologias (lista) e link (opcional).
 * Se a tabela `portfolio` do banco tiver itens com destaque = 1, eles têm prioridade
 * sobre esta lista (veja index.php).
 *
 * Categorias usadas nos filtros: "Sites & Sistemas", "FiveM", "Bots Discord", "Extensões".
 */
return [
    [
        "titulo"      => "Sistema de barbearia",
        "descricao"   => "Landing, área do cliente e área do profissional para agendamento e gestão de uma barbearia.",
        "categoria"   => "Sites & Sistemas",
        "tecnologias" => ["React", "Vite"],
        "link"        => "",
    ],
    [
        "titulo"      => "Gestão de clínica e agendamentos",
        "descricao"   => "Sistema com calendário de agendamentos e perfis de acesso (admin, funcionário e recepcionista).",
        "categoria"   => "Sites & Sistemas",
        "tecnologias" => ["PHP", "Controle de acesso"],
        "link"        => "",
    ],
    [
        "titulo"      => "Site para doces e bolos",
        "descricao"   => "Site de vendas moderno e direto ao ponto para quem trabalha com doces e bolos caseiros.",
        "categoria"   => "Sites & Sistemas",
        "tecnologias" => ["React"],
        "link"        => "",
    ],
    [
        "titulo"      => "HUD para servidor de GTA RP",
        "descricao"   => "Interface completa do jogador: chat, perfil, menus, chamadas, armory e mais, com layout responsivo.",
        "categoria"   => "FiveM",
        "tecnologias" => ["React", "Vite", "NUI"],
        "link"        => "",
    ],
    [
        "titulo"      => "Garagem multi-framework",
        "descricao"   => "Script standalone de garagem com suporte a Qbox, QBCore, ESX e variações de vRP.",
        "categoria"   => "FiveM",
        "tecnologias" => ["Lua", "FiveM"],
        "link"        => "",
    ],
    [
        "titulo"      => "Painel de streamers (/lives)",
        "descricao"   => "Painel que confirma se o streamer está ao vivo de verdade via API da Twitch, YouTube, Kick e TikTok.",
        "categoria"   => "FiveM",
        "tecnologias" => ["FiveM", "APIs de live"],
        "link"        => "",
    ],
    [
        "titulo"      => "Bot de allowlist e tickets",
        "descricao"   => "Aprovação e reprovação de allowlist, tickets por categoria e logs gerais para servidores FiveM.",
        "categoria"   => "Bots Discord",
        "tecnologias" => ["discord.js v14", "Node.js"],
        "link"        => "",
    ],
    [
        "titulo"      => "Lumina — bot multifuncional",
        "descricao"   => "Entretenimento, moderação, economia e utilidades em um só bot, com interface em Components V2.",
        "categoria"   => "Bots Discord",
        "tecnologias" => ["discord.js v14", "Components V2"],
        "link"        => "",
    ],
    [
        "titulo"      => "Habblet Tools",
        "descricao"   => "Extensão para Chrome (Manifest V3) que adiciona ferramentas extras ao site de jogo Habblet.",
        "categoria"   => "Extensões",
        "tecnologias" => ["Chrome Extension", "Manifest V3", "JavaScript"],
        "link"        => "",
    ],
];
