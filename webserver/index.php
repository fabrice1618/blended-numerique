<?php 
require_once( "utilisateursModel.php" );

date_default_timezone_set('Europe/Paris');

session_start();

// Recuperation des erreurs 401 qui viennent d'une autre page
if ( isset($_SESSION['http-err-401']) && $_SESSION['http-err-401'] ) {
  $bErreur401 = true;  
} else {
  $bErreur401 = false;
}

if ( isset($_SESSION['utilisateur_id']) && $_SESSION['utilisateur_id'] > 0 ) {
  // L'utilisateur est connecté
  $sAction = $_GET['action'] ?? '';
  if ( $sAction == 'logout' ) {
    // Deconnecter utilisateur
    $_SESSION['utilisateur_id'] = 0;
  } else {
    // Deja connecte -> retour home page
    header("Location:home.php");
  }
} else {
  // L'utilisateur n'est pas connecte
  if ( isset($_POST['email']) && isset($_POST['password']) ) {
    // Verification authentification
    $auth = checkAuth($_POST['email'], $_POST['password']);

    if ( $auth === false ) {
      $_SESSION['utilisateur_id'] = 0;
      http_response_code(401);
      $bErreur401 = true;
    } else {
      $_SESSION['utilisateur_id'] = $auth;
      header("Location:home.php");
    }
  }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Top-Security - Login form</title>
  </head>
  <body>
    <div class="container-lg">

      <nav class="navbar navbar-expand-lg navbar-light bg-light my-2">
        <div class="container-fluid">
          <a class="navbar-brand" href="/">Top-Security</a>
        </div>
      </nav>
<?php
  if ( $bErreur401 ) {
    unset( $_SESSION['http-err-401'] );
    print('
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-10 alert alert-danger" role="alert">HTTP 401 Unauthorized - Accès restreint</div>
        <div class="col"></div>        
      </div>
    ');
    }      
?>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6"><h1>Please sign in</h1></div>
        <div class="col"></div>        
      </div>

      <form action="index.php" method="post">
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">    
          <div class="input-group">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="email" class="form-control" placeholder="email" aria-label="email" aria-describedby="basic-addon1">
          </div>
        </div>
        <div class="col"></div>        
      </div>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
          <input type="password" name="password" class="form-control" id="inputPassword" placeholder="password">
        </div>
        <div class="col"></div>        
      </div>
      <div class="row mt-5 mb-3">
        <div class="col"></div>
        <div class="col-6">
        <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
        <div class="col"></div>        
      </div>
      </form>
    </div>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </body>
</html>