<?php

// Normalizar cadena
function normalize_string($str) {
    $str = mb_strtolower($str);
    $str = preg_replace('/[^a-z0-9áéíóúñü\s-]/', '', $str);
    $str = trim(preg_replace('/[\s-]+/', '-', $str));
    return $str;
}

// Truncar texto
function truncate_text($text, $max = 50, $append = '...') {
    if (mb_strlen($text) <= $max) {
        return $text;
    }
    return mb_substr($text, 0, $max) . $append;
}
