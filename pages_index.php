<?php
session_start();
include('../config.php'); 
if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $mysqli->prepare("SELECT email, password, admin_id  FROM ib_admin  WHERE email=? AND password=?"); //sql to log in user
  $stmt->bind_param('ss', $email, $password); 
  $stmt->execute(); 
  $stmt->bind_result($email, $password, $admin_id); 
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id;
  if ($rs) { 
    header("location:pages_dashboard.php");
  } else {
    $err = "Access Denied Please Check Your Credentials";
  }
}
$ret = "SELECT * FROM `ib_systemsettings` ";
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
          <p class="login-box-msg">Log In, en tant que administrateur</p>

          <form method="post">
            <div class="input-group mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
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
                <div class="icheck-primary">
                </div>
              </div>
              <div class="col-8">
                <button type="submit" name="login" class="btn btn-danger btn-block">Log In as Admin</button>
              </div>
            </div>
          </form>
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