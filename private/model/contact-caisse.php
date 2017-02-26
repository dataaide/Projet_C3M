<?php



$db = new PDO('mysql:host=localhost;dbname=projetC3M;charset=utf8', 'root', '');

$statement = $db->query('SELECT * FROM caisse_contact');

$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($contacts);


?>