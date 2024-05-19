<?php
session_start();
include('../config.php');
include('../client/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//register new account
if (isset($_POST['create_staff_account'])) {
    //Register  Client
    $name = $_POST['name'];
    $national_id = $_POST['national_id'];
    $client_number = $_POST['client_number'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password']));
    $address  = $_POST['address'];

    $profile_pic  = $_FILES["profile_pic"]["name"];
    move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "dist/img/" . $_FILES["profile_pic"]["name"]);

    //Insert Captured information to a database table
    $query = "INSERT INTO iB_clients (name, national_id, client_number, phone, email, password, address, profile_pic) VALUES (?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    //bind paramaters
    $rc = $stmt->bind_param('ssssssss', $name, $national_id, $client_number, $phone, $email, $password, $address, $profile_pic);
    $stmt->execute();

    //declare a varible which will be passed to alert function
    if ($stmt) {
        $success = "Client Account Created";
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
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Creer compte</h1>
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
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Nom Client</label>
                                                <input type="text" name="name" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">Numero Client</label>
                                                <?php
                                                $length = 4;
                                                $_Number =  substr(str_shuffle('0123456789'), 1, $length);
                                                ?>
                                                <input type="text" readonly name="client_number" value="iBank-CLIENT-<?php echo $_Number; ?>" class="form-control" id="exampleInputPassword1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Contact</label>
                                                <input type="text" name="phone" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input type="email" name="email" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputPassword1">Mot de passe</label>
                                                <input type="password" name="password" required class="form-control" id="exampleInputEmail1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=" col-md-6 form-group">
                                                <label for="exampleInputEmail1">Addresse</label>
                                                <input type="text" name="address" required class="form-control" id="exampleInputEmail1">
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label for="exampleInputFile">Client Profile Picture</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="profile_pic" class="custom-file-input" id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text" id="">Upload</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" name="create_staff_account" class="btn btn-success">Add Client</button>
                                    </div>
                                </form>
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
    <!-- bs-custom-file-input -->
    <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    
</body>

</html>