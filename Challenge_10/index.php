<?php
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Index</title>
    <style>
        table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
        }
    </style>
</head>
<body>
    <h1>Viettel Cyber Security Student</h1>

    <br>
    <b>List student</b>
    <form method="post" action="/upload.php" enctype="multipart/form-data">
        <input type="file" name="xml">
        <button type="submit">Upload</button>
    </form>

    <table>
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Year</th>
                <th scope="col">School</th>
            </tr>
        </thead>
        <tbody>

    <?php

        if (isset($_SESSION['xml'])) {
            $file = $_SESSION['xml'];
            $students = simplexml_load_file($file, "SimpleXMLElement", LIBXML_DTDLOAD | LIBXML_NOENT);

            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>{$student->Name}</td>";
                echo "<td>{$student->Year}</td>";
                echo "<td>{$student->School}</td>";
                echo "</tr>";

            }
        }
    ?>
        </tbody>
    </table>
</body>
</html>
