<?php
    session_start();

    $target_dir = "./../upload/";
    $target_file = $target_dir . $_FILES["img"]["name"];
    $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $has_error = false;

    switch ($extension) {
        case "png":
        case "jpg":
        case "gif":
            break;
        default:
            echo "File must be image(png, jpg, gif)";
            $has_error = true;
            break;
    }

    if (!move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        $has_error = true;
    }

    if ($has_error) {
        echo "Upload error";
    } else {
        $_SESSION['img'] = $target_file;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }


