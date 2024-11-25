<?php
    require '../connectios/ConnectionData.php';
    require 'mysqldump.php';

    $mysqldump = new MySql($host,$dbname,$user,$pass);
    $file_to_load = 'sisfran.sql';
    $mysqldump->backup_tables();
?>