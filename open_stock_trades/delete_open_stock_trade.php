<?PHP
include "../db_connect.php";

$sql = "DELETE FROM open_stock_trades WHERE transactionId = (?)";

$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/open_stock_trades/open_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>