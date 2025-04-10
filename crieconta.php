<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ateliê Aline Nacur - Criar Conta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    <style>
        body {
            background-color: #fce4ec; /* Fundo rosa */
        }
        .btn-custom {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        .btn-custom:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }
    </style>
    <?php include 'styleCabelho.php'; ?>
</head>

<body>
<?php include 'cabecalho.php'; ?>
<br>
<div id="imagem2">
    <a href='home.php'> <i class="fa-solid fa-arrow-left-long fa-2xl" style='margin-left:20px; font-size:20px'> voltar </i> </a>
</div>

<div class="card-login">
    <div class="card">
        <div class="card-header">
            Crie uma conta!
        </div>
        <div class="card-body">
            <form action="criandoconta.php" method="post">
                <div class="form-group">
                    <input name="nome" type="text" class="form-control" placeholder="Nome" required>
                </div>
                <div class="form-group">
                    <input name="email" type="email" class="form-control" placeholder="E-mail" required>
                </div>
                <div class="form-group">
                    <input name="senha" type="password" class="form-control" placeholder="Senha" required>
                </div>
                <div class="form-group">
                    <input name="confirmar_senha" type="password" class="form-control" placeholder="Confirmar senha" required>
                </div>

                <?php if (isset($_GET['erro'])) { ?>
                    <div class="text-danger">
                        <?php
                        if ($_GET['erro'] == 'senha') {
                            echo 'As senhas não coincidem.';
                        } elseif ($_GET['erro'] == 'email') {
                            echo 'Esse Email já está cadastrado.';
                        } elseif ($_GET['erro'] == 'senha_forte') {
                            echo 'A senha deve ter pelo menos 8 caracteres e incluir letras maiúsculas, minúsculas, números e caracteres especiais.';
                        }
                        ?>
                    </div>
                <?php } ?>

                <button id='bottom2' class="btn btn-lg btn-info btn-block" type="submit">Criar!</button>
            </form>
            <br>
            <div id='criar'> 
                Já possui uma conta?
                <br>
                <a href='login.php' id='login'> Entre agora! </a>
            </div>
        </div>
    </div>
</div>
<?php include 'rodape.html'; ?>
</body>
</html>