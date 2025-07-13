# L2 Origens - Site Web para Servidor Lineage 2 Interlude

Este é um projeto completo de site para servidor L2J Interlude baseado no servidor **L2JMega**.

## 🧩 Funcionalidades

- Cadastro/Login e Painel Admin
- Sistema de Roleta com sons e escolha de personagem
- Battle Pass mensal com tiers e recompensas visuais
- Loja virtual, Ranking, Bosses, Heróis e Sieges
- Votação Hopzone/Topzone com cooldown
- Doação via PayPal
- Instalação automática de `.env`

## ⚙️ Requisitos

- PHP 8.1+
- MySQL 5.7+
- Apache/Nginx
- Composer instalado

## 🚀 Instalação

1. Clone o projeto ou baixe o `.zip`
2. Acesse `http://localhost/install/install_env.php` e preencha os dados
3. Importe o arquivo `l2origens_site_schema.sql` no seu MySQL


## 🗂️ Estrutura

├── app/ # Controladores, modelos, views
├── assets/ # CSS, imagens
├── install/ # Instalador de .env
├── vendor/ # Autoload Composer
├── index.php # Roteador principal
├── .env # Configurações de conexão
