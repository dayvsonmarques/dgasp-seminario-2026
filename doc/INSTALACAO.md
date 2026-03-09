# 🚀 Guia de Instalação — Certify (via Duplicator)

Este documento orienta a instalação do site **III seminário estudual de atenção à saúde prisional de Pernambuco** em um servidor de produção utilizando o pacote gerado pelo plugin **Duplicator**.

---

## 📦 Arquivos fornecidos

Você receberá **dois arquivos** para realizar a instalação:

| Arquivo | Descrição |
|---|---|
| `installer.php` | Script instalador do site |
| `archive_YYYYMMDD_HHIISS_xxxxx.zip` | Código-fonte do site (arquivos + banco de dados) |

> **Não renomeie nem separe esses arquivos.** Eles precisam estar juntos no mesmo diretório.

---

## ✅ Pré-requisitos do servidor

Antes de iniciar, verifique se o servidor atende aos requisitos mínimos.

> 💡 Você pode validar o servidor antes da instalação acessando `check-server.php` na raiz do site após o deploy.

| Requisito | Mínimo | Recomendado |
|---|---|---|
| PHP | 7.4 | 8.1 ou superior |
| MySQL | 5.7 | 8.0 / MariaDB 10.4+ |
| Memória PHP (`memory_limit`) | 128M | 256M |
| Tamanho máximo de upload | 16M | 64M ou mais |
| Extensões PHP | `mysqli`, `curl`, `gd`, `zip`, `mbstring`, `xml` | — |
| Servidor web | Apache 2.4+ / Nginx | Apache com `mod_rewrite` ativo |
| Espaço em disco livre | 500 MB | 1 GB+ |

---

## 🗄️ Passo 1 — Criar o banco de dados

No painel do servidor (cPanel, Plesk, phpMyAdmin etc.), crie um banco de dados **novo e vazio** para o site.

Anote:
- **Nome do banco:** ex. `prod_certify`
- **Usuário:** ex. `certify_user`
- **Senha:** (defina uma senha forte)
- **Host:** geralmente `localhost`

> ⚠️ Não reutilize um banco de dados de outro site. Os dados serão sobrescritos.

---

## 📂 Passo 2 — Enviar os arquivos para o servidor

Faça upload dos **dois arquivos** para a raiz do domínio no servidor de produção (normalmente `public_html/`, `www/` ou `/var/www/html/`):

```
public_html/
├── installer.php
└── archive_YYYYMMDD_HHIISS_xxxxx.zip
```
---

## 🌐 Passo 3 — Executar o instalador

Abra o navegador e acesse:

```
https://seudominio.com.br/installer.php
```

Você verá o assistente de instalação do Duplicator. Siga os passos abaixo.

---

### 🔷 Etapa 1 — Deployment (Implantação)

**Seção Overview:** Confirme que o tipo de instalação é `Install – Single Site`.

**Seção Setup — Banco de dados:**

Preencha os campos com as credenciais criadas no Passo 1:

| Campo | Valor |
|---|---|
| Host | `localhost` (ou conforme seu provedor) |
| Database | Nome do banco criado |
| User | Usuário do banco |
| Password | Senha do banco |
| Action | `Create New Database` ou `Empty Database` |

**Seção Setup — Detalhes do site:**

- **Site URL:** será preenchida automaticamente com o domínio atual. Confirme se está correto.
- **Site Path:** caminho físico no servidor — normalmente não precisa alterar.

Clique em **Validate** para verificar a conexão com o banco e os requisitos do servidor.

> ✅ Todos os itens devem aparecer como OK ou Aviso (amarelo). Itens com falha (vermelho) precisam ser corrigidos antes de prosseguir.

Aceite os termos de uso e clique em **Next** para iniciar a instalação.

---

### 🔷 Etapa 2 — Install (Instalação)

O Duplicator irá:
1. Extrair os arquivos do `.zip` para o servidor
2. Importar o banco de dados
3. Atualizar URLs e caminhos para o novo ambiente

Aguarde a conclusão. Dependendo do tamanho do site e da velocidade do servidor, isso pode levar alguns minutos.

---

### 🔷 Etapa 3 — Test Site (Verificação)

Ao finalizar, você verá um resumo da instalação com o status de:
- Arquivos extraídos
- Banco de dados importado
- Busca e substituição de URLs

**Antes de clicar em Admin Login:**
- ✅ Marque a opção **"Auto delete installer files after login"** para remover os arquivos do instalador automaticamente (recomendado por segurança).

Clique em **Admin Login** para acessar o painel WordPress.

---

## 🔧 Passo 4 — Configurações pós-instalação

Após o login no painel WordPress, execute os seguintes passos:

### 1. Atualizar permalinks
Acesse **Configurações → Links Permanentes** e clique em **Salvar alterações** (sem mudar nada). Isso reescreve o `.htaccess` e corrige as URLs do site.

### 2. Verificar o `wp-config.php`
Confirme que as credenciais do banco de dados no `wp-config.php` estão corretas para o ambiente de produção:
```php
define( 'DB_NAME',     'prod_certify' );
define( 'DB_USER',     'certify_user' );
define( 'DB_PASSWORD', 'sua_senha' );
define( 'DB_HOST',     'localhost' );
```

### 3. Desativar o modo debug
Certifique-se de que no `wp-config.php`:
```php
define( 'WP_DEBUG', false );
```

### 4. Verificar o e-mail do administrador
Acesse **Configurações → Geral** e confirme o e-mail do site e do administrador.

### 5. Forçar HTTPS (se aplicável)
Se o servidor tiver SSL configurado, acesse **Configurações → Geral** e atualize as URLs para `https://`.

---

## 🔐 Segurança — Remover arquivos do instalador

Caso os arquivos do instalador **não tenham sido removidos automaticamente**, delete-os manualmente do servidor:

```
❌ Remover:
├── installer.php
├── installer-backup.php
├── dup-installer/
├── dup-installer-bootlog__*.txt
└── archive_*.zip
```

> ⚠️ Deixar esses arquivos no servidor é um **risco de segurança grave**. Qualquer pessoa pode re-executar a instalação e sobrescrever o banco de dados.

---

## 🩺 Verificar requisitos do servidor

Após a instalação, você pode acessar o verificador de requisitos para confirmar que o ambiente está correto:

```
https://seudominio.com.br/check-server.php
```

> 💡 Delete este arquivo do servidor de produção após a validação.

---

## ❓ Problemas comuns

| Problema | Solução |
|---|---|
| Timeout durante extração do `.zip` | Tente novamente; use o modo **Chunking** em Options → Advanced |
| Erro de conexão com o banco | Verifique host, usuário, senha e se o banco existe |
| Site abre com URL errada | Acesse Configurações → Links Permanentes e salve |
| Tela branca após login | Verifique os logs de erro do PHP; ative `WP_DEBUG` temporariamente |
| Arquivos do instalador não foram removidos | Delete manualmente via FTP ou gerenciador de arquivos |
| Imagens não carregam | Verifique permissões da pasta `wp-content/uploads/` (deve ser `755`) |

---

*Gerado em março de 2026 — WordPress*
