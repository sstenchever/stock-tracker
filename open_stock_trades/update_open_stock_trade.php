<?PHP
include "../db_connect.php";

$sql = "UPDATE open_stock_trades SET dateOpened = ?, shares = ?, ticker = ?, purchasePrice = ?, currentPrice = ? WHERE transactionId = ?";

$dateOpened = $_REQUEST["dateOpened"];
$shares = $_REQUEST["shares"];
$ticker = $_REQUEST["ticker"];
$purchasePrice = $_REQUEST["purchasePrice"];
$currentPrice = $_REQUEST["currentPrice"];
$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsddi", $dateOpened, $shares, $ticker, $purchasePrice, $currentPrice, $transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/open_stock_trades/open_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>