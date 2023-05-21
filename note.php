<?php

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
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
    <title>View Note</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css" /> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html {
            height: 100%;
        }

        body {
            background-image: url("https://images.pexels.com/photos/139306/pexels-photo-139306.jpeg?cs=srgb&dl=pexels-fwstudio-139306.jpg&fm=jpg");
            min-height: 100%;
        }

        p {
            font-weight: 600;
            font-size: large;
        }

        #cont {
            position: relative;
            height: 500px;
        }

        #card {
            padding: 3rem;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.32);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.66);
        }

        input,
        textarea,
        button {
            margin-bottom: 2rem;

        }
    </style>
</head>

<body>
    <div id="cont">
        <div class="pt-5 center-block" style="width:500px" id="card">
            <div class="d-flex justify-content-between">
                <h1 id="title">
                    <?= $note[1] ?>

                </h1>
                <a href="delete.php?id=<?= $note[0] ?>">
                    <button type="button" class="btn-close" aria-label="Close"></button>
                </a>
            </div>
            <?php if ($note[3] != "") : ?>
                <h4>
                    <span class="badge bg-secondary">
                        <?= $note[3] ?>
                    </span>
                </h4>
            <?php endif; ?>

            <p class="mb-4" id="content">
                <?= $note[2] ?>
            </p>
            <a href="edit.php?id=<?= $note[0] ?>"><button class="btn btn-primary">Edit</button></a>
            <a href="index.php"><button class="btn btn-secondary mx-3">See all Notes</button></a>
            <button class="btn btn-secondary" id="sharebtn">Share</button>
        </div>
    </div>
    <script>
        const title = document.getElementById("title").textContent.trim();
        const text = document.getElementById("content").textContent.trim();
        console.log(title);
        console.log(text);
        const btn = document.getElementById("sharebtn");
        const shareData = {
            title,
            text
        };
        btn.addEventListener("click", async () => {
            try {
                await navigator.share(shareData);
            } catch (err) {}
        });
    </script>
</body>

</html>