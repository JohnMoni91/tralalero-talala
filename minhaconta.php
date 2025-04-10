<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

$sql ='SELECT * FROM login_clientes';

$result = $conn->query($sql);




?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    <style>
        #atu {
            background-color: #ec407a; /* Cor rosa para os itens do menu */
            border: none; /* Remove a borda */
        }
            
        body {
            background-color: #fce4ec; /* Cor de fundo rosa claro */
        }
        .list-group-item {
            background-color: #f8bbd0; /* Cor rosa para os itens do menu */
            border: none; /* Remove a borda */
        }
        .list-group-item.active {
            background-color: #ec407a; /* Cor rosa mais escura para o item ativo */
            color: white; /* Texto em branco para contraste */
        }
        .form-control {
            background-color: #fff; /* Cor de fundo branca para os campos */
            border: 1px solid #ec407a; /* Borda rosa */
        }
        .btn-primary {
            background-color: #ec407a; /* Cor do botão rosa */
            border: none; /* Remove a borda */
        }
        .btn-primary:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
        }


    </style>
</head>

<body>
    <?php include "cabecalho.php"; ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href='meusdados.php' class='list-group-item list-group-item-action active'>MEUS DADOS</a>
                    <a href='meus_pedidos.php' class='list-group-item list-group-item-action'>MEUS PEDIDOS</a>
                    <a href='listadedesejos.php' class='list-group-item list-group-item-action'>MEUS FAVORITOS</a>
                    <a href='endereco.php' class='list-group-item list-group-item-action'>ENDEREÇOS</a>
                </div>
            </div>

    

                    <p class='bemvindo'> Seja bem vindo(a)!</p>

</div>

    <a class="logoffgg" href="logoff.php">Sair</a>


    <?php
        include 'rodape.html'; 
    ?>
</body>
</html>