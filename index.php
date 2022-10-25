<?php

define("DB_SERVERNAME", "localhost:3300");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "db_university");

// Connessione al db
$conn = new mysqli(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

/* Check Connection
if ($conn && $conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    die();
} else {
    echo "Connection ok";
}*/

?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Link Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

    <!-- Link CSS -->
    <link rel="stylesheet" href="style/style.css">

    <title>University</title>
</head>

<body>

    <h1 class="text-center py-3">University Database</h1>

    <div class="container d-flex pt-3">

        <!-- Studenti -->
        <section class="col-4">

            <h3>Studenti</h3>

            <ol>
                <?php

                $sql = "SELECT name, surname FROM `students` ORDER BY surname;";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <li> <?= $row['surname'] . ' ' . $row['name'] ?> </li>
                <?php
                    }
                } elseif ($result) {
                    echo "0 results";
                } else {
                    echo "query error";
                }

                ?>
            </ol>

        </section>

        <!-- Insegnanti -->
        <section class="col-4">

            <h3>Insegnanti</h3>

            <ol>
                <?php

                $sql = "SELECT name, surname FROM `teachers` ORDER BY surname;";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <li> Prof./Prof.ssa <?= $row['surname'] . ' ' . $row['name'] ?> </li>
                <?php
                    }
                } elseif ($result) {
                    echo "0 results";
                } else {
                    echo "query error";
                }

                ?>
            </ol>

        </section>

        <!-- Corsi -->
        <section class="col-4">

            <h3>Corsi</h3>

            <ul class="list-unstyled">
                <?php

                $sql = "SELECT name, level FROM `degrees`;";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <li class="pb-2"> <?= $row['name'] . ' <br> ' . $row['level'] ?> </li>
                <?php
                    }
                } elseif ($result) {
                    echo "0 results";
                } else {
                    echo "query error";
                }

                ?>
            </ul>

        </section>

    </div>

    <?php
    $conn->close();
    ?>

</body>

</html>