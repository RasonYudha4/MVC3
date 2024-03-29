<?php
use app\core\Application;
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title><?php echo $this->title?></title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body">
      <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link text-white" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/contact">Contact</a>
            </li> 
          </ul>
          <?php if (Application::isGuest()): ?>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link text-white" href="/login">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/register">Register</a>
            </li> 
          </ul>
          <?php else: ?>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <p class="nav-link text-white">Welcome <?php echo Application::$app->user->getDisplayName() ?></p>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="/profile">
                Profile
              </a>
            </li> 
            <li class="nav-item">
              <a class="nav-link text-white" href="/logout">
                LogOut
              </a>
            </li>
          </ul>
          <?php endif; ?>
        </div>
      </div>
    </nav>

    <div class="container">
      <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">
          <?php echo Application::$app->session->getFlash('success')?>
        </div>
      <?php endif; ?>
      {{content}}
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>