<!DOCTYPE html>
<html>
<head>
    <title>Customer Orders</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
<div class="container">

<?php
session_start(); 
$CID = $_SESSION['identifier'];

include 'config.php'; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve items from POST
        $items = isset($_POST['items']) ? $_POST['items'] : array();
        $RID = isset($_POST['selected_region'])?$_POST['selected_region'] : array();
        
        // Check if items were selected
        if (!empty($items)) {
            // Initialize an array to store added items
            $addedItems = array();
            
            foreach ($items as $item) {
                // Check if the order already exists 
                $check_sql = "SELECT COUNT(*) FROM orders WHERE PID = :PID AND RID = :RID AND CID = :CID";
                $check_stmt = $conn->prepare($check_sql);
                $check_stmt->bindParam(':PID', $item);
                $check_stmt->bindParam(':RID', $RID);
                $check_stmt->bindParam(':CID', $CID);
                $check_stmt->execute();
                $order_count = $check_stmt->fetchColumn();
                
                if ($order_count == 0) {
                    // Order does not exist, proceed to insert
                    $quantity = 1; // 
                    
                    
                    $insert_sql = "INSERT INTO orders (PID, RID, CID, quantity) VALUES (:PID, :RID, :CID, :quantity)";
                    $insert_stmt = $conn->prepare($insert_sql);
                    $insert_stmt->bindParam(':PID', $item);
                    $insert_stmt->bindParam(':RID', $RID);
                    $insert_stmt->bindParam(':CID', $CID);
                    $insert_stmt->bindParam(':quantity', $quantity);
                    $insert_stmt->execute();
                    
                    // Add item details to the array
                    $addedItems[] = $item;
                } else {
                    echo "<p>An order for the product with ID $item and region with ID $RID already exists.</p>";
                }
            }
            
          
            if (!empty($addedItems)) {
                echo "<p>The following items have been successfully added to the database: " . implode(', ', $addedItems) . "</p>";
            }
        } else {
            echo "<p>No items selected for order.</p>";
        }
    } else {
        //redirect to index
        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<div class="button-container">
<form method="post" action="new.php"> 
    <input type="hidden" class='button' name="identifier" value="<?php echo $CID; ?>"> 
  <input type="submit" class='button' value="Back"> 
</form>

<input type='button' class='button' onclick="location.href='index.php';" value='Exit '>

    </div>
    </div>
</body>
</html>
