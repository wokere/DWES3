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
if(!function_exists('trimStringArray')){
    function trimStringArray($array){
        $tmpArr = [];
        foreach ($array as $key=>$value){
            if(is_string($value) ){
                $tmpArr[$key] = trim($value);
            }
        }
        return $tmpArr;
    }
}
/*function trimEmAll($array){
    foreach($array as $key=>$value){
        if(is_array($value)){
            trimEmAll($value);
        }else{
            $array[$key] = trim($value);
        }
    }
    return $array;
}*/

?>