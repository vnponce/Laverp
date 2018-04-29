<?php

function toFloat($num, $decimals = 2) {
    $dotPos = strrpos($num, '.');
    $commaPos = strrpos($num, ',');

    if (! $dotPos && ! $commaPos) {
        return $num;
    }
    if ($dotPos && ! $commaPos) {
        if (strlen($num) - $dotPos > $decimals + 1){
            return str_replace(".","",$num);
        }
        return floatval($num);
    }
    $num = str_replace(".","",$num);
    $num = str_replace(",",".",$num);

    return floatval($num);
}

function toCents($num) {
    if (!$num) $num = 0;
    return toFloat($num)  * 100;
}

function toFormat($price){
    return number_format($price / 100,2,'.',',');
}

function toThousand($num) {
    if (!$num) $num = 0;
    return toFloat($num, 3)  * 1000;
}
