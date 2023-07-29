<?php

/*
 * php-cs-fixer fix --using-cache=no --diff --config=php-cs-fixer.php --dry-run --allow-risky=yes --ansi
 *
 * --using-cache=no: 禁用缓存，每次运行都重新扫描所有文件。
 * --diff: 在修复前显示差异。
 * --config=php-cs-fixer.php：指定使用的配置文件路径
 * --dry-run：模拟运行，不进行实际的修复操作，只会输出需要修复的文件列表。
 * --allow-risky=yes：允许使用不安全的规则进行修复。
 * --ansi：使用 ANSI 色彩输出修复结果。
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'EOF'
    This file is part of the flower-allure/composer-utils.
    (c) flower-allure <i@flower-allure.me>
    This source file is subject to the LGPL license that is bundled.
    EOF;

$rules = [
    '@PSR12' => true,
    '@Symfony' => true,
    '@PHP82Migration' => true,
    '@PhpCsFixer' => true,
    // PHP UNIT 使用
    'php_unit_strict' => false,
    'php_unit_internal_class' => false,
    'php_unit_test_class_requires_covers' => false,
    'php_unit_test_case_static_method_calls' => [
        'call_type' => 'this',
    ],
    // PHP 通用
    'self_accessor' => true, // 在当前类中使用 self 代替类名
    'concat_space' => ['spacing' => 'one'], // 连接运算符的间距
    'simplified_if_return' => true, // 简单的 return
    'combine_nested_dirname' => true, // 多个嵌套的dirname调用 $level参数
    'dir_constant' => true, // __DIR__常量替换 dirname(__FILE__)
    'modernize_types_casting' => true, // 替换 intval、floatval、doubleval、strval 和 boolval 使用根据类型转换运算符的函数调用。
    'function_to_constant' => true, // 用常量替换核心函数调用返回常量
    'phpdoc_types_order' => [ // Sorts PHPDoc types
        'null_adjustment' => 'always_last',
        'sort_algorithm' => 'none',
    ],
    'global_namespace_import' => [ // \ 命名空间换成 use
        'import_classes' => true,
        'import_constants' => true,
        'import_functions' => true,
    ],
];

$finder = Finder::create()
    ->exclude('*/vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->in(__DIR__)
;

return (new Config())
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setFinder($finder)
;
