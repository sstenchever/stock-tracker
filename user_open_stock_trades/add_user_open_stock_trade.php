<?PHP
include "../db_connect.php";

$sql = "INSERT INTO user_open_stock_trades (open_stock_trades_transactionId, user_user_id, user_username, openProfitLoss) VALUES(?,?,?,?)";

$open_stock_trades_transactionId = $_REQUEST["open_stock_trades_transactionId"];
$user_username = $_REQUEST["user_username"];


$get_user_id = "SELECT user_id FROM u511358360_stock_tracker.user WHERE username='$user_username'";
$result = $conn->query($get_user_id);

if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $user_user_id = $row[0];
}

//die();

$get_profit_loss = "SELECT (currentPrice - purchasePrice) * shares AS pl FROM u511358360_stock_tracker.open_stock_trades WHERE transactionId=$open_stock_trades_transactionId";
$result = $conn->query($get_profit_loss);

if ($result->num_rows > 0) {
    $row = $result->fetch_row();
    $openProfitLoss = $row[0];
}

// die();

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisd", $open_stock_trades_transactionId, $user_user_id, $user_username, $openProfitLoss);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_open_stock_trades/user_open_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>