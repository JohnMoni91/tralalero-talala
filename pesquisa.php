<?php
include 'db.php'; // Certifique-se de que este arquivo define a variável $conn para a conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Ateliê Aline Nacur</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href='style.css'>
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

<div id="conteiner1" class="container my-5">

<?php
if (isset($_GET['query'])) {
    $pesquisa = $_GET['query'];

    // Consulta para buscar os produtos com base no termo de pesquisa
    $sql = "SELECT * FROM produtos WHERE nome LIKE ? OR descricao LIKE ?";
    $stmt = $conn->prepare($sql);

    // Verifica se a consulta foi preparada corretamente
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    $pesquisa_param = '%' . $pesquisa . '%';
    $stmt->bind_param('ss', $pesquisa_param, $pesquisa_param);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Exibe os resultados
    if ($resultado->num_rows > 0) {
        echo "
        <h1 class='text-center mb-4'>Resultados da Pesquisa</h1>
        <div class='row justify-content-center'>";
        
        while ($produto = $resultado->fetch_assoc()) {
            $nome = htmlspecialchars($produto['nome']);
            //$descricao = htmlspecialchars($produto['descricao']);
            $preco = htmlspecialchars($produto['preco']);
            $foto = htmlspecialchars($produto['foto']);
            $foto_url = "uploads/" . $foto;

            echo "
            <div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
                <div class='card produto-card'>
                    <img class='card-img-top' src='$foto_url' alt='$nome'>
                    <div class='card-body d-flex flex-column'>
                        <h5 class='card-title text-center'>$nome</h5>
                        <p class='card-text produto-descricao text-muted'>$descricao</p>
                        <div class='mt-auto'>
                            <p class='card-text produto-preco text-center'><strong>R$ $preco</strong></p>
                            <a href='visualizar_produto.php?id={$produto['id']}' class='btn btn-primary btn-block'>Ver detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
            ";
        }
        echo "
        </div> <!-- Fechando row -->";
    } else {
        echo "<h1 class='text-center my-4'>Nenhum produto encontrado para '$pesquisa'</h1>";
    }

    // Fecha a conexão
    $stmt->close();
    $conn->close();
} else {
    echo "<div class='alert alert-warning text-center'>Nenhum termo de pesquisa foi fornecido.</div>";
}
?>

</div> <!-- Fechando conteiner1 -->

<?php include 'rodape.html'; ?>

</body>
</html>