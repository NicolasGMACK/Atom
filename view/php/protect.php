<?php
if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['id'])){
    die("<!DOCTYPE html>
<html lang=\"pt-br\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <style type=\"text/css\">
    body{
    background: #8c52ff;
    font: normal 15pt Arial;
}
header{
    color: white;
    text-align: center;
}
section{
    background: white;
    border-radius: 10px;
    padding: 15px;
    width: 500px;
    margin: auto;
    box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.329);
}
footer{
    color: white;
    text-align: center;
    font-style: italic;
}
    </style>
    <title>Faça login</title>
</head>
<body>
    <header>
        <h1>Faça login</h1>
    </header>

    <section>
        <div>
            <p>Você não pode acessar está página, pois não está logado no momento</p>
        </div>
        <div>
        <p><a href=\"login-real.php\">Entrar</a></p>
        </div>

    </section>
    
    <footer>
        <p>&copy; Atom</p>
    </footer>
</body>
</html>");
}

?>