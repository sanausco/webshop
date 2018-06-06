<?php
session_start();

$connect = mysqli_connect("localhost", "app", "app", "webshop");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL:" . mysqli_connect_error();
}

//adding products to cart
if (isset($_POST["add"]) && $_POST["menge"] > 0) {
    
    //checkin if there are already products in cart
    if (isset($_SESSION["cart"])) {
        
        if (!in_array($_GET["id"], array_column($_SESSION["cart"], "id"))) {
            $count = count($_SESSION["cart"]);
            $_SESSION["cart"][$count] = array(
                'id' => $_GET["id"],
                'produkt_name' => $_POST["hidden_name"],
                'produkt_preis' => $_POST["hidden_preis"],
                'produkt_menge' => $_POST["menge"]
            );
            
            //increasing the number of an item in cart
        } else {
            $index = array_search($_GET["id"], $_SESSION["cart"]);
            $_SESSION["cart"][$index]["produkt_menge"] += $_POST["menge"];
        }
    }
    //adding first product to variable 
    else {

        $_SESSION["cart"][0] = array(
            'id' => $_GET["id"],
            'produkt_name' => $_POST["hidden_name"],
            'produkt_preis' => $_POST["hidden_preis"],
            'produkt_menge' => $_POST["menge"]
        );
    }
}
//to assure that one or more products are being added
else if (isset($_POST["add"])) {

        echo '<script>alert("Sie müssen ein Produkt auswählen!")</script>';
    }
    if (isset($_GET["action"])) {
        foreach ($_SESSION["cart"] as $keys => $values) {
            if ($values["id"] == $_GET["id"]) {
                unset($_SESSION["cart"][$keys]);
            }
        }
    }
    ?>

<body>
    //query for finding available products in database
    <?php
    $result = mysqli_query($connect, "select * from article order by id ASC");
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
            //display list of available items that can be added to cart
            <div>
                <form method="post" action="index.php?page=shop&action=add&id=<?php echo $row["id"]; ?>">
                    <div class="produkt color form shadow">
                        <img src="<?php echo $row["image"]; ?>">
                        <h4><?php echo $row["name"]; ?> </h4>
                        <h4>€ <?php echo $row["preis"]; ?> </h4>
                        <input type="number" name="menge" value="0" min="1" max="50">
                        <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                        <input type="hidden" name="hidden_preis" value="<?php echo $row["preis"]; ?>">
                        <input type="submit" name="add" value="Add">
                    </div>	
                </form>

            </div>	
            <?php
        }
        ?>
        <p></p>

        //table to display the shopping cart
        <table>
            <tr>
                <th width="10%">Product</th>
                <th width="10%">Quantity</th>
                <th width="10%">Price</th>
                <th width="10%">Total</th>
                <th width="10%">Delete</th>
            </tr>
    <?php
    if (!empty($_SESSION["cart"])) {
        $gesamt = 0;
        //
        $myJSON = array();
        $myObj = new stdClass();
        //			
        foreach ($_SESSION["cart"] as $k => $v) {

            //JSON

            $myObj->name = $v["produkt_name"];
            $myObj->anzahl = $v["produkt_menge"];
            $myObj->preis = $v["produkt_preis"];
            $myObj->total = $v["produkt_menge"] * $v["produkt_preis"];
            array_push($myJSON, json_encode($myObj));

            $file = "client.json";
            file_put_contents($file, $myJSON);
            //
            ?>
                    <tr>
                        <td><?php echo $v["produkt_name"]; ?></td>
                        <td><?php echo $v["produkt_menge"]; ?></td>
                        <td>€ <?php echo $v["produkt_preis"]; ?></td>
                        <td>€ <?php echo number_format($v["produkt_menge"] * $v["produkt_preis"], 2); ?> </td>
                        <td> <a href="index.php?page=shop&action=delete&id=<?php echo $v["id"] ?> "><span><img src="Images/x.png" height=5px width=5px></span></a></td>
                    </tr>
                    <?php $gesamt = $gesamt + ($v["produkt_menge"] * $v["produkt_preis"]);
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Gesamt</td>
                    <td align="right">€ <?php echo number_format($gesamt, 2); ?></td>
                </tr>
                <?php
            }
            ?>
    </table>
</body>