<?php
?>
<html>
    <head>
        <title>invento</title>
        <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/w3css.css">
        <link rel="stylesheet" href="/css/custom.css">
    </head>
    <body>
        <div class="w3-container">
        <!--- Navbar --->
        <div class="w3-bar w3-large w3-round w3-card w3-dark-gray w3-margin-bottom w3-margin-top">
            <a href="/" class="w3-bar-item w3-button blackhover"><img src="/img/favicon.ico"><b> invento</b></a>
            <a href="/" class="w3-bar-item w3-button blackhover">Home</a>
        </div>

        <h3>Edit Item: <b>#<?= $_GET['form_edit_id']?></b></h3>
            <div class="w3-card w3-round" style="max-width: 400px;">
                <div class="w3-container w3-dark-grey" style="border-top-right-radius:4px; border-top-left-radius:4px; height: 39px; padding: 9px; padding-left: 14px;">
                    <b>Edit Item</b> <button class="w3-button w3-red w3-round redhover w3-right w3-tiny w3-padding-small" onclick="window.history.back()">X</button>
                </div>
                <form class="w3-container w3-round" action="/script.php" method="post">
                        <input type="hidden" name="perform_request" value="edit_request">
                        <input type="hidden" name="item_id_form" value="<?= $_GET['form_edit_id']?>">
                        <p>
                        <label for="item_name_form">Item Name</label>
                        <input name="item_name_form" id="item_name_form" class="w3-input w3-border w3-round" type="text" placeholder="Apple iPhone 13" maxlength="64" required="" value="<?= $_GET['form_edit_name']?>">
                        <label style="color:grey" class="w3-small">Text</label></p>
                    <div class="w3-row-padding" style="margin:0 -16px">
                        <div class="w3-half">
                            <p>
                                <label for="item_quantity_form">Quantity</label>
                                <input name="item_quantity_form" id="item_quantity_form" class="w3-input w3-border w3-round" type="number" min="0" max="1000000" step="1" placeholder="5" pattern="^[0-9]+$" required="" value="<?= $_GET['form_edit_quantity']?>">
                                <label style="color:grey" class="w3-small">Nr.</label></p>
                        </div>
                        <div class="w3-half">
                            <p>
                                <label for="item_price_form">Price</label>
                                <input name="item_price_form" id="item_price_form" class="w3-input w3-border w3-round" type="text" placeholder="15.50" pattern="^[0-9]*(\.[0-9]{0,2})?$" required="" value="<?= $_GET['form_edit_price']?>">
                                <label style="color:grey" class="w3-small">Nr.</label></p>
                        </div>
                    </div>
                    <p><button type="submit" class="w3-button w3-green w3-round greenhover" style="left: 0px; right: 0px; width: 100%">Save Changes</button></p>
                </form>
            </div>
        </div>
    </body>
</html>