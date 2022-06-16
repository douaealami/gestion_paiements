<?php
session_start();
session_destroy();

echo "<script>window.open('login.php?logged_out= vous êtes déconnecté','_self')</script>";

?>