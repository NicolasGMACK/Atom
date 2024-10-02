<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'atom';

$conection = new mysqli($host, $username, $password, $database); 
if($conection->error){
    die("Falha ao conectar com o banco de dados". $conection->error);
}else{
    //print("Conexão realizada com sucesso");
}

?>