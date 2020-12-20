<?php
    session_start();

    $target_dir = "./../upload/";
    $target_file = $target_dir . $_FILES["img"]["name"];
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $has_error = false;

    $info = getimagesize($_FILES["img"]["tmp_name"]);
    $allow_file = [IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF];


    if ($info === false) {
        echo "Unable to determine image type of uploaded file";
        $has_error = true;
    } elseif (!in_array($info[2], $allow_file)) {
        echo "File must be image(png, jpg, gif)";
        $has_error = true;
    }
    else if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        $has_error = true;
    }

    if ($has_error) {
        echo "Upload error";
    } else {
        $_SESSION['img'] = $target_file;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


