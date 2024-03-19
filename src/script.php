<?php

declare(strict_types=1);

use App\CommissionTask\Models\Operation;
use App\CommissionTask\Services\CommissionService;

require __DIR__.'/../vendor/autoload.php';

$filePath = $argv[1];
$operations = (new CommissionService())->calculateFees($filePath);
/** @var Operation $operation */
foreach ($operations as $operation) {
    echo $operation->getFee()->getAmount().PHP_EOL;
}
