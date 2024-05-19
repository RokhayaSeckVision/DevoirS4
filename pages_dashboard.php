<?php
session_start();
include('../config.php');
include('../client/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];


if (isset($_GET['Clear_Notifications'])) {
  $id = intval($_GET['Clear_Notifications']);
  $adn = "DELETE FROM  ib_notifications  WHERE notification_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Notifications Cleared";
  } else {
    $err = "Try Again Later";
  }
}

//nombre total de client
$result = "SELECT count(*) FROM ib_clients";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iBClients);
$stmt->fetch();
$stmt->close();



$result = "SELECT count(*) FROM ib_bankaccounts";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Accs);
$stmt->fetch();
$stmt->close();

$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Deposit' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();



$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

$result = "SELECT SUM(transaction_amt) FROM ib_transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
$TotalBalInAccount = ($iB_deposits)  - (($iB_withdrawal) + ($iB_Transfers));


$result = "SELECT SUM(transaction_amt) FROM ib_transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">

  <div class="wrapper">
    <?php include("dist/_partials/nav.php"); ?>
    <?php include("dist/_partials/sidebar.php"); ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Tableau de Bord</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Acceuil</a></li>
                <li class="breadcrumb-item active">Tableau de Bord</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Clients</span>
                  <span class="info-box-number">
                    <?php echo $iBClients; ?>
                  </span>
                </div>
              </div>
            </div>
        

            <div class="clearfix hidden-md-up"></div>


            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Comptes</span>
                  <span class="info-box-number"><?php echo $iB_Accs; ?></span>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-upload"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Depots</span>
                  <span class="info-box-number">
                  cfa <?php echo $iB_deposits; ?>
                  </span>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-download"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Retrait</span>
                  <span class="info-box-number">cfa <?php echo $iB_withdrawal; ?> </span>
                </div>
              </div>
            </div>

            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-random"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Transferts</span>
                  <span class="info-box-number">cfa <?php echo $iB_Transfers; ?></span>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-money-bill-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Solde Compte</span>
                  <span class="info-box-number">cfa<?php echo $TotalBalInAccount; ?></span>
                </div>
              </div>
            </div>

            
          </div>
                <div class="card-footer">
                  <div class="row">
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">cfa <?php echo $iB_deposits; ?></h5>
                        <span class="description-text">Tous les depots</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">cfa <?php echo $iB_withdrawal; ?></h5>
                        <span class="description-text">Ensemble de Retraits</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block border-right">
                        <h5 class="description-header">cfa <?php echo $iB_Transfers; ?> </h5>
                        <span class="description-text">Tous transferts</span>
                      </div>
                    </div>
                    <div class="col-sm-3 col-6">
                      <div class="description-block">
                        <h5 class="description-header">cfa <?php echo $TotalBalInAccount; ?> </h5>
                        <span class="description-text">Solde dans le compte</span>
                      </div>
                    </div>

                    <div class="row">
            <div class="col-md-12">
          
                <div class="card-header border-transparent">
                  <h3 class="card-title">Activiter</h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped m-0">
                      <thead>
                        <tr>
                          <th>Numero compte</th>
                          <th>Type</th>
                          <th>Solde</th>
                          <th>Propiétaire</th>
                          <th>Date et heure</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $ret = "SELECT * FROM `iB_Transactions` ORDER BY `iB_Transactions`.`created_at` DESC ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        $cnt = 1;
                        while ($row = $res->fetch_object()) {
                          $transTstamp = $row->created_at;
                          if ($row->tr_type == 'Deposit') {
                            $alertClass = "<span class='badge badge-success'>$row->tr_type</span>";
                          } elseif ($row->tr_type == 'Retrait') {
                            $alertClass = "<span class='badge badge-danger'>$row->tr_type</span>";
                          } else {
                            $alertClass = "<span class='badge badge-warning'>$row->tr_type</span>";
                          }
                        ?>
                          <tr>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td>cfa <?php echo $row->transaction_amt; ?></td>
                            <td><?php echo $row->client_name; ?></td>
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
          </div></div></div></div></div></div></div>
        
      </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>

  </div>

  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>

  <script src="dist/js/demo.js"></script>
  <!-- jQuery Mapael -->
  <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
  <script src="plugins/raphael/raphael.min.js"></script>
  <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
  <script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>

  <!-- PAGE SCRIPTS -->
  <script src="dist/js/pages/dashboard2.js"></script>

  <!--Load Canvas JS -->
  <script src="plugins/canvasjs.min.js"></script>
  

</body>

</html>