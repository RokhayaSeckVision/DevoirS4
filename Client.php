<?php
session_start();
include('config.php');
include('checklogin.php');
check_login();

class Client {
    private $mysqli;
    private $client_id;

    public function __construct($mysqli, $client_id) {
        $this->mysqli = $mysqli;
        $this->client_id = $client_id;
    }

    public function updateClientAccount($name, $phone, $address, $profile_pic) {
        $query = "UPDATE iB_clients SET name=?, phone=?, address=?, profile_pic=? WHERE client_id=?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('sssss', $name, $phone, $address, $profile_pic, $this->client_id);
        $stmt->execute();
        return $stmt;
    }

    public function changeClientPassword($password, $client_number) {
        $query = "UPDATE iB_clients SET password=? WHERE client_number=?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('ss', $password, $client_number);
        $stmt->execute();
        return $stmt;
    }

    public function getClientDetails() {
        $query = "SELECT * FROM iB_clients WHERE client_id=?";
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('s', $this->client_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}

$client_id = $_SESSION['client_id'];
$client = new Client($mysqli, $client_id);

if (isset($_POST['update_client_account'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile_pic = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "../admin/dist/img/" . $profile_pic);

    $stmt = $client->updateClientAccount($name, $phone, $address, $profile_pic);
    if ($stmt) {
        $success = "Client Account Updated";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}

if (isset($_POST['change_client_password'])) {
    $password = sha1(md5($_POST['password']));
    $client_number = $_GET['client_number'];
    $stmt = $client->changeClientPassword($password, $client_number);
    if ($stmt) {
        $success = "Client Password Updated";
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

        <div class="content-wrapper">
            <?php
            $res = $client->getClientDetails();
            while ($row = $res->fetch_object()) {
                $profile_picture = $row->profile_pic ? "
                    <img class='img-fluid' src='../admin/dist/img/$row->profile_pic' alt='User profile picture'>" : "
                    <img class='img-fluid' src='../admin/dist/img/user_icon.png' alt='User profile picture'>";
            ?>
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1><?php echo $row->name; ?> Profil</h1>
                            </div>

                    </div>
                </section>

                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card card-purple card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <?php echo $profile_picture; ?>
                                        </div>
                                        <h3 class="profile-username text-center"><?php echo $row->name; ?></h3>
                                        <p class="text-muted text-center">Espace client ibanque </p>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Telephone: </b> <a class="float-right"><?php echo $row->phone; ?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Addresse: </b> <a class="float-right"><?php echo $row->address; ?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#update_Profile" data-toggle="tab">Update Profile</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#Change_Password" data-toggle="tab">Change Password</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="update_Profile">
                                                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="name" required class="form-control" value="<?php echo $row->name; ?>" id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Numero</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required name="phone" value="<?php echo $row->phone; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Addresse</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" required name="address" value="<?php echo $row->address; ?>" id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button name="update_client_account" type="submit" class="btn btn-outline-success">Update Account</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="Change_Password">
                                                <form method="post" class="form-horizontal">
                                                    <div class="form-group row">
                                                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" required id="inputName">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" name="password" class="form-control" required id="inputEmail">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="inputName2" class="col-sm-2 col-form-label">Confirm New Password</label>
                                                        <div class="col-sm-10">
                                                            <input type="password" class="form-control" required id="inputName2">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="offset-sm-2 col-sm-10">
                                                            <button type="submit" name="change_client_password" class="btn btn-outline-success">Change Password</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
    </div>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
    <script src="dist/js/demo.js"></script>
</body>
</html>
