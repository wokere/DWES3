<?php
    
if (!function_exists('url')) {
    function url($segmento)
    {
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
        return $protocolo.'://'.$_SERVER['HTTP_HOST'].$segmento;
    }
}
