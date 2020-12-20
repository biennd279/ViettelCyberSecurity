<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Index</title>
</head>
<body>
    <h1>Viettel Cyber Security</h1>
    <?php
    if (isset($_GET['page'])) {
        include "./page/" . $_GET['page'] . ".php";
    }
    ?>

    <?php
        echo "<h2>Preview image</h2>";
        if (isset($_SESSION['img'])) {
            echo "<img width='500px' src=\"upload/{$_SESSION['img']}\" alt=\"image preview\">";
        }
    ?>
    <br>
    <b>Change image preview</b>
    <form method="post" action="page/upload.php" enctype="multipart/form-data">
        <input type="file" name="img">
        <button type="submit">Upload</button>
    </form>

    <a href="index.php?page=about">About</a>



</body>
</html>
