<?php

require_once '_connec.php';


$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";

$statement = $pdo->query($query);

$friends = $statement->fetchAll();

//var_dump ($friends)

?>

<ul>
<?php foreach($friends as $friend): ?>
 <li> <?= $friend['firstname'] . ' ' . $friend['lastname'];?> </li>
 <?php endforeach ?>
</ul>

            <form action="" method="POST" >
                <label for="lastName" class= "labelForm">Nom :</label>
                <input type="text" id="lastName" name="lastName" >
            
                <label for="firstName" class= "labelForm">Prénom :</label>
                <input type="text" id="firstName" name="firstName" >

                <button>Envoyer</button>
                </form>
<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
$lastname = trim($_POST['lastName']); 
$firstname = trim($_POST['firstName']);


if(empty($lastname['lastName'])) {
    $errors[] = 'Le nom est obligatoire';
}
$maxNameLength = 45;
if(strlen($lastname['lastName']) > $maxNameLength) {
    $errors[] = 'Le nom doit faire moins de ' . $maxNameLength;
}

if(empty($firstname['firstName'])) {
    $errors[] = 'Le prénom est obligatoire';
}

if(strlen($firstName['firstName']) > $maxNameLength) {
    $errors[] = 'Le prénom doit faire moins de ' . $maxNameLength;
}

$query = "INSERT INTO friend (lastname, firstname) VALUES (:lastname, :firstname)";

$statement = $pdo->prepare($query);
$statement->bindValue(':firstname',$firstname, PDO::PARAM_STR);
$statement->bindValue(':lastname',$lastname, PDO::PARAM_STR);
$statement->execute(); 

header('Location: index.php');
}



