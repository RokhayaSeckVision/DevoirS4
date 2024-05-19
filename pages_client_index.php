<?php
session_start();
include('config.php'); //prendre la fichier de configuration
if (isset($_POST['login'])) {
  $phone = $_POST['phone'];
  $password = $_POST['password']; //recuperer en Cryptant le mot de passe
  $stmt = $mysqli->prepare("SELECT phone, password, client_id  FROM iB_clients   WHERE phone=? AND password=?"); //requete SQL pour faire entre l'utilisateur 
  $stmt->bind_param('ss', $phone, $password); //interaction avec la BD
  $stmt->execute(); //execution de l'interaction
  $stmt->bind_result($phone, $password, $client_id); //resultat de l'interaction
  $rs = $stmt->fetch();
  $_SESSION['client_id'] = $client_id; 

  if ($rs) { //Reussi
    header("location:Client.php");
  } else {
    $err = "Acces refuser";
  }
}

$ret = "SELECT * FROM `iB_SystemSettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>
  <!DOCTYPE html>
  <html>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
  <?php include("dist/_partials/head.php"); ?>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <p><?php echo $auth->sys_name; ?></p>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Connectez-vous pour commencer</p>

          <form method="post">
          <div class="input-group mb-3">
              <input type="text" name="phone" required class="form-control" placeholder="Votre numéro">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-4">
                <button type="submit" name="login" class="btn btn-success btn-block">Log in Client</button>
              </div>
            </div>
          </form>




          <p class="mb-0">
            <a href="pages_client_signup.php" class="text-center">Sign Up Client</a>
          </p>

        </div>
      </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>

  </body>

  </html>
<?php
} ?>