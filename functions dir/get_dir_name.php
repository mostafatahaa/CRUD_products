<?php

function randomName($n)
{
    $char = '123456789zxcvbnmlkjhgfdsaqwertyuiopZXCVBNMLKJHGFDSAQWERTYUIOP';
    $res = '';
    for ($i = 0; $i < $n; $i++) {
        $randomChar = rand(0, strlen($char) - 1);
        $res .= $char[$randomChar];
    }
    return $res;
}
