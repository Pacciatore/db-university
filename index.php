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
                $students = $conn->query($sql);

                if ($students && $students->num_rows > 0) {
                    // output data of each row
                    while ($row = $students->fetch_assoc()) {
                ?>
                        <li> <?= $row['surname'] . ' ' . $row['name'] ?> </li>
                <?php
                    }
                } elseif ($students) {
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
                $teachers = $conn->query($sql);

                if ($teachers && $teachers->num_rows > 0) {
                    // output data of each row
                    while ($row = $teachers->fetch_assoc()) {
                ?>
                        <li> Prof./Prof.ssa <?= $row['surname'] . ' ' . $row['name'] ?> </li>
                <?php
                    }
                } elseif ($teachers) {
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
                $degrees = $conn->query($sql);

                if ($degrees && $degrees->num_rows > 0) {
                    // output data of each row
                    while ($row = $degrees->fetch_assoc()) {
                ?>
                        <li class="pb-2"> <?= $row['name'] . ' <br> ' . $row['level'] ?> </li>
                <?php
                    }
                } elseif ($degrees) {
                    echo "0 results";
                } else {
                    echo "query error";
                }

                ?>
            </ul>

        </section>

    </div>

    <!-- Ricerca studenti -->
    <div class="container">
        <form action="." method="get" class="d-flex flex-column align-items-center gap-2">

            <label for="search" class="col-4">Ricerca studenti per cognome</label>

            <input type="text" name="surnameSearch" class="col-4">
            <input type="submit" value="Cerca" class="col-4">

        </form>

        <ol id="researchDisplay" class="d-flex flex-wrap py-3">
            <?php

            if (isset($_GET['surnameSearch'])) {
                $surnameSearch = $_GET['surnameSearch'];

                // prepare and bind
                $stmt = $conn->prepare("SELECT name, surname FROM students WHERE surname = ? ");
                $stmt->bind_param("s", $surnameSearch);

                // set parameters and execute
                $stmt->execute();

                // get result
                $searchedStudent = $stmt->get_result();

                if ($searchedStudent && $searchedStudent->num_rows > 0) {
                    while ($rowStudent = $searchedStudent->fetch_assoc()) {
            ?>
                        <li class="col-4 pb-2"> <?= $rowStudent['surname'] . ' ' . $rowStudent['name'] ?> </li>
            <?php
                    }
                } elseif ($searchedStudent) {
                    echo "La ricerca non ha prodotto risultati";
                } else {
                    echo "query error";
                }
            }

            ?>

        </ol>

    </div>

    <?php
    $conn->close();
    ?>

</body>

</html>