<?php
include('connection.php');
include('pagamento.php');
session_start()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php

if (isset($_POST['itens_selecionados']) && is_array($_POST['itens_selecionados'])) {
    $selected_items = $_POST['itens_selecionados'];
    $_SESSION['itens_selecionados'] = $selected_items;
} else {

    $selected_items = isset($_SESSION['itens_selecionados']) ? $_SESSION['itens_selecionados'] : [];
}

// Conta as quantidades de cada item
$item_counts = array_count_values($selected_items);

// Verifica se há itens selecionados
if (!empty($item_counts)) {
    // Monta a query para buscar os itens no banco de dados
    $ids = implode(',', array_map('intval', array_keys($item_counts)));
    $query = "SELECT * FROM comida WHERE id IN ($ids)";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        // Cabeçalho do carrinho
        echo '<p class="linha fs-1 fw-bold d-flex justify-content-evenly m-0">CARRINHO</p>';
        echo '<div class="container"><div class="row"><div class="col">';

        $total_price = 0;
        $resumo_items = '';


        while ($user_data = $result->fetch_assoc()) {
            $item_id = $user_data['id'];
            $item_quantity = isset($item_counts[$item_id]) ? $item_counts[$item_id] : 0;
            $item_price = $user_data['preco'];
            $item_total_price = $item_price * $item_quantity;

            echo '
            <div class="card mb-3 mt-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="' . $user_data['img'] . '" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-0 pt-3 ps-4">
                            <h5 class="card-title">' . $user_data['nome'] . '</h5>
                            <p class="card-text mb-2">' . $user_data['categoria'] . '</p>
                            <p class="card-text mb-2 fw-bold">R$ ' . number_format($item_price, 2, ',', '.') . '</p>
                            <div class="row quantidade-row">
                                <div class="col p-0 m-0">
                                    <p class="card-text">QUANTIDADE:</p>
                                </div>
                                <div class="col p-0">
                                    <div class="qty mb-2">
                                        <button class="diminuir" data-id="' . $item_id . '">-</button>
                                        <span class="quantidade" data-id="' . $item_id . '">' . $item_quantity . '</span>
                                        <button class="aumentar" data-id="' . $item_id . '">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center align-items-center me-2 p-0">
                        <button class="remove">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="bi bi-x" viewBox="0 0 16 16">
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>';

            $total_price += $item_total_price;
            $resumo_items .= '<div>
                                <span>' . $user_data['nome'] . ' x <span class="quantidade" data-id="' . $item_id . '">' . $item_quantity . '</span></span>
                                <span class="item-price" data-id="' . $item_id . '" data-price="' . number_format($item_price, 2, '.', '') . '">R$ ' . number_format($item_total_price, 2, ',', '.') . '</span>
                              </div>';
        }

        echo '</div><div class="col"><aside><div class="box">
            <header>Resumo da compra</header>
            <div class="info">' . $resumo_items . '
                <div>
                    <span>Sub-total</span>
                    <span id="sub-total">R$ ' . number_format($total_price, 2, ',', '.') . '</span>
                </div>
                <div>
                    <span>Frete</span>
                    <span>Gratuito</span>
                </div>
                <div>
                    <button>Adicionar cupom de desconto <i class="bx bx-right-arrow-alt"></i></button>
                </div>
            </div>
            <footer>
                <span>Total</span>
                <span id="total">R$ ' . number_format($total_price, 2, ',', '.') . '</span>
            </footer>
        </div>
        <button type="button" class="button-carrinho" data-bs-toggle="modal" data-bs-target="#exampleModal">Finalizar compra</button>
        <div class="row mt-2 text-center">
            <div class="col">
                <form action="index.php" method="POST">';
    
    foreach ($selected_items as $item_id) {
        echo '<input type="hidden" name="itens_selecionados[]" value="' . $item_id . '">';
    }
    echo'
    <button type="submit">Voltar a comprar</button>
</form>

            </div>
            <div class="col">
                <form action="index.php" method="POST">
    <input type="hidden" name="clear_session" value="1">
    <button type="submit">Cancelar compra</button>
</form>

            </div>
        </div>';

        echo '<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" action="process_payment.php" method="post">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Nome completo</label>
                                <input type="text" class="form-control modal-input" id="inputEmail4" name="full_name">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label">Número de celular</label>
                                <input type="text" class="form-control modal-input" id="phone" name="phone" placeholder="(99) 9999-9999" required>
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Endereço</label>
                                <input type="text" class="form-control modal-input" id="inputAddress" name="address">
                            </div>
                            <div class="col-12">
                                <div class="form-container">
                                    <div class="form-group">
                                        <label for="payment_method">Método de Pagamento:</label>
                                        <select id="payment_method" name="payment_method" onchange="showPaymentDetails()" required>
                                            <option value="">Selecione...</option>
                                            <option value="credit">Cartão de Crédito</option>
                                            <option value="debit">Cartão de Débito</option>
                                            <option value="pix">Pix</option>
                                        </select>
                                    </div>
                                    <div id="card-details" class="card-details">
                                        <div class="form-group">
                                            <label for="name">Nome no Cartão:</label>
                                            <input type="text" id="name" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="card_number">Número do Cartão:</label>
                                            <input type="text" id="card_number" name="card_number">
                                        </div>
                                        <div class="form-group">
                                            <label for="expiry_date">Data de Validade:</label>
                                            <input type="text" id="expiry_date" name="expiry_date">
                                        </div>
                                        <div class="form-group">
                                            <label for="cvv">CVV:</label>
                                            <input type="text" id="cvv" name="cvv">
                                        </div>
                                    </div>
                                    <div id="pix-details" class="pix-details">
                                        <label for="pix_key">Chave Pix:</label>
                                        <input type="text" id="pix_key" name="pix_key">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Finalizar Compra</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        </aside></div></div></div>';
    } else {
        echo '<p class="text-center">Nenhum item selecionado</p>';
    }
} else {
    echo '<p class="text-center">Nenhum item selecionado</p>';
}
?>  
</body>

</html>
