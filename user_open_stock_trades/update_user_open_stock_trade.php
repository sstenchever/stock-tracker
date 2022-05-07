<?PHP
include "../db_connect.php";

$sql = "UPDATE user_open_stock_trades SET open_stock_trades_transactionId = ?, user_user_id = ?, user_username = ?, openProfitLoss = ? WHERE open_stock_trades_transactionId = ?";

$open_stock_trades_transactionId = $_REQUEST["open_stock_trades_transactionId"];
$user_user_id = $_REQUEST["user_user_id"];
$user_username = $_REQUEST["user_username"];
$openProfitLoss = $_REQUEST["openProfitLoss"];
$original_transactionId = $_REQUEST["original_transactionId"];

if ($open_stock_trades_transactionId !== $original_transactionId) {
    
    $get_profit_loss = "SELECT (currentPrice - purchasePrice) * shares AS pl FROM u511358360_stock_tracker.open_stock_trades WHERE transactionId=$open_stock_trades_transactionId";
    $result = $conn->query($get_profit_loss);

    if ($result->num_rows > 0) {
        $row = $result->fetch_row();
        $openProfitLoss = $row[0];
    }
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("iisdi", $open_stock_trades_transactionId, $user_user_id, $user_username, $openProfitLoss, $original_transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_open_stock_trades/user_open_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>