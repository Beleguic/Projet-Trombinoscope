<?php

session_start();

if (empty($_SESSION["name"])) {

	header("location: inscription.php");

}
else{

$_SESSION=array();
session_destroy();

header('location:inscription.php');
}

?>