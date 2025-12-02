# 🎨 Guia de Compilação Automática do Sass

## ✅ Solução Final - Script watch-sass.sh

O tema agora possui um script automatizado que compila E copia o CSS automaticamente!

### 🚀 Como Usar

1. **Iniciar o watch:**
```bash
./watch-sass.sh
```

2. **O que ele faz:**
   - 👀 Observa mudanças em qualquer arquivo `.scss`
   - 🔄 Compila automaticamente quando detecta mudanças
   - 📋 **Copia automaticamente** o CSS compilado para o root do tema
   - ✅ Mostra mensagem de sucesso com horário
   - 🌐 Lembra de recarregar o navegador

3. **Para parar:**
   - Pressione `Ctrl+C` no terminal

### 📁 Estrutura de Arquivos

```
congresso-custom/
├── style.css                    ← Carregado pelo WordPress (auto-copiado)
├── assets/
│   ├── css/
│   │   └── style.css           ← Compilado pelo Sass
│   └── sass/
│       ├── style.scss          ← Arquivo principal (imports)
│       ├── _variables.scss
│       ├── _colors.scss
│       ├── _fonts.scss
│       ├── _header.scss
│       ├── _footer.scss
│       ├── _home.scss
│       └── _schedule.scss
└── watch-sass.sh               ← Script de automação
```

### 🔄 Workflow de Desenvolvimento

1. Execute `./watch-sass.sh` uma vez
2. Edite qualquer arquivo `.scss`
3. Salve o arquivo
4. O Sass compila automaticamente
5. O CSS é copiado automaticamente para `style.css`
6. Recarregue o navegador com `Ctrl+Shift+R`

### ⚡ Vantagens

✅ **100% Automático** - Sem cópias manuais!  
✅ **Feedback Visual** - Mensagens coloridas no terminal  
✅ **Watch Inteligente** - Detecta mudanças em qualquer partial  
✅ **Caminhos Absolutos** - Funciona de qualquer diretório  
✅ **Sem Dependências** - Usa apenas `npx sass`

### 🐛 Troubleshooting

**Problema:** Script não inicia  
**Solução:** Verifique permissões com `chmod +x watch-sass.sh`

**Problema:** CSS não atualiza no navegador  
**Solução:** Force reload com `Ctrl+Shift+R` (limpa cache)

**Problema:** Erro "Arquivo não encontrado"  
**Solução:** Execute sempre de dentro do diretório do tema

### 📊 Exemplo de Saída

```
👀 Observando mudanças nos arquivos SCSS...
📂 Sass: /var/www/.../assets/sass
📂 CSS: /var/www/.../assets/css/style.css
📂 Target: /var/www/.../style.css

⚠️  Pressione Ctrl+C para parar

🚀 Iniciando Sass em modo watch...

Sass is watching for changes. Press Ctrl-C to stop.

[2025-12-02 19:00] Compiled style.scss to ../css/style.css.

✅ CSS copiado para .../style.css em 19:00:40
🌐 Recarregue o navegador (Ctrl+Shift+R)
```

---

## 🎯 Outras Opções (Obsoletas)

### Opção 1: Live Sass Compiler (Extensão VS Code)

A extensão Live Sass Compiler compila automaticamente, mas **NÃO copia** para o root.  
Por isso, criamos o script `watch-sass.sh` que faz tudo automaticamente!

### Opção 2: Compilação Manual

Se preferir compilar manualmente:

```bash
./compile-sass.sh
```

Mas o recomendado é usar o `watch-sass.sh` para desenvolvimento! 🚀
