<?PHP
include "../db_connect.php";

$sql = "DELETE FROM user_closed_stock_trades WHERE closed_stock_trades_transactionId = (?)";

$closed_stock_trades_transactionId = $_REQUEST["closed_stock_trades_transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $closed_stock_trades_transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_closed_stock_trades/user_closed_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>