<nav class="main-header navbar navbar-expand navbar-white navbar-light">

<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <?php
        $result = "SELECT count(*) FROM iB_notifications";
        $stmt = $mysqli->prepare($result);
        $stmt->execute();
        $stmt->bind_result($ntf);
        $stmt->fetch();
        $stmt->close();
        ?>
        <span class="badge badge-danger navbar-badge"><?php echo $ntf; ?></span>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <?php
          $ret = "SELECT * FROM  iB_notifications  ";
          $stmt = $mysqli->prepare($ret);
          $stmt->execute(); //ok
          $res = $stmt->get_result();
          $cnt = 1;
          while ($row = $res->fetch_object()) {
            $notification_time = $row->created_at;

          ?>
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm"><?php echo $row->notification_details; ?></p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i><?php echo date("d-M-Y :: h:m", strtotime($notification_time)); ?></p>
              </div>
            </div>
            <a href="pages_dashboard.php?Clear_Notifications=<?php echo $row->notification_id; ?>" class="float-right text-sm text-danger">
              <i class="fas fa-trash"></i>
              Clear
            </a>
            <hr>
          <?php } ?>
        </a>

      </div>

    </li>

  </ul>
</nav>