<?php
    
if (!function_exists('url')) {
    function url($segmento)
    {
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
        return $protocolo.'://'.$_SERVER['HTTP_HOST'].$segmento;
    }
}
if(!function_exists('linksHATEOAS')){
    function linksHATEOAS($url,$rel){
          return [
            ["rel"=>$rel,"href"=>$url,"action"=>"GET","types"=>["text/xml","application/json"]],
            ["rel"=>$rel,"href"=>$url,"action"=>"PUT","types"=>["application/x-www-form-encoded"]],
            ["rel"=>$rel,"href"=>$url,"action"=>"PATCH","types"=>["application/x-www-form-encoded"]],
            ["rel"=>$rel,"href"=>$url,"action"=>"DELETE","types"=>["application/x-www-form-encoded"]]
        ];
    }
}

?>