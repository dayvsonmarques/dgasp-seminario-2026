# �� Live Sass Compiler - Guia Rápido

## ✅ Configuração Aplicada

A extensão Live Sass Compiler está configurada para compilar em **2 locais**:
1. `/assets/css/style.css` - CSS compilado
2. `/style.css` - CSS do tema (raiz)

## 📝 Como Usar

### 🌟 Opção 1: Watch Automático (RECOMENDADO)

**Bash Script:**
```bash
./watch-sass.sh
```

**Ou Node.js Script:**
```bash
./watch-sass.js
# ou
node watch-sass.js
```

✨ **O que acontece:**
1. Script fica observando mudanças em arquivos `.scss`
2. Quando você salva um arquivo `.scss`
3. Sass compila automaticamente
4. CSS é copiado para `assets/css/style.css`
5. CSS é copiado para `style.css` (raiz do tema)
6. Você vê uma mensagem com timestamp
7. **Sem necessidade de copiar manualmente!**

👉 **Deixe o script rodando em um terminal e esqueça!**

### Opção 2: Live Sass Compiler (VSCode)

⚠️ **Não recomendado** - requer cópia manual após compilação

### Opção 3: Script Manual

```bash
./compile-sass.sh
```

## ⚠️ Problemas Comuns

### CSS não atualiza no navegador?

1. **Limpe o cache do navegador**: `Ctrl + Shift + R`
2. **Abra DevTools** → Network → Desabilite cache
3. **Hard refresh**: `Ctrl + F5`

### Live Sass não compila automaticamente?

1. **Use o script watch**: `./watch-sass.sh` (mais confiável)
2. Verifique se clicou em "Watch Sass" no VSCode
3. Verifique se o arquivo tem extensão `.scss`
4. Verifique o OUTPUT do VSCode (View → Output → Live Sass Compile)
5. Após compilar com Live Sass, copie manualmente: `cp assets/css/style.css style.css`
6. Use o script manual: `./compile-sass.sh`

### CSS está cacheado no WordPress?

O `functions.php` usa versionamento automático, mas você pode:
1. Limpar cache de plugins (WP Super Cache, etc)
2. Verificar se o arquivo foi atualizado: `stat style.css`

## 📂 Estrutura de Arquivos

```
congresso-custom/
├── .vscode/
│   └── settings.json         # Configuração do Live Sass
├── assets/
│   ├── css/
│   │   └── style.css         # CSS compilado (cópia)
│   └── sass/
│       ├── style.scss        # Arquivo principal
│       ├── _variables.scss   # Variáveis
│       ├── _colors.scss      # Cores
│       ├── _fonts.scss       # Fontes
│       ├── _header.scss      # Header
│       ├── _footer.scss      # Footer
│       ├── _home.scss        # Home
│       └── _schedule.scss    # Programação
├── style.css                 # CSS do tema (WordPress)
├── compile-sass.sh           # Script de compilação
└── functions.php             # Carrega o CSS com versionamento
```

## 🔄 Fluxo de Trabalho

1. Edite os arquivos `.scss` em `assets/sass/`
2. Live Sass compila automaticamente (se ativado)
3. CSS é gerado em `assets/css/style.css` e `/style.css`
4. WordPress carrega `/style.css` com versionamento automático
5. Limpe cache do navegador para ver mudanças

## 🎯 Dica Pro

Adicione esta task no `.vscode/tasks.json` para compilar com atalho:

```json
{
  "version": "2.0.0",
  "tasks": [
    {
      "label": "Compilar SASS",
      "type": "shell",
      "command": "./compile-sass.sh",
      "problemMatcher": [],
      "group": {
        "kind": "build",
        "isDefault": true
      }
    }
  ]
}
```

Depois use: `Ctrl + Shift + B` para compilar rapidamente!
