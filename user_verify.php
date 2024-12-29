<?php
session_start();
require_once "./functions/database_functions.php";
$conn = db_connect();

$name = trim($_POST['username']);
$pass = trim($_POST['password']);

if (empty($name) || empty($pass)) {
	header("Location:../signin.php?error=empty");
} else {
	$query = "SELECT name,pass from manager";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);

	if ($name == $row['name'] && $pass == $row['pass']) {
		// Manager login
		$_SESSION['manager'] = true;
		unset($_SESSION['expert']);
		unset($_SESSION['user']);
		unset($_SESSION['email']);
		header("Location: admin_book.php");
		exit();
	} else if ($name == ($row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name,pass FROM expert")))['name'] && $pass == $row['pass']) {
		// Expert login
		$_SESSION['expert'] = true;
		unset($_SESSION['manager']);
		unset($_SESSION['user']);
		unset($_SESSION['email']);
		header("Location: admin_book.php");
		exit();
	} else {
		// Check if it is customer
		$name = mysqli_real_escape_string($conn, $name);
		$pass = mysqli_real_escape_string($conn, $pass);

		$query = "SELECT email, password FROM customers";
		$result = mysqli_query($conn, $query);

		while ($row = mysqli_fetch_assoc($result)) {
			if ($name == $row['email'] && $pass == $row['password']) {
				$_SESSION['user'] = true;
				$_SESSION['email'] = $name;
				unset($_SESSION['manager']);
				unset($_SESSION['expert']);
				header("Location: index.php");
				exit();
			}
		}
	}

	// If no match is found, redirect or handle the failed login case
	header("Location: signin.php?error=invalid_credentials");
}


if (isset($conn)) {
	mysqli_close($conn);
}
