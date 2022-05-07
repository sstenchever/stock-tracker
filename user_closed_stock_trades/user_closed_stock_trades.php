<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<script src="/menu.js"></script>

<body>
<div class="container overflow-hidden" style="padding: 1em;">
<?PHP
include "../db_connect.php";

$sql = "SELECT * FROM u511358360_stock_tracker.user_closed_stock_trades";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-dark table-striped' border=1><tr><th>Transaction ID</th><th>User ID</th><th>Username</th><th>Closed Profit/Loss</th><th></th><th></th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["closed_stock_trades_transactionId"] . "</td><td>" . $row["user_user_id"] . "</td><td>" . $row["user_username"] . "</td><td>" . $row["closedProfitLoss"]  . "</td>";
        echo "<td>" . "<a href='/user_closed_stock_trades/delete_user_closed_stock_trade.php?closed_stock_trades_transactionId=" . $row["closed_stock_trades_transactionId"] . "'>Del</a>" . "</td>";
        echo "<td>" . "<a href='/user_closed_stock_trades/edit_user_closed_stock_trade.php?closed_stock_trades_transactionId=" . $row["closed_stock_trades_transactionId"] . "'>Edit</a>" . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();

?>
<a href="/user_closed_stock_trades/add_user_closed_stock_trade.htm">Add User Closed Stock Trade</a></br>

</div>
</body>