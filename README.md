
# **III Seminário Estadual de Atenção à Saúde Prisional de Pernambuco**

Site oficial do **Evento**, desenvolvido em WordPress com tema customizado.

Design: Fernando Valença

---

## Tecnologias

- **WordPress** (core)
- **PHP** 8.1+
- **MySQL / MariaDB**
- **Bootstrap 5.3**
- **Sass/SCSS** 
- **Tipografia:** Bebas Neue + Montserrat (Google Fonts)

---

## Estrutura do projeto

```
wp-content/
└── themes/
    └── congresso-custom/    ← Tema principal
        ├── functions.php    ← Toda a lógica do tema
        ├── header.php / footer.php
        ├── page-home.php    ← Template da página inicial
        ├── page-sobre.php   ← Template da página Sobre
        ├── page-comissoes.php
        ├── page-certificados.php
        ├── page-login.php
        ├── 404.php          ← Página de erro customizada
        ├── assets/sass/     ← Fonte dos estilos SCSS
        └── inc/             ← Includes do tema

doc/
├── requirements.md          ← Padrões de commit e diretrizes
└── INSTALACAO.md            ← Guia de instalação via Duplicator

check-server.php             ← Verificador de requisitos do servidor
```

---

## Funcionalidades implementadas

### Tema & Layout
- Banner principal com versão desktop e mobile configuráveis pelo admin
- Seções: Sobre, Programação, Comissões, Participe, Footer
- Layout responsivo mobile-first com Bootstrap 5
- Sistema tipográfico com Bebas Neue (títulos) e Montserrat (corpo)
- Variáveis SCSS centralizadas para cores e estilos globais
- Barras decorativas no header e footer
- Página 404 customizada

### CPTs (Custom Post Types)
- **Certificados** (`certify`) — com meta boxes para usuário, PDF e data de emissão
- **Eixos Temáticos** (`eixo_tematico`) — para organização de conteúdo

### Campos dinâmicos no Admin
- Página inicial: banner desktop/mobile, blocos de texto, programação e seção de participação
- Footer: e-mail e telefone de contato editáveis via Customizer
- Menu: label do item Certificados editável via Customizer

### Segurança
- Comentários completamente desabilitados (suporte, filtros, REST API, feeds, `wp-comments-post.php`)
- Menu de comentários removido do painel admin
- Headers HTTP anti-cache no front-end (evita problema de cache no Firefox)
- Verificador de requisitos do servidor (`check-server.php`)

### Compilação de estilos
- Sass com watch automático via `watch-sass.js` / `watch-sass.sh`
- Compilação manual via `compile-sass.sh`
- Guias em `SASS-GUIDE.md` e `LIVE-SASS-GUIDE.md`

---

## Instalação em produção

Consulte o guia completo em [`doc/INSTALACAO.md`](doc/INSTALACAO.md).

O pacote de instalação é gerado pelo plugin **Duplicator** e consiste em dois arquivos:
- `installer.php`
- `archive_*.zip`

Para verificar se o servidor atende aos requisitos mínimos, acesse `check-server.php` após o upload dos arquivos.

---

## Desenvolvimento local

```bash
# 1. Clone o repositório
git clone <repo-url>

# 2. Configure as credenciais do banco em wp-config.php

# 3. Compile os estilos Sass
cd wp-content/themes/congresso-custom
./watch-sass.sh      # modo watch (desenvolvimento)
./compile-sass.sh    # compilação única
```

---

## Padrões de commit

Consulte [`doc/requirements.md`](doc/requirements.md). Resumo:

| Prefixo | Uso |
|---|---|
| `feat:` | Nova funcionalidade |
| `fix:` | Correção de bug |
| `hotfix:` | Correção urgente em produção |
| `refactor:` | Refatoração de código |
| `style:` | Alterações de CSS/SCSS |
| `docs:` | Documentação |
| `issue:` | Mudança relacionada a uma issue |

Mensagens sempre em **inglês**, máximo **12 palavras**.

---

## Branches

| Branch | Finalidade |
|---|---|
| `main` | Código estável / produção |
| `develop` | Integração de features |
| `feat/*` | Novas funcionalidades |
| `fix/*` | Correções de bugs |
| `hotfix/*` | Correções críticas em produção |
