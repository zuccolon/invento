<head>
    <title>invento</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/w3css.css">
    <link rel="stylesheet" href="/css/custom.css">
</head>
<body>
<!--- Conteiner with max width --->
<div class="w3-container" style="max-width: 1200px;">
    <!--- Navbar --->
    <div class="w3-bar w3-large w3-round w3-card w3-dark-gray w3-margin-bottom w3-margin-top">
        <a href="/" class="w3-bar-item w3-button blackhover"><img src="/img/favicon.ico"><b> invento</b></a>
        <a href="/" class="w3-bar-item w3-button blackhover">Home</a>
        <a href="/var/info.html" class="w3-bar-item w3-button blackhover">Info</a>
    </div>
    <button class="w3-button w3-round w3-red redhover" onclick="window.location.href='/index.html'">Go back to Home</button>
    <br><br>

<?php
// DEBUG MODE
define('DEBUG', true);
if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set('Europe/Zurich');
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

// DISPLAY PASSED DATA
echo "<table class='w3-table w3-card w3-round w3-striped'>";
echo "<tr style='background-color:#F0B90B'>";
echo "<th style='border-top-left-radius:4px'>Key</th>";
echo "<th style='border-top-right-radius:4px'>Value</th>";
echo "</tr>";
foreach ($_POST as $key => $value) {
    echo "<tr>";
    echo "<td>" . $key . "</td>";
    echo "<td>" . $value . "</td>";
    echo "</tr>";
}
echo "</table><br>";

// DB CONNECTION
if (isset($_POST['perform_request'])) {
    // SERVER CONFIG
    $db_host = "localhost";
    $db_name = "invento_db";
    $db_user = "root";
    $db_pass = "cs,rotkreuz,0192";

    try{
        $db_conn = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        die("Connection failed: " . $e->getMessage());
    }
}

//// IF MEGA CHECK
if (isset($_POST['perform_request']) && $_POST['perform_request'] == 'insert_request'){
// INSERT
    echo "Insert triggered<br>";
    // Controlla missing data
    $data_missing = [];
    $required_fields = ['item_name_form', 'item_quantity_form', 'item_price_form'];
    $data_missing = [];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            $missing_data[] = ucwords(str_replace('_', ' ', $field));
        }
    }
    if (!empty($missing_data)) {
        die("Error: You didn't pass the following required fields: " . implode(', ', $data_missing) . ".");
    } else {
        echo "Missing data test OK<br>";
    }

    // Controlla che i dati non siano metodo murat strano
    $data_analisys = array();
    if(strlen($_POST['item_name_form'])>64) {
        $data_analisys[] = "Item Name";
    }
    if(!preg_match('/^[0-9]+$/', $_POST['item_quantity_form']) || strlen($_POST['item_quantity_form'])>13) {
        $data_analisys[] = "Item Quantity";
    }
    if(!preg_match('/^[0-9]*(\.[0-9]{0,2})?$/', $_POST['item_price_form'])) {
        $data_analisys[] = "Item price";
    }
    if(!empty($data_analisys)){
        die ("Error: the value passed are incorrect: <b>" . implode(', ', $data_analisys) . "</b>.");
    } else {
        echo "Analized data test OK<br>";
    }


    // Print what will be added
    echo "<br>";
    echo "The following data will be added to the DB: " . $_POST['item_name_form'] . " " . $_POST['item_quantity_form'] . " " . $_POST['item_price_form'];

    // If ok insert in db
    try{
        $stmt = $db_conn->prepare("INSERT INTO inventory (id, name, quantity, price) VALUES (NULL, :name, :quantity, :price)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);

        $name = $_POST['item_name_form'];
        $quantity = $_POST['item_quantity_form'];
        $price = $_POST['item_price_form'];

        $stmt->execute();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Create or increase session cookie
    if (!isset($_COOKIE['session_added'])) {
        setcookie('session_added', 1, time() + (864000 * 30), "/");
    } else {
        $session_added = intval($_COOKIE['session_added']) + 1;
        setcookie('session_added', $session_added, time() + (864000 * 30), "/");
    }

    echo "<h1>Added, Go <a href='index.html'>To the main website</a></h1>";
    header("location: index.html");


} else if (isset($_POST['perform_request']) && $_POST['perform_request'] == 'edit_request') {
// EDIT
    echo "Edit triggered<br>";
    // Check missing data
    $data_missing = [];
    $required_fields = ['item_id_form', 'item_name_form', 'item_quantity_form', 'item_price_form'];
    $data_missing = [];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            $missing_data[] = ucwords(str_replace('_', ' ', $field));
        }
    }
    if (!empty($missing_data)) {
        die("Error: You didn't pass the following required fields: " . implode(', ', $data_missing) . ".");
    } else {
        echo "Missing data test OK<br>";
    }
// Check data
    $data_analisys = array();
    if(!ctype_digit($_POST['item_id_form'])) {
        $data_analisys[] = "Item ID";
    }
    if(strlen($_POST['item_name_form'])>64) {
        $data_analisys[] = "Item Name";
    }
    if(!preg_match('/^[0-9]+$/', $_POST['item_quantity_form']) || strlen($_POST['item_quantity_form'])>13) {
        $data_analisys[] = "Item Quantity";
    }
    if(!preg_match('/^[0-9]*(\.[0-9]{0,2})?$/', $_POST['item_price_form'])) {
        $data_analisys[] = "Item price";
    }
    if(!empty($data_analisys)){
        die ("Error: the value passed are incorrect: <b>" . implode(', ', $data_analisys) . "</b>.");
    } else {
        echo "Analized data test OK<br>";
    }
    try {
        // Update the database
        $stmt = $db_conn->prepare("UPDATE inventory SET name = :name, quantity = :quantity, price = :price WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        // Get the form data
        $id = $_POST['item_id_form'];
        $name = $_POST['item_name_form'];
        $quantity = $_POST['item_quantity_form'];
        $price = $_POST['item_price_form'];
        $stmt->execute();

    } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
    }

    echo "<h1>Edited, Go <a href='index.html'>To the main website</a></h1>";
    header("location: index.html");
} else if (isset($_POST['perform_request']) && $_POST['perform_request'] == 'delete_request') {
// DELETE
    echo "Delete triggered";
    if (isset($_POST['form_delete_id']) && ctype_digit($_POST['form_delete_id'])) {
        try {
            // Prepare the DELETE statement
            $stmt = $db_conn->prepare("DELETE FROM `inventory` WHERE `inventory`.`id` = :form_delete_id");

            $stmt->bindParam(':form_delete_id', $form_delete_id);

            $form_delete_id = $_POST['form_delete_id'];

            $stmt->execute();

            // Echo a message to indicate success
            header('Location: /index.html');
            die("Record deleted successfully");
        } catch(PDOException $e) {
            // Echo the error message if there is an exception
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    header('Location: /index.html');
    exit;
}