<?php
function waf($input) {

    // 移除或转义潜在的XSS攻击字符
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');

    // 移除多余的空白字符
    $input = trim($input);

    // 可选：移除或转义其他特殊字符
    $input = preg_replace("/[ \"']|\b(?:union|information|order|select)\b/i", '', $input);
    // 或者使用preg_replace_callback进行更复杂的替换

    return $input;
}
