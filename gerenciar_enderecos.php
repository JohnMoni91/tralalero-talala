<?php
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Adicionar novo endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_address'])) {
    $login_clientes = $_SESSION['login_clientes']; // Use a sessão correta
    $nome = $_POST['nome'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

    $stmt = $conn->prepare("INSERT INTO enderecos (login_clientes, nome, endereco, numero, bairro, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $login_clientes, $nome, $endereco, $numero, $bairro, $cidade, $estado, $cep);
    $stmt->execute();

    // Redirecionar após a inserção
    header('Location: gerenciar_enderecos.php');
    exit();
}

// Listar endereços
$login_clientes = $_SESSION['login_clientes']; 
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
</head>
<body>

<div class="container mt-4">
    <h2>Gerenciar Endereços</h2>

    <form action="gerenciar_enderecos.php" method="POST" class="mb-4">
        <h4>Adicionar Novo Endereço</h4>
        <input type="text" name="nome" placeholder="Nome do Endereço" required class="form-control mb-2">
        <input type="text" name="endereco" placeholder="Endereço" required class="form-control mb-2">
        <input type="text" name="numero" placeholder="Número" required class="form-control mb-2">
        <input type="text" name="bairro" placeholder="Bairro" required class="form-control mb-2">
        <input type="text" name="cidade" placeholder="Cidade" required class="form-control mb-2">
        <input type="text" name="estado" placeholder="Estado" required class="form-control mb-2">
        <input type="text" name="cep" placeholder="CEP" required class="form-control mb-2">
        <button type="submit" name="add_address" class="btn btn-success">Adicionar Endereço</button>
    </form>

    <h4>Meus Endereços</h4>
    <table class="table">
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
                        <a href="editar_endereco.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="deletar_endereco.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>