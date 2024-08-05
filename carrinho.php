<?php
include('connection.php');
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

    if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
        $selected_items = $_POST['selected_items'];
        $item_counts = array_count_values($selected_items);

        echo '<p class="linha fs-1 fw-bold d-flex justify-content-evenly m-0">CARRINHO</p>';
        echo '
            <div class="container">
                <div class="row">
                    <div class="col">';

        $ids = implode(',', array_map('intval', array_keys($item_counts)));
        $query = "SELECT * FROM comida WHERE id IN ($ids)";
        $result = $mysqli->query($query);

        $total_price = 0;
        $resumo_items = '';

        if ($result->num_rows > 0) {

            while ($user_data = $result->fetch_assoc()) {
                $item_id = $user_data['id'];
                $item_quantity = $item_counts[$item_id];
                $item_price = $user_data['preco'];
                $item_total_price = $item_price * $item_quantity;

                echo '
                <div class="card mb-3 mt-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="' . $user_data['img'] . '" class="img-fluid rounded-start" alt="...">
                        </div>
                        <div class="col-md-7 ">
                            <div class="card-body p-0 pt-3 ps-4">
                                <h5 class="card-title">' . $user_data['nome'] . '</h5>
                                <p class="card-text mb-2">' . $user_data['categoria'] . '</p>
                                <p class="card-text mb-2 fw-bold">R$ ' . number_format($item_price, 2, ',', '.') . '</p>
                                
                                <div class="col-4">
                                    <p class="card-text d-flex">QUANTIDADE:</p>
                                </div>
                                <div class="col-4 p-0 d-flex">
                                    <div class="qty">
                                        <button class="diminuir" data-id="' . $item_id . '">-</button>
                                        <span class="quantidade" data-id="' . $item_id . '">' . $item_quantity . '</span>
                                        <button class="aumentar" data-id="' . $item_id . '">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-center align-items-center me-2 p-0">
                            <button class="remove">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" class="bi bi-x"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
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

            echo '
            </div>
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
                    <button>Finalizar Compra</button>
                </aside>
            </div>

        </div>
    </div>';
        } else {
            echo '<p>Nenhum item encontrado.</p>';
        }

        echo '</div>
        </div>';
    } else {
        echo '<p>Nenhum item selecionado.</p>';
    }
    ?>

    <script src="./script/carrinho.js"></script>

</body>

</html>
