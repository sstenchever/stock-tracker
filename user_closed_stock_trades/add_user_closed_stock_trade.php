<?PHP
include "../db_connect.php";

$sql = "INSERT INTO user_closed_stock_trades (closed_stock_trades_transactionId, user_user_id, user_username, closedProfitLoss) VALUES(?,?,?,?)";

$closed_stock_trades_transactionId = $_REQUEST["closed_stock_trades_transactionId"];
$user_username = $_REQUEST["user_username"];


$get_user_id = "SELECT user_id FROM u511358360_stock_tracker.user WHERE username='$user_username'";
$result = $conn->query($get_user_id);

if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $user_user_id = $row[0];
}

//die();

$get_profit_loss = "SELECT (sellPrice - purchasePrice) * shares AS pl FROM u511358360_stock_tracker.closed_stock_trades WHERE transactionId=$closed_stock_trades_transactionId";
$result = $conn->query($get_profit_loss);

if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $closedProfitLoss = $row[0];
}

// die();

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisd", $closed_stock_trades_transactionId, $user_user_id, $user_username, $closedProfitLoss);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_closed_stock_trades/user_closed_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>