<?php
include_once("connection.php");


$sql = "SELECT * FROM comida ORDER BY id DESC";

$result = $mysqli->query($sql);

// print_r($result);


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Foda's food</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

  <nav class="navbar">
    <div class="container-fluid ">
      <a class="navbar-brand  ">Foda's food</a>

      <form class="d-flex " role="search">
        <div class="wrapper me-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
          </svg>

          <input class="form-control me-2 " type="search" aria-label="Search">
        </div>

        <button class="btn btn-outline-success btn-search" type="submit">Search</button>
      </form>
    </div>
  </nav>

  <!-- <?php
    while($comida = mysqli_fetch_assoc($result)){
      echo '<p class="linha fs-1 fw-bold d-flex justify-content-evenly">' . $comida['categoria'] .'</p>';

    }

  ?> -->

  <p class="linha fs-1 fw-bold d-flex justify-content-evenly">CATEGORIA</p>
 
    <div class="row row-cols-1 row-cols-md-5 g-4">
      <div class="col">
        
        <div class="card h-100">
          <input type="checkbox" name="pricing" id="walk" class="input-card">
          <img src="img\202407181611_gbGC_.avif" class="card-img-top" alt="IMAGEM">
          <div class="card-body">
            <h5 class="card-title">NOME</h5>
            <p class="card-text">DESCRICAO</p>
          </div>
          <div class="card-footer">
            <small class="text-body-secondary">PRECO</small>
          </div>
        </div>
      </div>
    </div>
  



  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>