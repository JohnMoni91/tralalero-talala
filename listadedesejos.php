<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Inicializar a variável $wishlist_message e $is_wishlist_empty
$wishlist_message = '';
$is_wishlist_empty = true;

if (isset($_SESSION['wishlist']) && !empty($_SESSION['wishlist'])) {
    $is_wishlist_empty = false;
}

// Adicionar produto à lista de desejos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Verificar se o produto existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $produto = $result->fetch_assoc();

        if (!isset($_SESSION['wishlist'])) {
            $_SESSION['wishlist'] = array();
        }

        if (!isset($_SESSION['wishlist'][$id])) {
            $_SESSION['wishlist'][$id] = array(
                'id' => $id,
                'nome' => $produto['nome'],
                'preco' => $produto['preco']
            );

            $_SESSION['wishlist_message'] = "Produto adicionado à lista de desejos!";
        } else {
            $_SESSION['wishlist_message'] = "Produto já está na lista de desejos.";
        }

        header('Location: listadedesejos.php');
        exit();
    } else {
        die("Produto não encontrado.");
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Desejos</title>
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

#caro, #remo {
    background-color: #ec407a; /* Cor do botão */
    border-color: #ec407a;
    color: white;
}

#caro:hover, #remo:hover {
    background-color: #d81b60; /* Cor do botão ao passar o mouse */
    border-color: #d81b60;
}

/* Estilos da div tudo */
.tudo {
    margin-top: 20px;
}

.list-group-item {
    background-color: #f8bbd0; /* Cor rosa para os itens do menu */
    border: none; /* Remove a borda */
}

.list-group-item.active {
    background-color: #ec407a; /* Cor rosa mais escura para o item ativo */
    color: white; /* Texto em branco para contraste */
}

/* Ajuste para a lista de desejos */
#listadesejos {
    margin-top: 20px; /* Adicionando espaço acima da lista de desejos */
}

/* Ajuste para a tabela de endereços */
#enderecos {
    margin-top: 20px; /* Adicionando espaço acima da lista de endereços */
}

/* Ajuste para as tabelas */
.table {
    width: 100%; /* Garantindo que as tabelas ocupem todo o espaço */
    margin-bottom: 1rem; /* Espaço abaixo da tabela */
}

.table th, .table td {
    text-align: center; /* Centralizando texto na tabela */
    vertical-align: middle; /* Centralizando verticalmente */
}

    </style>
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div id="listadesejos" class="container mt-4 tudo"> <!-- Adicionei a classe 'tudo' aqui -->
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href='meusdados.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'meusdados.php' ? 'active' : ''; ?>'>MEUS DADOS</a>
                <a href='meus_pedidos.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'meus_pedidos.php' ? 'active' : ''; ?>'>MEUS PEDIDOS</a>
                <a href='listadedesejos.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'listadedesejos.php' ? 'active' : ''; ?>'>MEUS FAVORITOS</a>
                <a href='endereco.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'endereco.php' ? 'active' : ''; ?>'>ENDEREÇOS</a>
            </div>
        </div>

        <div class="col-md-9"> <!-- Ajustei aqui para adicionar a tabela ao lado do menu -->
    <h2>Lista de Desejos</h2>

    <?php if (!empty($wishlist_message)): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($wishlist_message); ?>
        </div>
    <?php endif; ?>

    <?php if ($is_wishlist_empty): ?>
        <p>Sua lista de desejos está vazia.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['wishlist'] as $id => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="remover_lista.php?id=<?php echo urlencode($id); ?>" id="remo" class="btn btn-danger btn-sm remover">Remover</a>
                            <form action="carrinhodecompras.php" method="post" style="display: inline;">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <button type="submit" id="caro" class="btn btn-success btn-sm adicionar">Adicionar ao Carrinho</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include 'rodape.html'; ?>
</body>
</html>
