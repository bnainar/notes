<?php

$failed = false;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["title"])) {
        die("Note title cannot be null");
    }

    $mysqli = require __DIR__ . "/db.php";
    var_dump($_POST);
    $sql = sprintf(
        "INSERT INTO notes (title, body, tag) VALUES ('%s','%s','%s')",
        $mysqli->real_escape_string($_POST["title"]),
        $mysqli->real_escape_string($_POST["body"]),
        $mysqli->real_escape_string($_POST["tag"])
    );
    try {
        $res = $mysqli->query($sql);
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        // die($mysqli->error . " " . $mysqli->errno);
        $failed = true;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {

            background-color: #ccd5ae;

        }

        input,
        textarea,
        button {
            margin-bottom: 2rem;

        }
    </style>
</head>

<body>
    <div class="mx-auto pt-5" style="width:500px">
        <h1>Add a note</h1>
        <?php if ($failed) : ?>
            <h2>There was an error in adding the note</h2>
        <?php endif; ?>
        <form method="post">
            <label for="title" class="form-label">Note title</label>
            <input type="text" name="title" id="title" class="form-control" required>

            <label for="body" class="form-label">Body (optional)</label>
            <textarea name="body" id="body" cols="60" rows="8" class="form-control"></textarea>

            <label for="tag" class="form-label">Note tag (optional)</label>
            <input type="text" name="tag" id="tag" class="form-control">
            <input type="submit" value="Create a note +" class="btn btn-primary">
        </form>
        <a href="index.php"><button class="btn btn-secondary">Cancel</button></a>


    </div>
</body>

</html>