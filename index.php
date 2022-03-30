<?php require_once 'connect.php';
$pdo = new \PDO(DSN, USER, PASS);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $friend = array_map('trim', $_POST);

    $firstName = $friend['firstname'];
    $lastName = $friend['lastname'];


    if (empty($friend['firstname'])) {
        $errors[] = 'Le prenom est obligatoire';
    }
    $firstNameMaxLength = 70;
    if (strlen($friend['firstname']) > $firstNameMaxLength) {
        $errors[] = 'Le prénom doit faire mois de ' . $firstNameMaxLength . ' caractères';
    }
    if (empty($friend['lastname'])) {
        $errors[] = 'Le prenom est obligatoire';
    }
    if (strlen($friend['lastname']) > $firstNameMaxLength) {
        $errors[] = 'Le Nom doit faire moins de ' . $firstNameMaxLength . ' caractères';
    }
    if (empty($errors)) {



        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstName, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastName, \PDO::PARAM_STR);

        $statement->execute();

        $friend = $statement->fetchAll();
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <ul>
        <?php

        $query = 'SELECT * FROM friend';
        $statement = $pdo->query($query);
        $friends = $statement->fetchAll(PDO::FETCH_OBJ);

        foreach ($friends as $friend) :
        ?><li><?php
                echo $friend->firstname . ' ' . $friend->lastname; ?>
            </li>
        <?php endforeach; ?>

        <?php foreach ($errors as $error) : ?>
            <li><?= $error ?> </li>
        <?php endforeach; ?>
    </ul>
    <form action="" method="post">

        <label for="firstname">Enter your firstname: </label>
        <input type="text" name="firstname" id="firstname">


        <label for="lastname">Enter your lastname: </label>
        <input type="text" name="lastname" id="lastname">


        <button>Soumettre</button>

    </form>
</body>

</html>