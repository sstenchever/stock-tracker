<?PHP
include "../db_connect.php";

$sql = "UPDATE user_closed_stock_trades SET closed_stock_trades_transactionId = ?, user_user_id = ?, user_username = ?, closedProfitLoss = ? WHERE closed_stock_trades_transactionId = ?";

$closed_stock_trades_transactionId = $_REQUEST["closed_stock_trades_transactionId"];
$user_user_id = $_REQUEST["user_user_id"];
$user_username = $_REQUEST["user_username"];
$closedProfitLoss = $_REQUEST["closedProfitLoss"];
$original_transactionId = $_REQUEST["original_transactionId"];

if ($closed_stock_trades_transactionId !== $original_transactionId) {
    
    $get_profit_loss = "SELECT (currentPrice - purchasePrice) * shares AS pl FROM u511358360_stock_tracker.closed_stock_trades WHERE transactionId=$closed_stock_trades_transactionId";
    $result = $conn->query($get_profit_loss);

    if ($result->num_rows > 0) {
        $row = $result->fetch_row();
        $closedProfitLoss = $row[0];
    }
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisdi", $closed_stock_trades_transactionId, $user_user_id, $user_username, $closedProfitLoss, $original_transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_closed_stock_trades/user_closed_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>