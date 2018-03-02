<?php
spl_autoload_register(function($theclass) {
/** Valid debugging but removed for production. **/
/**
echo 'theclass='.$theclass."\n";
**/
$adjusted = str_replace('\\','/',$theclass);
/**
echo 'adjusted='.$adjusted."\n";
**/
$include_this = __DIR__.'/../'.$adjusted.'.php';
/**
echo 'include_this:'.$include_this."\n";
**/
include($include_this);
});
?>
