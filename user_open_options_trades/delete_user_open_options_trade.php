<?PHP
include "../db_connect.php";

$sql = "DELETE FROM user_open_options_trades WHERE open_options_trades_transactionId = (?)";

$open_stock_trades_transactionId = $_REQUEST["open_stock_trades_transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $open_options_trades_transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/user_open_options_trades/user_open_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>