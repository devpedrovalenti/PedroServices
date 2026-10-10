-- ============================================
-- Landing Page - Pedro Valenti
-- Versão 1.0
-- ============================================

CREATE DATABASE IF NOT EXISTS landing
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE landing;

-- ============================================
-- TABELA DE CLIENTES
-- ============================================

CREATE TABLE IF NOT EXISTS clientes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL,

    email VARCHAR(150),

    telefone VARCHAR(20),

    empresa VARCHAR(150),

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ============================================
-- TABELA DE CONVERSAS COM A IA
-- ============================================

CREATE TABLE IF NOT EXISTS conversas (

    id INT AUTO_INCREMENT PRIMARY KEY,

    cliente_id INT NULL,

    pergunta LONGTEXT NOT NULL,

    resposta LONGTEXT,

    valor_min DECIMAL(10,2) DEFAULT 0,

    valor_max DECIMAL(10,2) DEFAULT 0,

    complexidade ENUM(
        'Baixa',
        'Média',
        'Alta'
    ) DEFAULT 'Baixa',

    status ENUM(
        'Novo',
        'Em negociação',
        'Fechado',
        'Cancelado'
    ) DEFAULT 'Novo',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (cliente_id)
    REFERENCES clientes(id)
    ON DELETE SET NULL

);

-- ============================================
-- TABELA DE PROJETOS
-- ============================================

CREATE TABLE IF NOT EXISTS projetos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    cliente_id INT NOT NULL,

    titulo VARCHAR(255),

    descricao LONGTEXT,

    tipo VARCHAR(100),

    valor DECIMAL(10,2),

    prazo INT,

    status ENUM(

        'Orçamento',

        'Em andamento',

        'Finalizado',

        'Cancelado'

    ) DEFAULT 'Orçamento',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(cliente_id)
    REFERENCES clientes(id)
    ON DELETE CASCADE

);

-- ============================================
-- ADMINISTRADORES
-- ============================================

CREATE TABLE IF NOT EXISTS usuarios (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(120),

    email VARCHAR(150) NOT NULL UNIQUE,

    senha VARCHAR(255) NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- O administrador NÃO é mais criado com senha padrão.
-- Depois de importar este arquivo, rode no terminal:
--   php scripts/criar-admin.php

-- ============================================
-- PORTFÓLIO
-- ============================================

CREATE TABLE IF NOT EXISTS portfolio (

    id INT AUTO_INCREMENT PRIMARY KEY,

    titulo VARCHAR(255),

    descricao TEXT,

    imagem VARCHAR(255),

    link VARCHAR(255),

    categoria VARCHAR(100),

    destaque BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ============================================
-- DEPOIMENTOS
-- ============================================

CREATE TABLE IF NOT EXISTS depoimentos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(120),

    empresa VARCHAR(120),

    foto VARCHAR(255),

    depoimento TEXT,

    estrelas INT DEFAULT 5,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ============================================
-- MENSAGENS DO FORMULÁRIO
-- ============================================

CREATE TABLE IF NOT EXISTS contatos (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150),

    email VARCHAR(150),

    telefone VARCHAR(20),

    assunto VARCHAR(255),

    mensagem LONGTEXT,

    lido BOOLEAN DEFAULT FALSE,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ============================================
-- CONFIGURAÇÕES
-- ============================================

CREATE TABLE IF NOT EXISTS configuracoes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(100),

    valor LONGTEXT

);

INSERT INTO configuracoes(nome,valor) VALUES
('site_nome','Pedro Valenti'),
('site_descricao','Desenvolvedor Full Stack'),
('whatsapp','5511999999999'),
('email','contato@seudominio.com'),
('github',''),
('linkedin',''),
('instagram','');