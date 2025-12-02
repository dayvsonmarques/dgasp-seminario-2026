# 🎨 Guia de Compilação SASS

## Problema Identificado

O tema estava carregando dois arquivos CSS:
1. ✅ `style.css` (raiz do tema) - arquivo correto
2. ❌ `assets/css/main.css` - arquivo vazio causando conflito

## Solução Aplicada

1. **Removido** a linha que carregava `main.css` do `functions.php`
2. **Adicionado** versionamento automático baseado na data de modificação do arquivo
3. **Criado** script de compilação automática `compile-sass.sh`

## Como Compilar SASS

### Opção 1: Script Automático (Recomendado)
```bash
./compile-sass.sh
```

### Opção 2: Comando Manual
```bash
cd assets/sass
npx sass style.scss ../css/style.css --no-source-map
cd ../..
cp assets/css/style.css style.css
```

## Estrutura de Arquivos SASS

```
assets/sass/
├── style.scss          # Arquivo principal (apenas imports)
├── _variables.scss     # Variáveis (breakpoints, fonts, etc)
├── _colors.scss        # Paleta de cores do tema
├── _fonts.scss         # Importação de fontes
├── _header.scss        # Estilos do header
├── _footer.scss        # Estilos do footer
├── _home.scss          # Estilos da home (banner, about)
└── _schedule.scss      # Estilos da seção de programação
```

## Variáveis de Breakpoints Bootstrap

```scss
$breakpoint-xs: 0;
$breakpoint-sm: 576px;
$breakpoint-md: 768px;
$breakpoint-lg: 992px;
$breakpoint-xl: 1200px;
$breakpoint-xxl: 1400px;
```

## Abordagem Mobile-First

Todos os arquivos SCSS usam a abordagem **mobile-first** com `min-width`:

```scss
// Estilos base (mobile)
.element {
  font-size: 1rem;
}

// Tablets e maiores
@media (min-width: $breakpoint-md) {
  .element {
    font-size: 1.2rem;
  }
}

// Desktop e maiores
@media (min-width: $breakpoint-lg) {
  .element {
    font-size: 1.5rem;
  }
}
```

## Cache do Navegador

Após compilar, **sempre limpe o cache do navegador**:
- **Chrome/Edge/Firefox**: `Ctrl + Shift + R` (Windows/Linux)
- **Chrome/Edge/Firefox**: `Cmd + Shift + R` (Mac)
- Ou abra DevTools e clique com botão direito no reload → "Limpar cache e recarregar"

## Versionamento Automático

O `functions.php` agora usa `filemtime()` para versionar automaticamente o CSS:

```php
wp_enqueue_style('congresso-custom-style', get_stylesheet_uri(), [], filemtime(get_template_directory() . '/style.css'));
```

Isso gera URLs como: `style.css?ver=1701536123` e força o navegador a recarregar quando o arquivo muda.

## Troubleshooting

### CSS não atualiza no site?
1. ✅ Compile o SASS: `./compile-sass.sh`
2. ✅ Limpe o cache do navegador: `Ctrl + Shift + R`
3. ✅ Verifique se o arquivo foi atualizado: `ls -lah style.css`
4. ✅ Se usar plugin de cache (WP Super Cache, etc), limpe o cache do WordPress

### Erros ao compilar?
- Verifique se está no diretório correto do tema
- Certifique-se de que o Node.js está instalado: `node --version`
- Instale o Sass se necessário: `npm install -g sass`
