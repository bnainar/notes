<?php
$mysqli = require __DIR__ . "/db.php";
$arr;
if ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($_GET["note"])) {

    $term = $mysqli->real_escape_string($_GET["note"]);
    try {
        $sql =
            "SELECT *  FROM notes WHERE (title LIKE '%" . $term . "%' OR body LIKE '%" . $term . "%')";
        $res = $mysqli->query($sql);
        $arr = $res->fetch_all();
    } catch (Exception $e) {
        die($mysqli->error . " " . $mysqli->errno);
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET" && !empty($_GET["tag"])) {
    $term = $mysqli->real_escape_string($_GET["tag"]);
    try {
        $sql =
            "SELECT *  FROM notes WHERE tag LIKE '%" . $term . "%'";
        $res = $mysqli->query($sql);
        $arr = $res->fetch_all();
    } catch (Exception $e) {
        die($mysqli->error . " " . $mysqli->errno);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Search</title>

    <style>
        a {
            text-decoration: none;
            color: black;
        }

        body {
            background-color: #ccd5ae;
        }

        div.card:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }

        input[type="submit"] {
            margin: 1rem 0 !important;
        }
    </style>

</head>

<body>
    <div class="mx-auto pt-5" style="max-width:700px">
        <h1>Search results for "<?= $term ?>"</h1>

        <?php foreach ($arr as $note) : ?>
            <a href="note.php?id=<?= $note[0] ?>">
                <div class="card my-4 shadow-sm" style="width:25rem;">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= $note[1] ?>
                            <?php if ($note[3] != "") : ?>
                                <span class="badge bg-secondary">
                                    <?= $note[3] ?>
                                </span>
                            <?php endif; ?>
                        </h5>
                        <div class="card-text">
                            <?= $note[2] ?>
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
        <a href="index.php"><button class="btn btn-primary">See all Notes</button></a>
</body>

</html>