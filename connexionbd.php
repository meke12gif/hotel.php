<?php
$bd="hotel";
$user="root";
$pwd="";

try{
    
    $bdd = new PDO('mysql:host=127.0.0.1;dbname='.$bd.';charset=utf8',$user,$pwd); 
    }catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    ?>