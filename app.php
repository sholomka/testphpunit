<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use App\Commission;

(new Dotenv(true))->loadEnv(__DIR__ . '/.env');
(new Commission())->calculate($argv);
