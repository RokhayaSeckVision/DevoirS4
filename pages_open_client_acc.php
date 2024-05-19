<?php
session_start();
include('../config.php');
include('../client/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['open_account'])) {
    $account_number = $_POST['account_number'];
    $acc_amount = $_POST['acc_amount'];
    $client_id  = $_GET['client_id'];
    $client_name = $_POST['client_name'];
    $client_phone = $_POST['client_phone'];
    $client_adr  = $_POST['client_adr'];

    $query = "INSERT INTO iB_bankAccounts (account_number, acc_amount, client_id, client_name, client_phone, client_adr) VALUES (?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);

    $rc = $stmt->bind_param('ssssss',  $account_number, $acc_amount, $client_id, $client_name, $client_phone, $client_adr);
    $stmt->execute();

    if ($stmt) {
        $success = "iBank Account Opened";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <?php include("dist/_partials/nav.php"); ?>
        <?php include("dist/_partials/sidebar.php"); ?>
        <?php
        $client_id = $_GET['client_id'];
        $ret = "SELECT * FROM  iB_clients WHERE client_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $client_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

        ?>
            <div class="content-wrapper">

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card card-purple">
                                    <div class="card-header">
                                        <h3 class="card-title">Tout remplir</h3>
                                    </div>
                                    <form method="post" enctype="multipart/form-data" role="form">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Client propriétaire</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $row->name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Telephone du client</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $row->phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">
                                                
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Adresse client</label>
                                                    <input type="text" name="client_adr" readonly value="<?php echo $row->address; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-6 form-group" style="display:none">
                                                    <label for="exampleInputEmail1">Solde compte</label>
                                                    <input type="text" name="acc_amount" value="0" readonly required class="form-control">
                                                </div>

                                            </div>
                                            <div class="row">

                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Numero compte</label>
                                                    <?php
                                                    $length = 12;
                                                    $_accnumber =  substr(str_shuffle('0123456789'), 1, $length);
                                                    ?>
                                                    <input type="text" name="account_number" value="<?php echo $_accnumber; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="open_account" class="btn btn-success">Ouvrir un compte iBanque</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                </section>
            </div>
        <?php } ?>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    
</body>

</html>