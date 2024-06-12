<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customers</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>EXPORT COMP8870</h1>
        <p>Please insert your name and customer id to begin.</p>
        <form action="customer.php" method="post">
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name" value="Sally Smith" required><br><br>
            <label for="identifier">Customer Identifier:</label><br>
            <input type="number" id="identifier" name="identifier" value="" required><br><br>
            <input type="submit" class='button' value="Submit">
        </form>
    </div>
</body>
</html>
