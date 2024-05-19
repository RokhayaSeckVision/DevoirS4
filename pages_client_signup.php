<?php
class Client {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function createAccount($name, $phone, $password, $address) {
        $password_hashed = $password;
        $query = "INSERT INTO iB_clients (name, phone, password, address) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('ssss', $name, $phone, $password_hashed, $address);
        return $stmt->execute();
    }

    public function getSystemSettings() {
        $query = "SELECT * FROM `ib_systemsettings`";
        $stmt = $this->mysqli->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>

<?php
session_start();
include('config.php');
include('checklogin.php');


$client = new Client($mysqli);


if (isset($_POST['create_account'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    if ($client->createAccount($name, $phone, $password, $address)) {
        $success = "Account Created";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}


$settings = $client->getSystemSettings();
$auth = $settings->fetch_object();
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <p>Sign Up</p>
    </div>
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">ibanque, votre baque de choix</p>
        <?php if (isset($success)) { echo "<div class='alert alert-success'>$success</div>"; } ?>
        <?php if (isset($err)) { echo "<div class='alert alert-danger'>$err</div>"; } ?>
        <form method="post">
          <div class="input-group mb-3">
            <input type="text" name="name" required class="form-control" placeholder="Votre Nom complet">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="text" name="phone" required class="form-control" placeholder="Votre numéro">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="address" required class="form-control" placeholder="Votre domicile">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-map-marker"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" required class="form-control" placeholder="Mot de passe">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" name="create_account" class="btn btn-success btn-block">Sign Up</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mb-0">
          <a href="pages_client_index.php" class="text-center">Login</a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

</body>

</html>

