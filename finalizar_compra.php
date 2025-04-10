<?php

include 'db.php';

// Redireciona se o carrinho estiver vazio
if (empty($_SESSION['carrinho'])) {
    header('Location: carrinhodecompras.php');
    exit();
}

// Redireciona se o usuário não estiver logado
if (!isset($_SESSION['autenticado'])) {
    header('Location: login.php');
    exit();
}

// Processa o formulário de finalização de compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Valida e captura os dados do formulário
    $nome = trim($_POST['nome']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefone = trim($_POST['telefone']);
    $endereco = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $cep = trim($_POST['cep']);

    // Calcula o total do pedido
    $total = array_reduce($_SESSION['carrinho'], function ($carry, $item) {
        return $carry + ($item['preco'] * $item['quantidade']);
    }, 0);

    // Insere os detalhes do pedido (removendo 'cpf')
    $stmt = $conn->prepare("INSERT INTO pedidos (login_clientes, nome, email, telefone, endereco, numero, bairro, cidade, estado, cep, total, data_pedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $login_clientes = $_SESSION['autenticado'];
    $stmt->bind_param("isssssssssd", $login_clientes, $nome, $email, $telefone, $endereco, $numero, $bairro, $cidade, $estado, $cep, $total);

    if (!$stmt->execute()) {
        die("Erro ao inserir pedido: " . $stmt->error);
    }

    $pedido_id = $stmt->insert_id;

    // Insere os itens do carrinho na tabela `itens_pedido`
    foreach ($_SESSION['carrinho'] as $item) {
        $produtos_id = $item['id'];
        $quantidade = $item['quantidade'];
        $preco = $item['preco'];

        $stmt_item = $conn->prepare("INSERT INTO itens_pedido (pedidos_id, produtos_id, quantidade, preco) VALUES (?, ?, ?, ?)");
        if ($stmt_item === false) {
            die("Erro na preparação da consulta para itens do pedido: " . $conn->error);
        }
        $stmt_item->bind_param("iiid", $pedido_id, $produtos_id, $quantidade, $preco);

        if (!$stmt_item->execute()) {
            die("Erro ao inserir itens do pedido: " . $stmt_item->error);
        }
    }

    // Redirecionar para o PayPal (substitua 'URL_DO_PAYPAL' pela URL real do PayPal)
    header('Location: checkout.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    <style>
        body {
            background-color: #fce4ec; /* Fundo rosa */
        }
        .compra {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        .compra:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<?php include 'cabecalho.php'; ?>

<div class="container mt-4">
    <h2>Finalizar Compra</h2>

    <?php if (empty($_SESSION['carrinho'])): ?>
        <p>Seu carrinho está vazio.</p>
    <?php else: ?>
        <form action="" method="POST">
            <?php
            $fields = [
                'nome' => 'Nome Completo',
                'email' => 'Email',
                'telefone' => 'Telefone',
                'endereco' => 'Endereço',
                'numero' => 'Número',
                'bairro' => 'Bairro',
                'cidade' => 'Cidade',
                'estado' => 'Estado',
                'cep' => 'CEP',
            ];
            foreach ($fields as $name => $label): ?>
                <div class="form-group">
                    <label for="<?= $name ?>"> <?= $label ?> </label>
                    <input type="text" name="<?= $name ?>" id="<?= $name ?>" class="form-control" required>
                </div>
            <?php endforeach; ?>

            <h4>Resumo do Pedido</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrinho'] as $item):
                        $item_total = $item['preco'] * $item['quantidade'];
                        $total += $item_total;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nome']) ?></td>
                            <td><?= $item['quantidade'] ?></td>
                            <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item_total, 2, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>R$ <?= number_format($total, 2, ',', '.') ?></strong></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success">Finalizar Compra</button>
        </form>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<?php include 'rodape.html'; ?>
</body>
</html>