<?php
session_start();
if(!isset($_SESSION['rights'])){
    header("Location: login.php");
}



?>