<?php
include_once "database/db_user.php";

session_start();

session_destroy();
header('Location: ' . '../index.php');
