<?php
session_start();
include_once("connection.php");

if (isset($_POST['clear_session']) && $_POST['clear_session'] == 1) {
  unset($_SESSION['itens_selecionados']);
}

$sql = "SELECT * FROM comida ORDER BY id DESC";
$result = $mysqli->query($sql);

$itens_selecionados = isset($_SESSION['itens_selecionados']) ? $_SESSION['itens_selecionados'] : [];


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Foda's food</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand">Navbar</a>
      <form action="" class="d-flex" role="search">
        <button id="carrinho" type="button" class="btn btn-secondary me-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart2" viewBox="0 0 16 16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l1.25 5h8.22l1.25-5zM5 13a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0"></path>
          </svg>
        </button>
        <div class="wrapper me-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
          </svg>
          <input class="form-control me-2 " type="search" aria-label="Search">
        </div>
        <button class="btn btn-outline-success" type="submit">Procurar</button>
      </form>
    </div>
  </nav>

  <?php


  

  $last_categoria = '';

  echo '<form id="formCheck" action="carrinho.php" method="post">';

if ($result->num_rows > 0){
    while ($user_data = mysqli_fetch_assoc($result)) {

        if ($user_data['categoria'] != $last_categoria) {
  
            if ($last_categoria != '') {
                echo '</div>';
            }
  
            echo '<p class="linha fs-1 fw-bold d-flex justify-content-evenly">' . $user_data['categoria'] . '</p>';
            echo '<div class="row row-cols-1 row-cols-md-5 g-4 mb-4 m-0">';
  
            $last_categoria = $user_data['categoria'];
        }
  
  echo'
            <div class="col">
                <div class="card h-100">
                    <input type="checkbox" name="itens_selecionados[]" value="' . $user_data['id'] . '" id="item' . $user_data['id'] . '"  class="input-card"' ?>
                    <?php echo in_array($user_data['id'], $itens_selecionados) ? 'checked' : ''; ?>
  
                    <?php
                    echo'
                    <img src="' . $user_data['img'] . '" class="card-img-top" alt="IMAGEM">
                    <div class="card-body">
                        <h5 class="card-title">' . $user_data['nome'] . '</h5>
                        <p class="card-text">' . $user_data['descricao'] . '</p>
                    </div>
                    <div class="card-footer">
                        <small class="text-body-secondary">' . $user_data['preco'] . '</small>
                    </div>
                </div>
            </div>'
  ?>
   
  <?php
    }
  
    echo '</div>';
    echo '</form>';
}
    ?>

  <script>
  document.getElementById('carrinho').addEventListener('click', function() {
      document.getElementById('formCheck').submit();
  });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
