#!/bin/bash

# Script para observar mudanças nos arquivos SCSS e compilar automaticamente
# Uso: ./watch-sass.sh

# Obtém o diretório absoluto do script
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SASS_DIR="$SCRIPT_DIR/assets/sass"
CSS_FILE="$SCRIPT_DIR/assets/css/style.css"
TARGET_FILE="$SCRIPT_DIR/style.css"

echo "👀 Observando mudanças nos arquivos SCSS..."
echo "📂 Sass: $SASS_DIR"
echo "📂 CSS: $CSS_FILE"
echo "📂 Target: $TARGET_FILE"
echo ""
echo "⚠️  Pressione Ctrl+C para parar"
echo ""

cd "$SASS_DIR" || exit 1

echo "🚀 Iniciando Sass em modo watch..."
echo ""

# Verifica se o sass está instalado
if ! command -v sass &> /dev/null; then
    echo "❌ Erro: sass não encontrado!"
    echo "📦 Instale com: sudo npm install -g sass"
    exit 1
fi

# Usa sass em modo watch e processa a saída
sass --watch style.scss:../css/style.css --no-source-map 2>&1 | while IFS= read -r line; do
    echo "$line"
    
    # Quando detectar compilação bem-sucedida, copia o arquivo
    if [[ "$line" == *"Compiled"* ]]; then
        if [ -f "$CSS_FILE" ]; then
            cp "$CSS_FILE" "$TARGET_FILE"
            echo ""
            echo "✅ CSS copiado para $TARGET_FILE em $(date '+%H:%M:%S')"
            echo "🌐 Recarregue o navegador (Ctrl+Shift+R)"
            echo ""
        fi
    fi
done
