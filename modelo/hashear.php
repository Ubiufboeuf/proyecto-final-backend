<?php
$hash= $_POST['password'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
echo $hashedPassword;
?>