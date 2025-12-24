#!/bin/bash

# Script para limpar cache e forçar atualização dos assets

echo "🧹 Limpando cache do tema..."

# Adiciona timestamp ao style.css para forçar atualização
TIMESTAMP=$(date +%s)
echo ""
echo "✅ Timestamp gerado: $TIMESTAMP"

# Recompila SASS
echo ""
echo "📦 Recompilando SASS..."
cd /var/www/html/certify/wp-content/themes/congresso-custom/assets/sass
sass style.scss:../css/style.css --no-source-map

# Copia para o diretório raiz
cp ../css/style.css ../../style.css

echo ""
echo "✅ CSS atualizado!"
echo ""
echo "🌐 Agora faça:"
echo "   1. Abra o navegador"
echo "   2. Pressione Ctrl+Shift+R (hard refresh)"
echo "   3. Ou limpe o cache: Ctrl+Shift+Delete"
echo ""
