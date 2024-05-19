<?php
session_start();
include('config.php');
include('checklogin.php');
check_login();

if (isset($_POST['deposit'])) {
    $account_id = $_GET['account_id'];
    $account_number = $_GET['account_number'];
    $client_id  = $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];

    $notification_details = "$client_name Has Deposited $ $transaction_amt To Bank Account $account_number";


    $query = "INSERT INTO iB_Transactions (account_id, account_number, client_id, client_name, transaction_amt, client_phone) VALUES (?,?,?,?,?,?)";
    $notification = "INSERT INTO  iB_notifications (notification_details) VALUES (?)";

    $stmt = $mysqli->prepare($query);
    $notification_stmt = $mysqli->prepare($notification);

    $rc = $notification_stmt->bind_param('s', $notification_details);
    $rc = $stmt->bind_param('ssssss', $account_id, $account_number, $client_id, $client_name,$transaction_amt, $client_phone);
    $stmt->execute();
    $notification_stmt->execute();


    //Alert
    if ($stmt && $notification_stmt) {
        $success = "Depot avec succe";
    } else {
        $err = "Essayer plus tard";
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
        $account_id = $_GET['account_id'];
        $ret = "SELECT * FROM  iB_bankAccounts WHERE account_id = ? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $account_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

        ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Depot</h1>
                            </div>
                        </div>
                </section>

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
                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Nom Client</label>
                                                    <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>

                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputEmail1">Telephone</label>
                                                    <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class=" col-md-4 form-group">
                                                    <label for="exampleInputPassword1">Numero de compte</label>
                                                    <input type="text" readonly value="<?php echo $row->account_number; ?>" name="account_number" required class="form-control" id="exampleInputEmail1">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputEmail1">Transaction Code</label>
                                                    <?php
                                                    $length = 20;
                                                    $_transcode =  substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
                                                    ?>
                                                    <input type="text" name="tr_code" readonly value="<?php echo $_transcode; ?>" required class="form-control" id="exampleInputEmail1">
                                                </div>
                                                <div class=" col-md-6 form-group">
                                                    <label for="exampleInputPassword1">Balance de depot</label>
                                                    <input type="text" name="transaction_amt" required class="form-control" id="exampleInputEmail1">
                                                </div>

                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" name="deposit" class="btn btn-success">Valider depot</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                </section>
            </div>
        <?php } ?>
        <?php include("dist/_partials/footer.php"); ?>
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