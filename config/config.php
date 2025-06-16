<?php
// Configurações gerais
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);

// Configurações de timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurações de upload
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');

// Configurações de memória
ini_set('memory_limit', '256M');

// Configurações de tempo de execução
set_time_limit(300); // 5 minutos
?> 