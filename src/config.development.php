<?php

/**
 * PHPMaker 2023 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "localhost", "port" => "3306", "user" => "root", "password" => "", "dbname" => "db_newsimpel"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "simpel.uncen.ac.id", // SMTP server
        "SERVER_PORT" => 465, // SMTP server port
        "SECURE_OPTION" => "ssl",
        "SERVER_USERNAME" => "admin@simpel.uncen.ac.id", // SMTP server user name
        "SERVER_PASSWORD" => "*L6CrZl&0;*Z", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "Frm85IUzNt0VxcSb", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
