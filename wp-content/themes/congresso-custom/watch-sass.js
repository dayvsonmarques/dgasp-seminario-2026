#!/usr/bin/env node

/**
 * Script de observação e compilação automática de SASS
 * Detecta mudanças em arquivos .scss e compila automaticamente
 */

const { spawn } = require('child_process');
const fs = require('fs');
const path = require('path');

const themeDir = __dirname;
const sassDir = path.join(themeDir, 'assets', 'sass');
const cssDir = path.join(themeDir, 'assets', 'css');
const targetCss = path.join(themeDir, 'style.css');

console.log('👀 Observando mudanças nos arquivos SCSS...');
console.log(`📂 Diretório: ${sassDir}`);
console.log('');
console.log('⚠️  Pressione Ctrl+C para parar');
console.log('');

// Inicia o Sass em modo watch
const sass = spawn('npx', [
  'sass',
  '--watch',
  'style.scss:../css/style.css',
  '--no-source-map'
], {
  cwd: sassDir,
  stdio: 'pipe'
});

// Função para copiar CSS
function copyCss() {
  const sourceCss = path.join(cssDir, 'style.css');
  
  if (fs.existsSync(sourceCss)) {
    fs.copyFileSync(sourceCss, targetCss);
    const time = new Date().toLocaleTimeString('pt-BR');
    console.log(`✅ CSS atualizado e copiado em ${time}`);
    console.log('🌐 Recarregue o navegador (Ctrl+Shift+R)');
    console.log('');
  }
}

// Monitora a saída do Sass
sass.stdout.on('data', (data) => {
  const output = data.toString();
  console.log(output);
  
  if (output.includes('Compiled') || output.includes('compiled')) {
    copyCss();
  }
});

sass.stderr.on('data', (data) => {
  console.error(data.toString());
});

sass.on('close', (code) => {
  if (code !== 0) {
    console.error(`❌ Sass watch parou com código ${code}`);
    process.exit(code);
  }
});

// Copia inicialmente se o arquivo já existir
setTimeout(() => {
  copyCss();
  console.log('✨ Watch iniciado! Edite arquivos .scss e veja a mágica acontecer!');
  console.log('');
}, 1000);

// Cleanup ao sair
process.on('SIGINT', () => {
  console.log('\n👋 Parando observação...');
  sass.kill();
  process.exit(0);
});
