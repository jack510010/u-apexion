<?php
session_start();

unset($_SESSION['admin']);


header("Location: user_login.php");