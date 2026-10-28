<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/application',
        __DIR__ . '/extend',
        __DIR__ . '/public',
        __DIR__ . '/thinkphp',
    ])
    // 目标 PHP 8.2：应用 PHP 5.3 → 8.2 的全部升级规则集
    // 注意：命名参数语法需在 PHP 8.x CLI 下运行（如 WSL 中的 php），PHP 7.4 CLI 无法解析
    ->withPhpSets(php82: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
