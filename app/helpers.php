<?php

function layout()
{
    return \Request::is('admin/*') ? 'layouts.admin' : 'layouts.app';
}

function isAdmin()
{
    return \Request::is('admin/*') ? true : false;
}

function encodeBase64($texto)
{
    return  isset($texto) ? base64_encode($texto) : null;
}

function decodeBase64($texto)
{
    return  isset($texto) ? base64_decode($texto) : null;
}

function mask(String $mask, String $str) {
    $str = str_replace(" ","",$str);

    for($i=0;$i<strlen($str);$i++)
        $mask[strpos($mask,"#")] = $str[$i];

    return $mask;
}

function mask_cpf(String $str) {
    return mask("###.###.###-##", $str);
}