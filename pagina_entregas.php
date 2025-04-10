<?php 
// Incluir verificação de autenticação
include 'db.php';

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Consultar os dados de entregas
$query = "SELECT id, data_entrega, total, endereco FROM entregas";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Entregas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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

    <div class="container mt-4">
        <h2>Página de Entregas</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data de Entrega</th>
                        <th>Total</th>
                        <th>Endereço</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($entrega = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entrega['id']); ?></td>
                            <td><?php echo htmlspecialchars($entrega['data_entrega']); ?></td>
                            <td>R$ <?php echo number_format($entrega['total'], 2, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($entrega['endereco']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhuma entrega encontrada.</p>
        <?php endif; ?>
    </div>

    <?php include 'rodape.html'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
