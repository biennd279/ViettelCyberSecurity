<?php
    if (isset($_GET['page'])) {
        $page = (string) $_GET['page'];
        var_dump($_GET['page']);
        include_once $page;
    }
    