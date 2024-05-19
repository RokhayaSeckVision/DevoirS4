<?php
    $dbuser = "ibanque";
    $dbpass = "Realibanque2";
    $host = "mysql-ibanque.alwaysdata.net";
    $db = "ibanque_db";
    $mysqli = new mysqli($host, $dbuser, $dbpass, $db);

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    } else {
        echo "Connection successful!";
    }