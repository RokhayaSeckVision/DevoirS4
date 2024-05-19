<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <?php
  $admin_id = $_SESSION['admin_id'];
  $ret = "SELECT * FROM  iB_admin  WHERE admin_id = ? ";
  $stmt = $mysqli->prepare($ret);
  $stmt->bind_param('i', $admin_id);
  $stmt->execute(); //ok
  $res = $stmt->get_result();
  while ($row = $res->fetch_object()) {
    if ($row->profile_pic == '') {
      $profile_picture = "<img src='dist/img/user_icon.png' class='img-circle elevation-2' alt='User Image'>
                ";
    } else {
      $profile_picture = "<img src='dist/img/$row->profile_pic' class='img-circle elevation-2' alt='User Image'>
                ";
    }

    
    $ret = "SELECT * FROM `iB_SystemSettings` ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    while ($sys = $res->fetch_object()) {
  ?>


      <a href="pages_dashboard.php" class="brand-link">
        <img src="dist/img/<?php echo $sys->sys_logo; ?>" alt=" Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo $sys->sys_name; ?></span>
      </a>

      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php echo $profile_picture; ?>
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $row->name; ?></a>
          </div>
        </div>

        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


            <li class="nav-item">
              <a href="pages_add_client.php" class="nav-link">
                <i class="fas fa-user-plus nav-icon"></i>
                <p>Nouveau client</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_open_acc.php" class="nav-link">
                <i class="fas fa-lock-open nav-icon"></i>
                <p>Nouveau compte</p>
              </a>
            </li>


            <li class="nav-item">
              <a href="pages_deposit_money.php" class="nav-link">
                <i class="fas fa-upload nav-icon"></i>
                <p>Depots</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_withdraw_money.php" class="nav-link">
                <i class="fas fa-download nav-icon"></i>
                <p>Retrait</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_transfer_money.php" class="nav-link">
                <i class="fas fa-random nav-icon"></i>
                <p>Transferts</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pages_logout.php" class="nav-link">
                <i class="nav-icon fas fa-power-off"></i>
                <p>
                  Log Out adm
                </p>
              </a>
            </li>

          </ul>
        </nav>
      </div>
</aside>
<?php
    }
  } ?>