<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Update Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<div class="container">
    <h1>EXPORT COMP8870</h1>
<?php
session_start(); 

$CID = $_SESSION['identifier'];

include 'config.php'; 


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $updatedOrdersCount = 0; 

    if (isset($_GET['orderNo']) && isset($_GET['quantity'])) {
        
        $orderNos = $_GET['orderNo'];
        $quantities = $_GET['quantity'];
        $updateQuantitylist = $_GET['quantities'];

        for ($i = 0; $i < count($orderNos); $i++) {
            $orderNo = intval($orderNos[$i]);
            $quantity = intval($quantities[$i]);
            $updateQuantity = intval($updateQuantitylist[$i]);

            $updated = $quantity + $updateQuantity;

            $sql = "UPDATE orders SET quantity = $updated WHERE OrderNo = $orderNo";
            $handle = $conn->prepare($sql);
            $handle->execute();

            $updatedOrdersCount += $handle->rowCount(); 
        }

        if ($updatedOrdersCount > 0) {
            echo "Successfully updated $updatedOrdersCount orders.";
        } else {
            echo "No orders were updated.";
        }
    } else {
        echo "Failed to update orders. Required parameters are missing.";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<div class="button-container">
<form method="post" action="customer.php"> 
    <input type="hidden" class='button' name="identifier" value="<?php echo $CID; ?>"> 
    <input type="submit" class='button'value="Back"> 
</form>
<input type='button' onclick="location.href='index.php';" value='Exit'>
</div>
</div>
</body>
</html>