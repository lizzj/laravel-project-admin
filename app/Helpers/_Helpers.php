<?php
/**
 * @note:
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:00
 */
$helpers = [
    'Address.php',
    'Array.php',
    'Image.php',
    'Other.php',
    'Time.php',
    'File.php',
    'Number.php'
];

foreach ($helpers as $helperFileName) {
    include __DIR__ . '/' . 'Custom_' . $helperFileName;
}
