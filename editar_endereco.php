<?php
include 'db.php';

// Verifique se o usuário está autenticado
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Supondo que você armazene o ID do cliente na sessão
$login_clientes = $_SESSION['user_id'];

// Verifique se o ID do endereço foi passado
if (!isset($_GET['id'])) {
    header('Location: endereco.php');
    exit();
}

$id_endereco = intval($_GET['id']);

// Buscar o endereço existente
$stmt = $conn->prepare("SELECT * FROM enderecos WHERE id = ? AND login_clientes = ?");
$stmt->bind_param("ii", $id_endereco, $login_clientes);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Endereço não encontrado.";
    exit();
}

$endereco = $result->fetch_assoc();

// Atualizar o endereço
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_address'])) {
    $nome = trim($_POST['nome']);
    $endereco_texto = trim($_POST['endereco']);
    $numero = trim($_POST['numero']);
    $bairro = trim($_POST['bairro']);
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $cep = trim($_POST['cep']);

    $update_stmt = $conn->prepare("UPDATE enderecos SET nome = ?, endereco = ?, numero = ?, bairro = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?");
    $update_stmt->bind_param("sssssssi", $nome, $endereco_texto, $numero, $bairro, $cidade, $estado, $cep, $id_endereco);

    if ($update_stmt->execute()) {
        header('Location: endereco.php'); // Redirecionar após a atualização
        exit();
    } else {
        echo "Erro ao atualizar endereço: " . $update_stmt->error; // Debugging
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Endereço</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
</head>
<body>
    <?php include 'cabecalho.php'; ?>

    <div class="container mt-5">
        <h2>Editar Endereço</h2>
        <form action="editar_endereco.php?id=<?php echo $id_endereco; ?>" method="POST">
            <div class="form-group">
                <input type="text" name="nome" placeholder="Nome do Endereço" value="<?php echo htmlspecialchars($endereco['nome']); ?>" required class="form-control mb-2">
                <input type="text" name="endereco" placeholder="Endereço" value="<?php echo htmlspecialchars($endereco['endereco']); ?>" required class="form-control mb-2">
                <input type="text" name="numero" placeholder="Número" value="<?php echo htmlspecialchars($endereco['numero']); ?>" required class="form-control mb-2">
                <input type="text" name="bairro" placeholder="Bairro" value="<?php echo htmlspecialchars($endereco['bairro']); ?>" required class="form-control mb-2">
                <input type="text" name="cidade" placeholder="Cidade" value="<?php echo htmlspecialchars($endereco['cidade']); ?>" required class="form-control mb-2">
                <input type="text" name="estado" placeholder="Estado" value="<?php echo htmlspecialchars($endereco['estado']); ?>" required class="form-control mb-2">
                <input type="text" name="cep" placeholder="CEP" value="<?php echo htmlspecialchars($endereco['cep']); ?>" required class="form-control mb-2">
                <button type="submit" name="update_address" class="btn btn-success">Atualizar Endereço</button>
            </div>
        </form>
        <a href="endereco.php" class="btn btn-secondary">Voltar</a>
    </div>

    <?php include "rodape.html"; ?>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
