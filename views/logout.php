<?php
session_start();
$_SESSION=[];
session_destroy(); // Destroy the session
header('Location: login.php');
exit;
?>