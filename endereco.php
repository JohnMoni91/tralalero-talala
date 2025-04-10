<?php
include 'db.php';

// Verifique se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Supondo que você armazene o ID do cliente na sessão
$login_clientes = $_SESSION['user_id'];

// Adicionar novo endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {
    $nome = trim($_POST['nome']);
    $endereco = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $cep = trim($_POST['cep']);

    // Verifique se o login_clientes existe na tabela login_clientes
    $check_stmt = $conn->prepare("SELECT * FROM login_clientes WHERE ID = ?");
    $check_stmt->bind_param("i", $login_clientes);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // O ID do cliente existe, prossiga com a inserção
        $stmt = $conn->prepare("INSERT INTO enderecos (login_clientes, nome, endereco, numero, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $login_clientes, $nome, $endereco, $numero, $bairro, $cidade, $estado, $cep);
        
        if ($stmt->execute()) {
            // Redirecionar após a inserção
            header('Location: endereco.php'); // Redireciona para a mesma página após a adição
            exit();
        } else {
            echo "Erro ao adicionar endereço: " . $stmt->error; // Debugging
        }
    } else {
        // O ID do cliente não existe
        echo "Erro: ID de cliente não encontrado.";
    }
}

// Listar endereços
$sql = "SELECT * FROM enderecos WHERE login_clientes = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $login_clientes);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Endereços</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="assets/corujinha.png"/>
    <style>
        body {
            background-color: #fce4ec; /* Fundo rosa claro */
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
        .btn-custom {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        .btn-custom:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }
        .menuzin {
            margin-top: 20px; /* Espaçamento superior para o menu */
        }
        .fav {
            text-decoration: none; /* Remove o sublinhado */
        }
        .parte {
            padding: 10px; /* Espaçamento interno dos itens do menu */
            text-align: center; /* Centraliza o texto */
        }

        #Ex {
            background-color: #ec407a; /* Cor do botão rosa */
            border: none; /* Remove a borda */
        }
        #Ex:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
        }
        #Ex {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        #Ex:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }

        #Adden {
            background-color: #ec407a; /* Cor do botão rosa */
            border: none; /* Remove a borda */
        }
        #Adden:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
        }
        #Adden {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        #Edi:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }

        #Edi {
            background-color: #ec407a; /* Cor do botão rosa */
            border: none; /* Remove a borda */
        }
        #Edi:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
        }
        #Edi {
            background-color: #ec407a; /* Cor do botão */
            border-color: #ec407a;
            color: white;
        }
        #Edi:hover {
            background-color: #d81b60; /* Cor do botão ao passar o mouse */
            border-color: #d81b60;
        }
    </style>
    </style>
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href='meusdados.php' class='list-group-item list-group-item-action'>MEUS DADOS</a>
                    <a href='meus_pedidos.php' class='list-group-item list-group-item-action'>MEUS PEDIDOS</a>
                    <a href='listadedesejos.php' class='list-group-item list-group-item-action'>MEUS FAVORITOS</a>
                    <a href='endereco.php' class='list-group-item list-group-item-action active'>ENDEREÇOS</a>
                </div>
            </div>

            <div class="col-md-9">
                <h2>Gerenciar Endereços</h2>
                <br>

                <form action="endereco.php" method="POST" class="mb-4">
                    <h4>Adicionar Novo Endereço</h4>
                    <div class="form-group">
                        <input type="text" name="nome" placeholder="Nome do Endereço" required class="form-control mb-2">
                        <input type="text" name="endereco" placeholder="Endereço" required class="form-control mb-2">
                        <input type="text" name="numero" placeholder="Número" required class="form-control mb-2">
                        <input type="text" name="bairro" placeholder="Bairro" required class="form-control mb-2">
                        <input type="text" name="cidade" placeholder="Cidade" required class="form-control mb-2">
                        <input type="text" name="estado" placeholder="Estado" required class="form-control mb-2">
                        <input type="text" name="cep" placeholder="CEP" required class="form-control mb-2">
                        <button type="submit" id='Adden' name="add_address" class="btn btn-primary">Adicionar Endereço</button>
                    </div>
                </form>

                <h4>Meus Endereços</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Endereço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                                <td><?php echo htmlspecialchars($row['endereco'] . ', ' . $row['numero'] . ', ' . $row['bairro'] . ', ' . $row['cidade'] . ', ' . $row['estado'] . ', ' . $row['cep']); ?></td>
                                <td>
                                    <a href="editar_endereco.php?id=<?php echo $row['id']; ?>" id="Edi" class="btn btn-warning">Editar</a>
                                    <a href="deletar_endereco.php?id=<?php echo $row['id']; ?>" id= "Ex" class="btn btn-danger">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a class="logoffgg" href="logoff.php">Sair</a>

    <?php include "rodape.html"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
