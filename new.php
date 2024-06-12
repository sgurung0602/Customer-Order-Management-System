<!DOCTYPE html>
<html>
<head>
    <title>New Orders</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<div class="container">

    <h1>EXPORT COMP8870</h1>
  
    <form action="add.php" method="post">
    <?php
    session_start(); 
        $CID = $_SESSION['identifier']; 
    

        include 'config.php'; 

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $products_query = "SELECT * FROM products";
            $products_result = $conn->query($products_query)->fetchAll(PDO::FETCH_ASSOC);

            $regions_query = "SELECT * FROM regions";
            $regions_result = $conn->query($regions_query)->fetchAll(PDO::FETCH_ASSOC);
           
            echo "<div class='container'>";

            echo "<table id='order-table'>";
            echo "<tr><th>Product</th><th>Price</th><th></th><th>Region</th><th>Tax</th><th></th></tr>";

            $max_count = max(count($products_result), count($regions_result));
            for ($i = 0; $i < $max_count; $i++) {
                echo "<tr>";

                // Products
                if ($i < count($products_result)) {
                    echo "<td>" . $products_result[$i]['name'] . "</td>";
                    echo "<td>Price: " . $products_result[$i]['price'] . "</td>";
                    echo "<td><input type='checkbox' name='items[]' value='" . $products_result[$i]['PID'] . "' onclick='checkProductSelection()'></td>";

                } else {
                    echo "<td></td><td></td><td></td>";
                }

                // Regions
                if ($i < count($regions_result)) {
                    echo "<td>" . $regions_result[$i]['name'] . "</td>";
                    echo "<td>Tax: " . $regions_result[$i]['tax'] . "</td>";
                    echo "<td><input type='radio' name='selected_region' value='" . $regions_result[$i]['RID'] . "' onclick='checkSelections()'></td>";
                } else {
                    echo "<td></td><td></td><td></td>";
                }

                echo "</tr>";
            }
            

            echo "</table>";
            echo "</div>";
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        ?>
        <br><br>
        <div class="button-container">
        <input type="submit" class='button' onclick="location.href='add.php';"value="Create" id="createButton" disabled>

        
    <br>

    <script>
        function checkSelections() {
            var itemsSelected = document.querySelectorAll('input[name="items[]"]:checked').length > 0;
            var regionSelected = document.querySelector('input[name="selected_region"]:checked');
            var createButton = document.getElementById('createButton');
            
            createButton.disabled = !(itemsSelected && regionSelected);
        }
        
        function validateForm() {
            var itemsSelected = document.querySelectorAll('input[name="items[]"]:checked').length > 0;
            var regionSelected = document.querySelector('input[name="selected_region"]:checked');

            if (!itemsSelected || !regionSelected) {
                alert("Please select at least one product and one region.");
                return false; // Prevent submission
            }

            return true; // Allow submission
        }
    </script>
    </form>
    <form method="post" action="customer.php"> 
    <input type="hidden" name="identifier" value="<?php echo $CID; ?>"> 
  <input type="submit" class='button' value="Back"> 
  </form>
  <input type="button" class='button' onclick="location.href='index.php';" value="Exit">
  </div>
</body>
</html>
        