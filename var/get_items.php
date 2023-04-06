<?php

// connect to the database
$db = new PDO('mysql:host=localhost;dbname=invento_db', 'root', 'cs,rotkreuz,0192');

// retrieve the data from the database
$query = $db->query('SELECT * FROM inventory');
$items = $query->fetchAll(PDO::FETCH_ASSOC);

// return the data as a JSON object
header('Content-Type: application/json');
echo json_encode($items);