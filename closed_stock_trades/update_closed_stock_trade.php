<?PHP
include "../db_connect.php";

$sql = "UPDATE closed_stock_trades SET dateClosed = ?, shares = ?, ticker = ?, purchasePrice = ?, sellPrice = ? WHERE transactionId = ?";

$dateClosed = $_REQUEST["dateClosed"];
$shares = $_REQUEST["shares"];
$ticker = $_REQUEST["ticker"];
$purchasePrice = $_REQUEST["purchasePrice"];
$sellPrice = $_REQUEST["sellPrice"];
$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsddi", $dateClosed, $shares, $ticker, $purchasePrice, $sellPrice, $transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/closed_stock_trades/closed_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>