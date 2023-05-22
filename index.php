<?php
$mysqli = require __DIR__ . "/db.php";
$sql = "SELECT * FROM notes";
$res = $mysqli->query($sql);
$arr = $res->fetch_all();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Index</title>

    <style>
        a {
            text-decoration: none;
            color: black;
        }

        body {
            background-color: #ccd5ae;
        }

        /* <!-- <pp if ($res->num_rows === 0) : ?> --> */
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
        <h1>Welcome to Notes</h1>

        <div class="row gx-5">
            <div class="col">

                <?php if (true) : ?>
                    <img src="./Humaaans - Standing.png" class="rounded mx-auto d-block" alt="No notes are created">
                    <h5 class="my-4"> There are no notes. Create some!</h5>
                <?php else : ?>
                    <?php foreach ($arr as $note) : ?>
                        <a href="note.php?id=<?= $note[0] ?>">
                            <div class="card my-4 shadow-sm" style="width:25rem;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title">
                                            <?= $note[1] ?>
                                            <?php if ($note[3] != "") : ?>
                                                <span class="badge bg-secondary">
                                                    <?= $note[3] ?>
                                                </span>
                                            <?php endif; ?>
                                        </h5>
                                        <a href="delete.php?id=<?= $note[0] ?>">
                                            <button type="button" class="btn-close" aria-label="Close"></button>
                                        </a>
                                    </div>

                                    <div class="card-text">
                                        <?php
                                        if (strlen($note[2]) > 100) {
                                            echo substr($note[2], 0, 100) . "...";
                                        } else {
                                            echo $note[2];
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="col">
                <a class="btn btn-primary btn-lg my-4" href="create.php">Create a Note +</a>
                <?php if ($res->num_rows != 0) : ?>
                    <form action="search.php" method="get">
                        <h4>Search notes</h4>
                        <input type="text" name="note" class="form-control">
                        <input type="submit" value="Search" class="btn btn-secondary">
                    </form>
                    <form action="search.php" method="get">
                        <h4>Search a tag</h4>
                        <input type="text" name="tag" class="form-control">
                        <input type="submit" value="Search" class="btn btn-secondary">
                    </form>
                <?php endif; ?>
            </div>
        </div>
</body>

</html>