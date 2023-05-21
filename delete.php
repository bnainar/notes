<?php

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (empty($_GET["id"])) {
        die("Provide a valid note id to delete.");
    }
    $mysqli = require __DIR__ . "/db.php";

    $sql = sprintf(
        "DELETE FROM notes WHERE id = '%s'",
        $mysqli->real_escape_string($_GET["id"])
    );
    try {
        $res = $mysqli->query($sql);
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
