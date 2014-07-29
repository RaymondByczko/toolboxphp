<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author raymond
 */
// TODO: check include path
//ini_set('include_path', ini_get('include_path'));

// put your code here
echo 'bootstrap.php';
ini_set('suhosin.executor.include.whitelist','phar');
ini_set('xdebug.idekey', 'netbeans-xdebug');
ini_set('xdebug.remote_enable', 'On');
ini_set('xdebug.remote_handler', 'dbgp');
ini_set('xdebug.remote_mode', 'req');
ini_set('xdebug.remote_host', 'localhost');
ini_set('xdebug.remote_port', '9001');
putenv("DEBUG_CONFIG='idekey=netbeans-xdebug'");
?>
