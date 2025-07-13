
# L2 Origens Site

Este é um painel web completo para servidor Lineage 2 Interlude (L2JMega).

## Funcionalidades

- Cadastro, login, roleta, battle pass, donate (PayPal)
- Painel admin com recompensas, eventos e logs
- Ranking, loja, bosses, sieges, heróis e sistema de votos
- Estilo dark responsivo

## Requisitos

- PHP 8.1+
- MySQL
- Apache (ou outro servidor com suporte a .htaccess)
- Composer

## Instalação

1. Clone o projeto ou envie os arquivos para seu servidor:
   ```bash
   git clone https://github.com/spiteridiick/l2-origens-site.git
   ```

2. Acesse `http://localhost/install_env.php` e preencha os dados do banco de dados para gerar o `.env`

3. Rode o Composer:
   ```bash
   composer install
   ```

4. Importe o arquivo `l2origens_site_schema.sql` no seu banco de dados L2JMega.

5. Pronto!

## Credenciais admin (exemplo)
A conta admin deve ter `access_level >= 1` no banco `accounts`.

---
Desenvolvido por Marcos Victor @spiteridiick
