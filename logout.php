<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['pusat']);
header('Location: index.php');
