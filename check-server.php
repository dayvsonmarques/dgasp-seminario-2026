<?php
/**
 * Server Requirements Checker
 * 
 * Validates if the server has all necessary configurations
 * to run this WordPress site properly.
 *
 * Usage: php check-server.php (CLI) or access via browser
 * 
 * @author  Dayvson Marques
 * @link    https://dayvsonmarques.dev.br
 */

// Block access in production (remove this line to run)
if (php_sapi_name() !== 'cli' && !defined('WP_DEBUG')) {
    // Uncomment below to restrict access:
    // die('Access denied. Run via CLI: php check-server.php');
}

$is_cli = php_sapi_name() === 'cli';

// ── Results storage ──────────────────────────────────────────────
$results = [];
$total_pass = 0;
$total_fail = 0;
$total_warn = 0;

function check($category, $label, $status, $current, $expected, $hint = '') {
    global $results, $total_pass, $total_fail, $total_warn;

    if ($status === 'pass') $total_pass++;
    elseif ($status === 'fail') $total_fail++;
    else $total_warn++;

    $results[$category][] = [
        'label'    => $label,
        'status'   => $status,
        'current'  => $current,
        'expected' => $expected,
        'hint'     => $hint,
    ];
}

// ── 1. PHP Version ───────────────────────────────────────────────
$php_version = phpversion();
$php_min = '7.4.0';
$php_rec = '8.1.0';

if (version_compare($php_version, $php_rec, '>=')) {
    check('PHP', 'Versão do PHP', 'pass', $php_version, ">= $php_rec (recomendado)");
} elseif (version_compare($php_version, $php_min, '>=')) {
    check('PHP', 'Versão do PHP', 'warn', $php_version, ">= $php_rec (recomendado)", "Funciona, mas considere atualizar para PHP 8.1+");
} else {
    check('PHP', 'Versão do PHP', 'fail', $php_version, ">= $php_min (mínimo)", "WordPress 6.x requer PHP 7.4+");
}

// ── 2. PHP Extensions ───────────────────────────────────────────
$required_extensions = [
    'mysqli'    => 'Conexão com MySQL/MariaDB',
    'curl'      => 'Requisições HTTP (atualizações, APIs)',
    'gd'        => 'Manipulação de imagens (thumbnails, uploads)',
    'mbstring'  => 'Manipulação de strings multibyte (UTF-8)',
    'xml'       => 'Parsing XML (feeds RSS, sitemaps)',
    'json'      => 'Manipulação de dados JSON',
    'zip'       => 'Instalação/atualização de plugins e temas',
    'intl'      => 'Internacionalização (tradução pt_BR)',
    'openssl'   => 'Conexões HTTPS seguras',
    'fileinfo'  => 'Detecção de tipo MIME (uploads)',
];

$recommended_extensions = [
    'imagick'     => 'Manipulação avançada de imagens (PDF thumbnails)',
    'exif'        => 'Leitura de metadados de imagens',
    'sodium'      => 'Criptografia moderna (WP 5.2+)',
    'opcache'     => 'Cache de bytecode PHP (performance)',
    'dom'         => 'Manipulação de DOM/HTML',
    'simplexml'   => 'Parsing XML simplificado',
    'xmlreader'   => 'Leitura de XML (importação)',
];

foreach ($required_extensions as $ext => $desc) {
    if (extension_loaded($ext)) {
        check('Extensões PHP (obrigatórias)', "$ext — $desc", 'pass', 'Instalada', 'Instalada');
    } else {
        check('Extensões PHP (obrigatórias)', "$ext — $desc", 'fail', 'Não encontrada', 'Instalada', "apt install php-$ext");
    }
}

foreach ($recommended_extensions as $ext => $desc) {
    if (extension_loaded($ext)) {
        check('Extensões PHP (recomendadas)', "$ext — $desc", 'pass', 'Instalada', 'Instalada');
    } else {
        check('Extensões PHP (recomendadas)', "$ext — $desc", 'warn', 'Não encontrada', 'Instalada', "apt install php-$ext");
    }
}

// ── 3. PHP Settings ──────────────────────────────────────────────
$memory_limit = ini_get('memory_limit');
$memory_bytes = wp_convert_to_bytes($memory_limit);
if ((int)$memory_limit === -1) {
    check('Configurações PHP', 'memory_limit', 'pass', $memory_limit . ' (ilimitado)', '>= 256M');
} elseif ($memory_bytes >= 256 * 1024 * 1024) {
    check('Configurações PHP', 'memory_limit', 'pass', $memory_limit, '>= 256M');
} elseif ($memory_bytes >= 128 * 1024 * 1024) {
    check('Configurações PHP', 'memory_limit', 'warn', $memory_limit, '>= 256M (recomendado)', 'Funciona, mas pode ter problemas com plugins pesados');
} else {
    check('Configurações PHP', 'memory_limit', 'fail', $memory_limit, '>= 128M (mínimo)', 'Edite php.ini: memory_limit = 256M');
}

$upload_max = ini_get('upload_max_filesize');
$upload_bytes = wp_convert_to_bytes($upload_max);
if ($upload_bytes >= 64 * 1024 * 1024) {
    check('Configurações PHP', 'upload_max_filesize', 'pass', $upload_max, '>= 64M');
} elseif ($upload_bytes >= 16 * 1024 * 1024) {
    check('Configurações PHP', 'upload_max_filesize', 'warn', $upload_max, '>= 64M (recomendado)', 'Suficiente, mas PDFs grandes podem falhar');
} else {
    check('Configurações PHP', 'upload_max_filesize', 'fail', $upload_max, '>= 16M (mínimo)', 'Edite php.ini: upload_max_filesize = 64M');
}

$post_max = ini_get('post_max_size');
$post_bytes = wp_convert_to_bytes($post_max);
if ($post_bytes >= 64 * 1024 * 1024) {
    check('Configurações PHP', 'post_max_size', 'pass', $post_max, '>= 64M');
} else {
    check('Configurações PHP', 'post_max_size', 'warn', $post_max, '>= 64M', 'Deve ser >= upload_max_filesize');
}

$max_exec = ini_get('max_execution_time');
if ((int)$max_exec >= 120 || (int)$max_exec === 0) {
    check('Configurações PHP', 'max_execution_time', 'pass', $max_exec . 's', '>= 120s');
} elseif ((int)$max_exec >= 30) {
    check('Configurações PHP', 'max_execution_time', 'warn', $max_exec . 's', '>= 120s (recomendado)', 'Pode causar timeout em atualizações');
} else {
    check('Configurações PHP', 'max_execution_time', 'fail', $max_exec . 's', '>= 30s (mínimo)');
}

$max_input = ini_get('max_input_vars');
if ((int)$max_input >= 3000) {
    check('Configurações PHP', 'max_input_vars', 'pass', $max_input, '>= 3000');
} else {
    check('Configurações PHP', 'max_input_vars', 'warn', $max_input, '>= 3000', 'Formulários grandes podem perder dados');
}

// ── 4. Web Server ────────────────────────────────────────────────
$server_software = $_SERVER['SERVER_SOFTWARE'] ?? (function_exists('apache_get_version') ? apache_get_version() : 'CLI');
check('Servidor Web', 'Software', 'pass', $server_software ?: 'Não detectado', 'Apache / Nginx');

if (function_exists('apache_get_modules')) {
    $apache_modules = apache_get_modules();
    $needed_modules = ['mod_rewrite' => 'URLs amigáveis (permalinks)', 'mod_headers' => 'Cabeçalhos HTTP (cache, segurança)', 'mod_expires' => 'Cache de arquivos estáticos'];
    foreach ($needed_modules as $mod => $desc) {
        if (in_array($mod, $apache_modules)) {
            check('Servidor Web', "$mod — $desc", 'pass', 'Ativo', 'Ativo');
        } else {
            check('Servidor Web', "$mod — $desc", 'warn', 'Não detectado', 'Ativo', "a2enmod $mod && systemctl restart apache2");
        }
    }
} else {
    check('Servidor Web', 'Módulos Apache', 'warn', 'Não verificável (Nginx/CLI)', 'mod_rewrite, mod_headers', 'Verifique manualmente se o rewrite está ativo');
}

$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
if ($is_cli) {
    check('Servidor Web', 'HTTPS/SSL', 'warn', 'Não verificável via CLI', 'Ativo', 'Verifique no navegador');
} elseif ($https) {
    check('Servidor Web', 'HTTPS/SSL', 'pass', 'Ativo', 'Ativo');
} else {
    check('Servidor Web', 'HTTPS/SSL', 'warn', 'Inativo', 'Ativo (recomendado)', "Instale certbot: certbot --apache -d seudominio.com");
}

// ── 5. MySQL / MariaDB ───────────────────────────────────────────
$db_ok = false;
if (extension_loaded('mysqli')) {
    $db_host = defined('DB_HOST') ? DB_HOST : 'localhost';
    $db_user = defined('DB_USER') ? DB_USER : 'root';
    $db_pass = defined('DB_PASSWORD') ? DB_PASSWORD : '';
    $db_name = defined('DB_NAME') ? DB_NAME : '';

    // Try loading wp-config constants if not defined
    if (!defined('DB_HOST') && file_exists(__DIR__ . '/wp-config.php')) {
        $config = file_get_contents(__DIR__ . '/wp-config.php');
        preg_match("/define\(\s*'DB_HOST'\s*,\s*'([^']+)'/", $config, $m);
        $db_host = $m[1] ?? 'localhost';
        preg_match("/define\(\s*'DB_USER'\s*,\s*'([^']+)'/", $config, $m);
        $db_user = $m[1] ?? 'root';
        preg_match("/define\(\s*'DB_PASSWORD'\s*,\s*'([^']+)'/", $config, $m);
        $db_pass = $m[1] ?? '';
        preg_match("/define\(\s*'DB_NAME'\s*,\s*'([^']+)'/", $config, $m);
        $db_name = $m[1] ?? '';
    }

    @$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn && !$conn->connect_error) {
        $db_ok = true;
        check('Banco de Dados', 'Conexão MySQL/MariaDB', 'pass', 'Conectado', 'Conectado');

        $db_version = $conn->server_info;
        $is_maria = stripos($db_version, 'MariaDB') !== false;

        if ($is_maria) {
            preg_match('/(\d+\.\d+\.\d+)/', $db_version, $vm);
            $v = $vm[1] ?? '0';
            if (version_compare($v, '10.4', '>=')) {
                check('Banco de Dados', 'Versão MariaDB', 'pass', $db_version, '>= 10.4');
            } else {
                check('Banco de Dados', 'Versão MariaDB', 'warn', $db_version, '>= 10.4 (recomendado)');
            }
        } else {
            if (version_compare($db_version, '5.7', '>=')) {
                check('Banco de Dados', 'Versão MySQL', 'pass', $db_version, '>= 5.7');
            } else {
                check('Banco de Dados', 'Versão MySQL', 'fail', $db_version, '>= 5.7 (mínimo)');
            }
        }

        $charset = $conn->character_set_name();
        if (stripos($charset, 'utf8mb4') !== false || $charset === 'utf8mb4') {
            check('Banco de Dados', 'Charset', 'pass', $charset, 'utf8mb4');
        } else {
            check('Banco de Dados', 'Charset', 'warn', $charset, 'utf8mb4', 'Recomendado para suporte completo a emojis e caracteres especiais');
        }

        $conn->close();
    } else {
        $err = $conn ? $conn->connect_error : 'Extensão mysqli falhou';
        check('Banco de Dados', 'Conexão MySQL/MariaDB', 'fail', "Erro: $err", 'Conectado', 'Verifique credenciais no wp-config.php');
    }
} else {
    check('Banco de Dados', 'Conexão MySQL/MariaDB', 'fail', 'Extensão mysqli ausente', 'Conectado');
}

// ── 6. File System ───────────────────────────────────────────────
$dirs_to_check = [
    'wp-content'          => __DIR__ . '/wp-content',
    'wp-content/uploads'  => __DIR__ . '/wp-content/uploads',
    'wp-content/plugins'  => __DIR__ . '/wp-content/plugins',
    'wp-content/themes'   => __DIR__ . '/wp-content/themes',
    'wp-content/upgrade'  => __DIR__ . '/wp-content/upgrade',
];

foreach ($dirs_to_check as $label => $path) {
    if (!is_dir($path)) {
        check('Sistema de Arquivos', "Diretório $label", 'fail', 'Não existe', 'Existe e gravável', "mkdir -p $path");
    } elseif (is_writable($path)) {
        check('Sistema de Arquivos', "Diretório $label", 'pass', 'Gravável', 'Gravável');
    } else {
        check('Sistema de Arquivos', "Diretório $label", 'fail', 'Somente leitura', 'Gravável', "chmod 755 $path && chown www-data:www-data $path");
    }
}

$disk_free = disk_free_space(__DIR__);
$disk_total = disk_total_space(__DIR__);
$disk_free_mb = round($disk_free / 1024 / 1024);
$disk_pct = round(($disk_free / $disk_total) * 100, 1);

if ($disk_free_mb >= 500) {
    check('Sistema de Arquivos', 'Espaço livre em disco', 'pass', "{$disk_free_mb} MB ({$disk_pct}% livre)", '>= 500 MB');
} elseif ($disk_free_mb >= 100) {
    check('Sistema de Arquivos', 'Espaço livre em disco', 'warn', "{$disk_free_mb} MB ({$disk_pct}% livre)", '>= 500 MB', 'Espaço baixo, monitore o disco');
} else {
    check('Sistema de Arquivos', 'Espaço livre em disco', 'fail', "{$disk_free_mb} MB ({$disk_pct}% livre)", '>= 100 MB', 'Disco quase cheio!');
}

// ── 7. Network / cURL ────────────────────────────────────────────
if (function_exists('curl_version')) {
    $curl_info = curl_version();
    check('Rede', 'cURL', 'pass', 'v' . $curl_info['version'], 'Instalado');

    $ssl_ok = !empty($curl_info['ssl_version']);
    if ($ssl_ok) {
        check('Rede', 'cURL SSL', 'pass', $curl_info['ssl_version'], 'Ativo');
    } else {
        check('Rede', 'cURL SSL', 'fail', 'Sem suporte SSL', 'Ativo', 'Necessário para atualizações e APIs externas');
    }
} else {
    check('Rede', 'cURL', 'fail', 'Não instalado', 'Instalado', 'apt install php-curl');
}

// Test external connectivity
if (function_exists('curl_init')) {
    $ch = curl_init('https://api.wordpress.org');
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10, CURLOPT_NOBODY => true]);
    curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err = curl_error($ch);
    curl_close($ch);

    if ($http_code >= 200 && $http_code < 400) {
        check('Rede', 'Conectividade externa (api.wordpress.org)', 'pass', "HTTP $http_code", 'Acessível');
    } else {
        check('Rede', 'Conectividade externa (api.wordpress.org)', 'warn', $err ?: "HTTP $http_code", 'Acessível', 'Pode impedir atualizações automáticas');
    }
}

if (function_exists('stream_get_wrappers') && in_array('https', stream_get_wrappers())) {
    check('Rede', 'allow_url_fopen (HTTPS streams)', 'pass', ini_get('allow_url_fopen') ? 'Ativo' : 'Inativo', 'Ativo');
} else {
    check('Rede', 'allow_url_fopen (HTTPS streams)', 'warn', 'Inativo', 'Ativo', 'Necessário para algumas operações HTTP');
}

// ── 8. WordPress Files ───────────────────────────────────────────
$wp_files = ['wp-config.php', 'wp-load.php', 'wp-settings.php', 'wp-cron.php', '.htaccess'];
foreach ($wp_files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        check('Arquivos WordPress', $file, 'pass', 'Existe', 'Existe');
    } elseif ($file === '.htaccess') {
        check('Arquivos WordPress', $file, 'warn', 'Não encontrado', 'Existe', 'Necessário para permalinks no Apache');
    } else {
        check('Arquivos WordPress', $file, 'fail', 'Não encontrado', 'Existe');
    }
}

// ═══════════════════════════════════════════════════════════════════
// Helper
// ═══════════════════════════════════════════════════════════════════
function wp_convert_to_bytes($value) {
    $value = trim($value);
    $num = (float) $value;
    $unit = strtolower(substr($value, -1));
    switch ($unit) {
        case 'g': $num *= 1024;
        case 'm': $num *= 1024;
        case 'k': $num *= 1024;
    }
    return (int) $num;
}

// ═══════════════════════════════════════════════════════════════════
// Output
// ═══════════════════════════════════════════════════════════════════
if ($is_cli) {
    // ── CLI Output ──
    echo "\n";
    echo "╔══════════════════════════════════════════════════════════════╗\n";
    echo "║          SERVER REQUIREMENTS CHECK — CERTIFY                ║\n";
    echo "╚══════════════════════════════════════════════════════════════╝\n\n";

    foreach ($results as $category => $checks) {
        echo "── $category " . str_repeat('─', max(1, 56 - strlen($category))) . "\n";
        foreach ($checks as $c) {
            $icon = $c['status'] === 'pass' ? '✅' : ($c['status'] === 'warn' ? '⚠️ ' : '❌');
            echo "  $icon {$c['label']}\n";
            echo "     Atual: {$c['current']}  |  Esperado: {$c['expected']}\n";
            if ($c['hint']) echo "     💡 {$c['hint']}\n";
        }
        echo "\n";
    }

    echo "── Resumo " . str_repeat('─', 50) . "\n";
    echo "  ✅ Passou: $total_pass   ⚠️  Avisos: $total_warn   ❌ Falhas: $total_fail\n\n";

    if ($total_fail === 0) {
        echo "  🎉 Servidor OK para rodar o site!\n\n";
    } else {
        echo "  🚨 Corrija as falhas acima antes de prosseguir.\n\n";
    }

} else {
    // ── HTML Output ──
    header('Content-Type: text/html; charset=utf-8');
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Server Check — Certify</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f0f2f5; color: #333; padding: 30px; }
            .container { max-width: 900px; margin: 0 auto; }
            h1 { text-align: center; color: #223254; margin-bottom: 8px; font-size: 1.8rem; }
            .subtitle { text-align: center; color: #666; margin-bottom: 30px; }
            .category { background: #fff; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); overflow: hidden; }
            .category-title { background: #223254; color: #fff; padding: 12px 20px; font-size: 1rem; font-weight: 600; }
            .check-row { display: flex; align-items: center; padding: 10px 20px; border-bottom: 1px solid #f0f0f0; gap: 12px; }
            .check-row:last-child { border-bottom: none; }
            .check-icon { font-size: 1.2rem; flex-shrink: 0; width: 28px; text-align: center; }
            .check-info { flex: 1; }
            .check-label { font-weight: 500; font-size: 0.95rem; }
            .check-detail { font-size: 0.8rem; color: #888; margin-top: 2px; }
            .check-hint { font-size: 0.8rem; color: #0068ff; margin-top: 2px; }
            .summary { text-align: center; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
            .summary .stats { display: flex; justify-content: center; gap: 40px; margin: 16px 0; font-size: 1.1rem; }
            .stat-pass { color: #2e7d32; } .stat-warn { color: #e65100; } .stat-fail { color: #c62828; }
            .result-ok { color: #2e7d32; font-size: 1.3rem; font-weight: 700; }
            .result-fail { color: #c62828; font-size: 1.3rem; font-weight: 700; }
            .badge { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 0.75rem; font-weight: 600; }
            .badge-pass { background: #e8f5e9; color: #2e7d32; } .badge-warn { background: #fff3e0; color: #e65100; } .badge-fail { background: #ffebee; color: #c62828; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🔍 Server Requirements Check</h1>
            <p class="subtitle">Validação de requisitos — Certify WordPress</p>

            <?php foreach ($results as $category => $checks): ?>
            <div class="category">
                <div class="category-title"><?php echo htmlspecialchars($category); ?></div>
                <?php foreach ($checks as $c):
                    $icon = $c['status'] === 'pass' ? '✅' : ($c['status'] === 'warn' ? '⚠️' : '❌');
                    $badge = $c['status'] === 'pass' ? 'badge-pass' : ($c['status'] === 'warn' ? 'badge-warn' : 'badge-fail');
                    $badge_text = $c['status'] === 'pass' ? 'OK' : ($c['status'] === 'warn' ? 'AVISO' : 'FALHA');
                ?>
                <div class="check-row">
                    <span class="check-icon"><?php echo $icon; ?></span>
                    <div class="check-info">
                        <div class="check-label"><?php echo htmlspecialchars($c['label']); ?> <span class="badge <?php echo $badge; ?>"><?php echo $badge_text; ?></span></div>
                        <div class="check-detail">Atual: <strong><?php echo htmlspecialchars($c['current']); ?></strong> &nbsp;|&nbsp; Esperado: <?php echo htmlspecialchars($c['expected']); ?></div>
                        <?php if ($c['hint']): ?><div class="check-hint">💡 <?php echo htmlspecialchars($c['hint']); ?></div><?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

            <div class="summary">
                <div class="stats">
                    <span class="stat-pass">✅ Passou: <?php echo $total_pass; ?></span>
                    <span class="stat-warn">⚠️ Avisos: <?php echo $total_warn; ?></span>
                    <span class="stat-fail">❌ Falhas: <?php echo $total_fail; ?></span>
                </div>
                <?php if ($total_fail === 0): ?>
                    <div class="result-ok">🎉 Servidor pronto para rodar o site!</div>
                <?php else: ?>
                    <div class="result-fail">🚨 Corrija as <?php echo $total_fail; ?> falha(s) antes de prosseguir.</div>
                <?php endif; ?>
            </div>
        </div>
    </body>
    </html>
    <?php
}
