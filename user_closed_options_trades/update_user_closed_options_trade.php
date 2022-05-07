<?PHP
include "../db_connect.php";

$sql = "UPDATE user_closed_options_trades SET closed_options_trades_transactionId = ?, user_user_id = ?, user_username = ?, closedProfitLoss = ? WHERE closed_options_trades_transactionId = ?";

$closed_options_trades_transactionId = $_REQUEST["closed_options_trades_transactionId"];
$user_user_id = $_REQUEST["user_user_id"];
$user_username = $_REQUEST["user_username"];
$closedProfitLoss = $_REQUEST["closedProfitLoss"];
$original_transactionId = $_REQUEST["original_transactionId"];

if ($closed_options_trades_transactionId !== $original_transactionId) {
    
    $get_profit_loss = "SELECT (currentPrice - purchasePrice) * (contracts*100) AS pl FROM u511358360_stock_tracker.closed_options_trades WHERE transactionId=$closed_options_trades_transactionId";
    $result = $conn->query($get_profit_loss);

    if ($result->num_rows > 0) {
        $row = $result->fetch_row();
        $closedProfitLoss = $row[0];
    }
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisdi", $closed_options_trades_transactionId, $user_user_id, $user_username, $closedProfitLoss, $original_transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_closed_options_trades/user_closed_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>