#!/bin/bash

# Script para compilar SASS e atualizar o CSS do tema WordPress
# Uso: ./compile-sass.sh

echo "🔄 Compilando SASS..."

# Navega para o diretório sass
cd "$(dirname "$0")/assets/sass"

# Compila o SASS
npx sass style.scss ../css/style.css --no-source-map

if [ $? -eq 0 ]; then
    echo "✅ SASS compilado com sucesso!"
    
    # Copia para o diretório raiz do tema
    cd ../..
    cp assets/css/style.css style.css
    
    echo "✅ CSS copiado para o tema!"
    echo "📝 Arquivo: $(pwd)/style.css"
    echo ""
    echo "🌐 Limpe o cache do navegador (Ctrl+Shift+R) para ver as mudanças!"
else
    echo "❌ Erro ao compilar SASS!"
    exit 1
fi
