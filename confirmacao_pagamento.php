<?php
include 'db.php';

// Incluir biblioteca do Twilio
require __DIR__ . 'ok/vendor/autoload.php';
use Twilio\Rest\Client;

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Capturar informações do carrinho e comprador
$cart_count = isset($_SESSION['carrinho']) ? array_sum(array_column($_SESSION['carrinho'], 'quantidade')) : 0;
$itens = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$comprador = isset($_SESSION['nome_usuario']) ? $_SESSION['nome_usuario'] : 'Cliente não identificado';

// Limpar o carrinho após a confirmação
unset($_SESSION['carrinho']);

// Função para enviar mensagem via WhatsApp
function enviarMensagemWhatsapp($comprador, $itens) {
    // Twilio credentials
    $sid = 'AC9deae8ad36c3c8d574a62020d1c9ee36'; // Substitua pelo seu SID
    $token = 'd88fbf5e2bae61fc42a325adae03b7a5'; // Substitua pelo seu Token
    $client = new Client($sid, $token);
    
    // Número da dona (destinatário)
    $to = 'whatsapp:+5543996709161'; // Substitua pelo número da dona
    
    // Mensagem para enviar
    $mensagem = "Nova compra realizada!\n";
    $mensagem .= "Comprador: " . $comprador . "\n";
    $mensagem .= "Itens comprados:\n";
    
    foreach ($itens as $item) {
        $mensagem .= "- " . htmlspecialchars($item['nome']) . " (Quantidade: " . htmlspecialchars($item['quantidade']) . ")\n";
    }

    // Enviar mensagem via WhatsApp
    try {
        $client->messages->create(
            $to,
            [
                'from' => 'whatsapp:+14155238886', // Número de envio do Twilio
                'body' => $mensagem
            ]
        );
    } catch (Exception $e) {
        error_log('Erro ao enviar mensagem: ' . $e->getMessage());
        // Você pode decidir como lidar com o erro aqui (exibir uma mensagem, redirecionar, etc.)
    }
}

// Enviar mensagem após a confirmação da compra
enviarMensagemWhatsapp($comprador, $itens);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Pagamento</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="container mt-5">
        <div class="card text-center">
            <div class="card-header">
                <h2>Confirmação de Pagamento</h2>
            </div>
            <div class="card-body">
                <h4 class="card-title">Pagamento Processado com Sucesso!</h4>
                <p class="card-text">Você comprou <?php echo htmlspecialchars($cart_count); ?> item(s).</p>
                <a href="index.php" class="btn btn-primary confirmacaopagamentobotao">Voltar para a Página Inicial</a>
            </div>
            <div class="card-footer text-muted">
                Obrigado por sua compra!
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <?php include 'rodape.html'; ?>
    
</body>
</html>