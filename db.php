<?php
$mysqli = new mysqli("localhost", "root", "", "notes");
if ($mysqli->connect_errno) {
    die("Connection Error" . $mysqli->connect_error);
}
return $mysqli;
