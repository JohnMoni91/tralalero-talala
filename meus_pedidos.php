<?php
include 'db.php'; // Conexão com o banco de dados

// Verifica se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Obtém o login do cliente autenticado
$login_cliente = $_SESSION['user_id']; // Supondo que o ID ou login do cliente esteja armazenado aqui

// Verifica se o login_cliente está correto
if (!$login_cliente) {
    echo "Erro: Login do cliente não encontrado.";
    exit();
}

// Consulta os pedidos apenas para o cliente logado, ordenando do mais recente para o mais antigo
$sql = "SELECT * FROM pedidos WHERE login_clientes = ? ORDER BY data_pedido DESC"; // Ajuste o nome da coluna conforme necessário
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login_cliente); 
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Pedidos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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
                <a href='meusdados.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'meusdados.php' ? 'active' : ''; ?>'>MEUS DADOS</a>
                <a href='meus_pedidos.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'meus_pedidos.php' ? 'active' : ''; ?>'>MEUS PEDIDOS</a>
                <a href='listadedesejos.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'listadedesejos.php' ? 'active' : ''; ?>'>MEUS FAVORITOS</a>
                <a href='endereco.php' class='list-group-item list-group-item-action <?php echo basename($_SERVER['PHP_SELF']) == 'endereco.php' ? 'active' : ''; ?>'>ENDEREÇOS</a>
            </div>

            </div>

    <div class="pedidos">
        <div class="container mt-4">
            <h2>Meus Pedidos</h2>
            <?php if ($result->num_rows > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID do Pedido</th>
                            <th>Data do Pedido</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($pedido = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($pedido['id']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['data_pedido']); ?></td>
                                <td>R$ <?php echo number_format($pedido['total'], 2, ',', '.'); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Você ainda não fez nenhum pedido.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'rodape.html'; ?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
