<?php

declare(strict_types=1);

use App\Svf16\OutputTable;

require_once __DIR__ . '/../../vendor/autoload.php';

$builder = new OutputTable();

$builder
    ->setHeaders(['PHP', 'Golang', 'JavaScript'])
    ->addRow(['1', 2, 3])
    ->addRow(['qwerty yuiop', 2, 3]);

$standardTable = $builder->build();

echo $standardTable;
