<?php
session_start();
include('config.php');
include('checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

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
        $client_id = $_SESSION['client_id'];
        $ret = "SELECT * FROM  iB_clients WHERE client_id =? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $client_id);
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
                                <h1><?php echo $row->name; ?> iBanque</h1>
                            </div>

                        </div>
                    </div>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Choisir un compte</h3>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-hover table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Compte</th>
                                                <th>Proprietaire</th>
                                                <th>Date d'ouverture</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $client_id = $_SESSION['client_id'];
                                            $ret = "SELECT * FROM  iB_bankAccounts WHERE client_id = ?";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->bind_param('i', $client_id);
                                            $stmt->execute(); //ok
                                            $res = $stmt->get_result();
                                            $cnt = 1;
                                            while ($row = $res->fetch_object()) {
                                                $dateOpened = $row->created_at;

                                            ?>

                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row->account_number; ?></td>
                                                    <td><?php echo $row->client_name; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($dateOpened)); ?></td>
                                                    <td>
                                                        <a class="btn btn-success btn-sm" href="pages_check_client_acc_balance.php?account_id=<?php echo $row->account_id; ?>&acccount_number=<?php echo $row->account_number; ?>">
                                                            <i class="fas fa-eye"></i>
                                                            <i class="fas fa-money-bill-alt"></i>
                                                            Verifier votre solde
                                                        </a>

                                                    </td>

                                                </tr>
                                            <?php $cnt = $cnt + 1;
                                            } ?>
                                            </tfoot>
                                    </table>
                                </div>
                            </div>
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
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>

</body>

</html>