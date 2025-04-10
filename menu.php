<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
    font-family: Arial, sans-serif; /* Fonte padrão */
    margin: 0;
    padding: 0;
    background-color: #fce4ec; /* Fundo rosa */
}

#menuu {
    background-color: #fe48aa; /* Cor de fundo do menu */
    color: white; /* Cor do texto */
    padding: 20px; /* Espaçamento interno */
    border-radius: 10px; /* Cantos arredondados */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Sombra */
    width: 200px; /* Largura do menu */
    position: fixed; /* Mantém o menu fixo na tela */
    top: 50px; /* Distância do topo */
    left: 20px; /* Distância da esquerda */
    z-index: 1000; /* Fica acima de outros elementos */
}

#menuu h1 {
    margin: 0 0 20px; /* Margem do título */
    font-size: 24px; /* Tamanho da fonte do título */
}

#sair {
    padding: 0; /* Remove o padding */
}

.menu {
    list-style-type: none; /* Remove marcadores da lista */
    padding: 0; /* Remove padding da lista */
}

.menu .men {
    display: block; /* Faz links ocuparem toda a largura */
    padding: 10px 15px; /* Espaçamento interno dos links */
    color: white; /* Cor do texto dos links */
    text-decoration: none; /* Remove o sublinhado */
    border-radius: 5px; /* Cantos arredondados nos links */
    transition: background-color 0.3s; /* Transição suave para o fundo */
}

.menu .men:hover {
    background-color: rgba(255, 255, 255, 0.2); /* Cor de fundo ao passar o mouse */
}

.menu .men:active {
    background-color: rgba(255, 255, 255, 0.4); /* Cor de fundo ao clicar */
}

/* Estilo para links de conta e logoff */
.menu .men:last-child {
    margin-top: 20px; /* Espaçamento superior no último link */
}

    </style>
    <div id="menuu" popover>
        <h1> MENU </h1>
        <div id="sair">    
            <ul class="menu">
                <li class="men">
                    <a href="prod_Mochilas.php" class="men">Mochilas</a>
                    <a href="prod_Estojos.php" class="men">Estojos</a>
                    <a href="prod_Chaveiros.php" class="men">Chaveiros</a>
                    <a href="prod_Necessaire.php" class="men">Necessaire</a>
                    <a href="prod_lancheira.php" class="men">Lancheiras</a>
                    <a href="prod_Bolsas.php" class="men">Bolsas</a>
    
                    <?php if($usuario_autenticado): ?> 
                        <a href="minhaconta.php" class="men">Minha Conta!</a>
                        <div><a href='logoff.php' class='men'>Sair</a></div> 
                    <?php else: ?>
                        <a href='login.php' class='men'>Logar</a>
                    <?php endif;?>
                </li>
            </ul>
        </div>
    </div>
</head>
<body>
    
</body>
</html>
