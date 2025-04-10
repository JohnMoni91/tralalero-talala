<?php
include 'db.php';

// Verifique se o usuário está autenticado
session_start(); // Certifique-se de que a sessão esteja iniciada
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') {
    header('Location: login.php?login=erro2');
    exit();
}

// Verifique se o ID do endereço foi passado pela URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $endereco_id = $_GET['id'];

    // Verifique se o ID do endereço pertence ao cliente logado
    $login_clientes = $_SESSION['user_id'];

    $check_stmt = $conn->prepare("SELECT * FROM enderecos WHERE id = ? AND login_clientes = ?");
    $check_stmt->bind_param("ii", $endereco_id, $login_clientes);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // O endereço existe e pertence ao cliente, prossiga com a exclusão
        $stmt = $conn->prepare("DELETE FROM enderecos WHERE id = ?");
        $stmt->bind_param("i", $endereco_id);
        
        if ($stmt->execute()) {
            // Redirecionar após a exclusão
            header('Location: endereco.php?delete=success'); // Adiciona um parâmetro de sucesso à URL
            exit();
        } else {
            echo "Erro ao excluir endereço: " . $stmt->error; // Debugging
        }
    } else {
        // O ID do endereço não existe ou não pertence ao cliente
        echo "Erro: ID de endereço não encontrado ou não pertence ao cliente.";
    }
} else {
    // ID do endereço não fornecido
    echo "Erro: ID de endereço não fornecido.";
}
?>
