<?php
    session_start();

    $target_dir = "./upload/";
    $target_file = $target_dir . $_FILES["xml"]["name"];
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $has_error = false;

    if (!move_uploaded_file($_FILES["xml"]["tmp_name"], $target_file)) {
        $has_error = true;
    }

    if ($has_error) {
        echo "Upload error";
    } else {
        $_SESSION['xml'] = $target_file;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


