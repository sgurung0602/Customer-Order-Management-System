<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<h1>EXPORTS COMP8870</h1>
<h2>Welcome <?php echo isset($_POST['name']) ? $_POST['name'] : 'Customer'; ?> to your orders</h2>
    <div class="container">
        <table id="order-table">
            <tr>
                <th>Order No</th>
                <th>Product</th>
                <th>Price</th>
                <th>Region</th>
                <th>Tax</th>
                <th>Quantity</th>
                <th></th>
            </tr>
            <form action='update.php' method='GET'>
            <?php
            session_start(); 
            // Retrieve identifier from session
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['identifier'])) {
                // Retrieve the CID value from the form data
                $CID = $_POST['identifier'];
                $_SESSION['identifier'] = $_POST['identifier']; 
            } else {
                echo "CID is not set!";
            }

            include 'config.php'; 


            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


                $sql = "SELECT OrderNo, products.name as pname, price, regions.name as rname, tax, quantity 
                        FROM orders 
                        JOIN products ON orders.PID = products.PID 
                        JOIN regions ON orders.RID = regions.RID 
                        WHERE orders.CID = :cid";
                $handle = $conn->prepare($sql);
                $handle->bindParam(':cid', $CID);
                $handle->execute();

                $res = $handle->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    $min_value = -$row['quantity'] + 1;
                    $productClass = 'product-' . strtolower($row['pname']); // Generatie class name based on the product name

                    echo "<tr class='product-row $productClass'>";
                    echo "<td><input type='hidden' name='orderNo[]' value='".$row['OrderNo']."'>". $row['OrderNo'] . "</td>";
                    echo "<td class='product-name'>" . $row['pname'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['rname'] . "</td>";
                    echo "<td>" . $row['tax'] . "</td>";
                    echo "<td><input type='hidden' name='quantity[]' value='".$row['quantity']."'>" . $row['quantity'] . "</td>";
                    echo "<td><input type='number' min='$min_value' max='10' name='quantities[]' ></td>";
                    echo "</tr>";
                   
                }



                $conn = null;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </table>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
            var productNames = document.querySelectorAll('.product-name');
             

            productNames.forEach(function(name) {
            name.addEventListener('click', function(event) {
            event.stopPropagation();

            var productName = name.innerText;
            var productClass = 'product-' + productName.toLowerCase();
            var rows = document.querySelectorAll('.' + productClass);

            // Toggle highlighting 
            rows.forEach(function(row) {
                row.classList.toggle('highlight');
            });
        });
    });
});
</script>
<div class="button-container">
        <input type='submit' class='button' value='Update'>
        </form>
        <form action='new.php' method='POST'>
            <input type='submit' class='button' value='New'>
        </form>
        <input type='button' class='button' onclick="location.href='index.php';" value='Exit'>
        </div>
        </div>


</body>
</html>
