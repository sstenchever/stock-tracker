<?PHP
include "../db_connect.php";

$sql = "INSERT INTO open_stock_trades (dateOpened, shares, ticker, purchasePrice, currentPrice) VALUES(?,?,?,?,?)";

$dateOpened = $_REQUEST["dateOpened"];
$shares = $_REQUEST["shares"];
$ticker = $_REQUEST["ticker"];
$purchasePrice = $_REQUEST["purchasePrice"];
$currentPrice = $_REQUEST["currentPrice"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsdd", $dateOpened, $shares, $ticker, $purchasePrice, $currentPrice);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/open_stock_trades/open_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>