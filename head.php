<?php
$ret = "SELECT * FROM `ib_systemsettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $sys->sys_name; ?> - <?php echo $sys->sys_tagline; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
        <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
        <script src="dist/js/swal.js"></script>
        <link rel="icon" type="image/png" sizes="16x16" href="dist/img/<?php echo $sys->sys_logo; ?>">
        <link rel="stylesheet" type="text/css" href="plugins/datatable/custom_dt_html5.css">

        <?php if (isset($success)) { ?>
            <script>
                setTimeout(function() {
                        swal("Success", "<?php echo $success; ?>", "success");
                    },
                    100);
            </script>

        <?php } ?>

        <?php if (isset($err)) { ?>
            <script>
                setTimeout(function() {
                        swal("Failed", "<?php echo $err; ?>", "error");
                    },
                    100);
            </script>

        <?php } ?>
        <?php if (isset($info)) { ?>
            <script>
                setTimeout(function() {
                        swal("Success", "<?php echo $info; ?>", "warning");
                    },
                    100);
            </script>

        <?php } ?>
        <?php if (isset($transaction_error)) { ?>
            <script>
                setTimeout(function() {
                        swal("Error", "<?php echo $transaction_error; ?>", "error");
                    },
                    100);
            </script>

        <?php } ?>
        <script>
            function getiBankAccs(val)

            {
                $.ajax({
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccountType=' + val,
                    success: function(data) {
                        $('#AccountRates').val(data);
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccNumber=' + val,
                    success: function(data) {
                        $('#ReceivingAcc').val(data);
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccHolder=' + val,
                    success: function(data) {
                        $('#AccountHolder').val(data);
                    }
                });
            }
        </script>
        
    </head>
<?php } ?>