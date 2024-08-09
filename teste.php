<?php
session_start();
include('connection.php');

// Inicializa o carrinho, se não estiver já na sessão
if (!isset($_SESSION['selected_items'])) {
    $_SESSION['selected_items'] = [];
}

// Processa a remoção de itens do carrinho
if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $item_to_remove = intval($_GET['remove']);
    if (($key = array_search($item_to_remove, $_SESSION['selected_items'])) !== false) {
        unset($_SESSION['selected_items'][$key]);
        $_SESSION['selected_items'] = array_values($_SESSION['selected_items']); // Re-indexa o array
    }
}

$selected_items = $_SESSION['selected_items'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Voltar à loja</a>
        </div>
    </nav>

    <div class="container mt-4">
        <?php
        if (!empty($selected_items)) {
            $ids = implode(',', array_map('intval', $selected_items));
            $query = "SELECT * FROM comida WHERE id IN ($ids)";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                $total_price = 0;
                $resumo_items = '';

                echo '<form id="formCheck" action="index.php" method="post">';

                while ($user_data = $result->fetch_assoc()) {
                    $item_id = $user_data['id'];
                    $item_quantity = array_count_values($selected_items)[$item_id];
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
                                                <button type="button" class="diminuir" data-id="' . $item_id . '">-</button>
                                                <span class="quantidade" data-id="' . $item_id . '">' . $item_quantity . '</span>
                                                <button type="button" class="aumentar" data-id="' . $item_id . '">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex justify-content-center align-items-center me-2 p-0">
                                <a href="carrinho.php?remove=' . $item_id . '" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>';

                    $total_price += $item_total_price;
                    $resumo_items .= '<div>
                                        <span>' . $user_data['nome'] . ' x <span class="quantidade" data-id="' . $item_id . '">' . $item_quantity . '</span></span>
                                        <span class="item-price" data-id="' . $item_id . '" data-price="' . number_format($item_price, 2, '.', '') . '">R$ ' . number_format($item_total_price, 2, ',', '.') . '</span>
                                    </div>';
                }

                echo '
                <div class="row mt-4">
                    <div class="col">
                        <aside>
                            <div class="box">
                                <header>Resumo da compra</header>
                                <div class="info">
                                    ' . $resumo_items . '
                                    <div>
                                        <span>Sub-total</span>
                                        <span id="sub-total">R$ ' . number_format($total_price, 2, ',', '.') . '</span>
                                    </div>
                                    <div>
                                        <span>Frete</span>
                                        <span>Gratuito</span>
                                    </div>
                                    <div>
                                        <button>
                                            Adicionar cupom de desconto
                                            <i class="bx bx-right-arrow-alt"></i>
                                        </button>
                                    </div>
                                </div>
                                <footer>
                                    <span>Total</span>
                                    <span id="total">R$ ' . number_format($total_price, 2, ',', '.') . '</span>
                                </footer>
                            </div>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Finalizar compra</button>
                            <div class="row mt-2 text-center">
                                <div class="col">
                                    <a href="index.php?selected_items=' . urlencode(implode(',', $selected_items)) . '" class="btn btn-secondary">Adicionar mais itens</a>
                                </div>
                                <div class="col mt-3">
                                    <a href="index.php" class="btn btn-danger">Cancelar compra</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Informações de Pagamento</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="process_payment.php" method="post">
                                                <div class="form-group">
                                                    <label for="payment_method">Método de Pagamento:</label>
                                                    <select id="payment_method" name="payment_method" onchange="showPaymentDetails()" required>
                                                        <option value="">Selecione...</option>
                                                        <option value="credit">Cartão de Crédito</option>
                                                        <option value="debit">Cartão de Débito</option>
                                                        <option value="pix">Pix</option>
                                                    </select>
                                                </div>

                                                <div id="card-details" class="card-details" style="display: none;">
                                                    <div class="form-group">
                                                        <label for="name">Nome no Cartão:</label>
                                                        <input type="text" id="name" name="name">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="card_number">Número do Cartão:</label>
                                                        <input type="text" id="card_number" name="card_number">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="expiry_date">Data de Validade (MM/AA):</label>
                                                        <input type="text" id="expiry_date" name="expiry_date">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="cvv">CVV:</label>
                                                        <input type="text" id="cvv" name="cvv">
                                                    </div>
                                                </div>

                                                <div id="pix-details" class="pix-details" style="display: none;">
                                                    <div class="form-group">
                                                        <p>Escaneie o QR code abaixo para realizar o pagamento via Pix:</p>
                                                        <img src="qrcode.png" alt="QR code Pix" style="width: 200px; height: 200px;">
                                                    </div>
                                                </div>

                                                <div class="form-group mt-3">
                                                    <button type="submit" class="btn btn-success">Pagar</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>';
            } else {
                echo '<p>Nenhum item encontrado.</p>';
            }
        } else {
            echo '<p>Nenhum item selecionado.</p>';
        }
        ?>
    </div>

    <script src="./script/carrinho.js"></script>
    <script src="./script/pagamento.js"></script>
    <script>
    document.querySelectorAll('.aumentar').forEach(button => {
        button.addEventListener('click', () => {
            const item_id = button.dataset.id;
            const quantityElem = document.querySelector(`.quantidade[data-id="${item_id}"]`);
            let quantity = parseInt(quantityElem.textContent);
            quantityElem.textContent = quantity + 1;
        });
    });

    document.querySelectorAll('.diminuir').forEach(button => {
        button.addEventListener('click', () => {
            const item_id = button.dataset.id;
            const quantityElem = document.querySelector(`.quantidade[data-id="${item_id}"]`);
            let quantity = parseInt(quantityElem.textContent);
            if (quantity > 1) {
                quantityElem.textContent = quantity - 1;
            }
        });
    });

    function showPaymentDetails() {
        var paymentMethod = document.getElementById('payment_method').value;
        var cardDetails = document.getElementById('card-details');
        var pixDetails = document.getElementById('pix-details');
        cardDetails.style.display = paymentMethod === 'credit' || paymentMethod === 'debit' ? 'block' : 'none';
        pixDetails.style.display = paymentMethod === 'pix' ? 'block' : 'none';
    }
    </script>

</body>

</html>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>