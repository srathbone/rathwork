<?php

declare(strict_types=1);

if (php_sapi_name() === 'cli-server') {
    if (preg_match('/\.(?:css|js|png|jpg|jpeg|gif|ico)$/', $_SERVER['REQUEST_URI'])) {
        // serve the requested resource as is
        return false;
    }
}

require __DIR__ . '/../src/bootstrap.php';
