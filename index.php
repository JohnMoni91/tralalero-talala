<?php
include 'db.php';

$sql = "SELECT * FROM produtos ORDER BY pedidos DESC LIMIT 10";

// Array de categorias e suas respectivas consultas SQL
$categorias = [
    'Mochilas' => "SELECT * FROM produtos WHERE categoria = 'Mochilas' ORDER BY pedidos DESC LIMIT 10",
    'Estojos' => "SELECT * FROM produtos WHERE categoria = 'Estojos' ORDER BY pedidos DESC LIMIT 10",
    'Chaveiros' => "SELECT * FROM produtos WHERE categoria = 'Chaveiros' ORDER BY pedidos DESC LIMIT 10",
    'Necessaire' => "SELECT * FROM produtos WHERE categoria = 'Necessaire' ORDER BY pedidos DESC LIMIT 10",
    'Lancheiras' => "SELECT * FROM produtos WHERE categoria = 'Lancheira' ORDER BY pedidos DESC LIMIT 10",
    'Bolsas' => "SELECT * FROM produtos WHERE categoria = 'Bolsas' ORDER BY pedidos DESC LIMIT 10"
];

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Ateliê Aline Nacur</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href='style.css'>
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    <style>
        .carousel-inner {
            display: flex; /* Faz o container flexível */
            justify-content: center; /* Centraliza horizontalmente */
            align-items: center; /* Centraliza verticalmente */
        }

        .card1 {
            border: none; /* Remove a borda da carta */
            transition: transform 0.3s; /* Efeito de transição suave ao passar o mouse */
        }

        .card1:hover {
            transform: scale(1.05); /* Aumenta o tamanho ao passar o mouse */
        }


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
</head>

<body>
<?php 
include 'cabecalho.php';
include 'homeaqui.php';
?>

<div id="carouselProdutos" class="carousel slide mt-4" data-ride="carousel">
    <h2 class="text-center">OS MAIS PEDIDOS</h2> <!-- Centraliza o título -->
    <div class="carousel-inner">
        <?php
        $itemIndex = 0; // Para controlar o índice do carousel-item
        $totalItems = $result->num_rows; // Total de produtos
        $productsPerSlide = 4; // Número de produtos por slide

        if ($totalItems > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($itemIndex % $productsPerSlide === 0) {
                    // Inicia um novo item do carrossel
                    if ($itemIndex > 0) {
                        echo "</div>"; // Fecha o item anterior
                    }
                    echo "<div class='carousel-item " . ($itemIndex === 0 ? "active" : "") . "'>";
                    echo "<div class='d-flex justify-content-center flex-wrap'>"; // Flexbox para centralização
                }

                // Captura os dados do produto
                $id = $row['id'];
                $nome = htmlspecialchars($row["nome"]);
                $foto = htmlspecialchars($row["foto"]);
                $foto_url = "uploads/" . $foto;
                $nomeM = ucfirst($nome);

                // Exibe o produto
                echo "
                <div class='col-md-3 mb-4 d-flex justify-content-center'> <!-- Cada produto ocupa 3 colunas em uma linha -->
                    <a href='visualizar_produto.php?id=$id'>
                        <div class='cards card1'>
                            <img src='$foto_url' height='300px' width='300px' alt='$nome' class='img-fluid'> <!-- img-fluid para responsividade -->
                            <p class='text'> $nomeM </p> <!-- Centraliza o texto -->
                        </div>
                    </a>
                </div>
                ";

                $itemIndex++;
            }
            echo "</div>"; // Fecha o último d-flex
            echo "</div>"; // Fecha o último item
        } else {
            echo "<p>Nenhum produto encontrado.</p>";
        }
        ?>
    </div>

    <!-- Controles do carrossel -->
    <a class="carousel-control-prev" href="#carouselProdutos" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#carouselProdutos" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Próximo</span>
    </a>
</div> <!-- Fecha o carrossel de produtos -->

<?php
// Iterar sobre cada categoria
foreach ($categorias as $categoria => $sql) {
    $result = $conn->query($sql);
    echo "<div id='carousel{$categoria}' class='carousel slide mt-4' data-ride='carousel'>";
    echo "<h2 class='text-center'>{$categoria}</h2>"; // Título da categoria
    echo "<div class='carousel-inner'>";

    $itemIndex = 0; // Para controlar o índice do carousel-item
    $totalItems = $result->num_rows; // Total de produtos
    $productsPerSlide = 4; // Número de produtos por slide

    if ($totalItems > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($itemIndex % $productsPerSlide === 0) {
                // Inicia um novo item do carrossel
                if ($itemIndex > 0) {
                    echo "</div>"; // Fecha o item anterior
                }
                echo "<div class='carousel-item " . ($itemIndex === 0 ? "active" : "") . "'>";
                echo "<div class='d-flex justify-content-center flex-wrap'>"; // Flexbox para centralização
            }

            // Captura os dados do produto
            $id = $row['id'];
            $nome = htmlspecialchars($row["nome"]);
            $foto = htmlspecialchars($row["foto"]);
            $foto_url = "uploads/" . $foto;
            $nomeM = ucfirst($nome);

            // Exibe o produto
            echo "
            <div class='col-md-3 mb-4 d-flex justify-content-center'> <!-- Cada produto ocupa 3 colunas em uma linha -->
                <a href='visualizar_produto.php?id=$id'>
                    <div class='cards card1'>
                        <img src='$foto_url' height='300px' width='300px' alt='$nome' class='img-fluid'> <!-- img-fluid para responsividade -->
                        <p class='text'> $nomeM </p> <!-- Centraliza o texto -->
                    </div>
                </a>
            </div>
            ";

            $itemIndex++;
        }
        echo "</div>"; // Fecha o último d-flex
        echo "</div>"; // Fecha o último item
    } else {
        echo "<p>Nenhum produto encontrado.</p>";
    }

    // Controles do carrossel
    echo "<a class='carousel-control-prev' href='#carousel{$categoria}' role='button' data-slide='prev'>";
    echo "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Anterior</span>";
    echo "</a>";
    echo "<a class='carousel-control-next' href='#carousel{$categoria}' role='button' data-slide='next'>";
    echo "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
    echo "<span class='sr-only'>Próximo</span>";
    echo "</a>";
    echo "</div>"; // Fecha o carrossel da categoria
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<?php include 'rodape.html'; ?>
</body>
</html>
