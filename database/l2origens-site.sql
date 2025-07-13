-- Tabela de usuários para login do painel
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    access_level INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Log de votos por IP/site
CREATE TABLE IF NOT EXISTS vote_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    account VARCHAR(50),
    ip_address VARCHAR(45),
    site VARCHAR(20),
    voted_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Log de ações do painel admin
CREATE TABLE IF NOT EXISTS admin_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_login VARCHAR(50),
    action TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Recompensas da roleta e battle pass
CREATE TABLE IF NOT EXISTS rewards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    item_name VARCHAR(100),
    amount INT NOT NULL,
    enchant INT DEFAULT 0,
    type VARCHAR(20),
    is_active TINYINT DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Eventos programados no painel
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    descricao TEXT,
    data_inicio DATETIME,
    data_fim DATETIME,
    ativo TINYINT DEFAULT 1,
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Battle Pass mensal
CREATE TABLE IF NOT EXISTS battle_pass (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tier INT,
    descricao VARCHAR(100),
    recompensa_item INT,
    quantidade INT,
    imagem_url VARCHAR(255),
    ativo TINYINT DEFAULT 1
);

DROP TABLE IF EXISTS shop_items;
CREATE TABLE shop_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    description TEXT,
    category VARCHAR(50),
    icon VARCHAR(100)
);

CREATE TABLE roleta_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    probabilidade INT NOT NULL DEFAULT 0, -- Probabilidade em % (0-100)
    item_id INT, -- ID do item correspondente no jogo (se aplicável)
    quantidade INT DEFAULT 1,
    imagem VARCHAR(255), -- URL da imagem do item
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE sieges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    recompensas TEXT, -- Pode armazenar JSON para recompensas complexas
    status ENUM('scheduled', 'active', 'finished', 'cancelled') DEFAULT 'scheduled',
    localizacao VARCHAR(255),
    min_players INT DEFAULT 0,
    max_players INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE loja_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    item_id INT, -- ID do item correspondente no jogo (se aplicável)
    quantidade INT DEFAULT 1,
    categoria VARCHAR(100),
    imagem VARCHAR(255), -- URL da imagem do item
    status ENUM('active', 'inactive', 'promo') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);