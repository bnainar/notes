<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/db.php";
    $sql = sprintf(
        "UPDATE notes SET title='%s', body='%s', tag='%s' WHERE id= '%s'",
        $mysqli->real_escape_string($_POST["title"]),
        $mysqli->real_escape_string($_POST["body"]),
        $mysqli->real_escape_string($_POST["tag"]),
        $mysqli->real_escape_string($_POST["id"])
    );
    try {
        $res = $mysqli->query($sql);
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        die($mysqli->error . " " . $mysqli->errno);
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (empty($_GET["id"])) {
        header("Location: index.php");
    }
    $mysqli = require __DIR__ . "/db.php";
    $sql = sprintf(
        "SELECT * FROM notes WHERE id = '%s'",
        $mysqli->real_escape_string($_GET["id"]),
    );
    try {
        $res = $mysqli->query($sql);
        if ($res->num_rows === 0) die("Invalid note id");
        $note = $res->fetch_all()[0];
    } catch (Exception $e) {
        die($mysqli->error . $e->getMessage() . " " . $mysqli->errno);
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
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css" /> -->
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
        <h1>Edit this note</h1>
        <?php if (false) : ?>
            <h2>There was an error in editing the note</h2>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="id" id="id" hidden value="<?= $note[0] ?>">
            <label for="title" class="form-label">Note title</label>
            <input type="text" name="title" id="title" class="form-control" required value="<?= $note[1] ?>">

            <label for="body" class="form-label">Body (optional)</label>
            <textarea name="body" id="body" cols="60" rows="8" class="form-control"> <?= $note[2] ?></textarea>

            <label for="tag" class="form-label">Note tag (optional)</label>
            <input type="text" name="tag" id="tag" class="form-control" value="<?= $note[3] ?>">
            <input type="submit" value="Update" class="btn btn-primary">

        </form><a href="index.php"><button class="btn btn-secondary">Cancel</button></a>

    </div>
</body>

</html>