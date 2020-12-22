<?php
// NOTE: these values get replaced during deployment
$db_name = REPL_DB_NAME;
$db_host = REPL_DB_HOST;
$db_user = REPL_DB_USER;
$db_pwd  = REPL_DB_PWD;
return [
    'db_config' => [
        'dsn'     => 'mysql:host=' . $db_host . ';dbname=' . $db_name,
        'db_name' => $db_name,
        'db_host' => $db_host,
        'db_user' => $db_user,
        'db_pwd'  => $db_pwd,
    ],
];

