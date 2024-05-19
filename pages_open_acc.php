<?php
session_start();
include('../config.php');
include('../client/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php include("dist/_partials/head.php"); ?>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include("dist/_partials/nav.php"); ?>
    <?php include("dist/_partials/sidebar.php"); ?>

    <div class="content-wrapper">


      <section class="content">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Select on any client to open an account</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nom</th>
                      <th>Contact</th>
                      <th>Addresse</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT * FROM  iB_clients ORDER BY RAND() ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->phone; ?></td>
                        <td><?php echo $row->address; ?></td>
                        <td>
                          <a class="btn btn-success btn-sm" href="pages_open_client_acc.php?client_number=<?php echo $row->client_number; ?>&client_id=<?php echo $row->client_id; ?>">
                            <i class="fas fa-user"></i>
                            <i class="fas fa-lock-open"></i>
                            Open Account
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