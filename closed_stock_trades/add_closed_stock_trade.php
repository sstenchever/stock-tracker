<?PHP
include "../db_connect.php";

$sql = "INSERT INTO closed_stock_trades (dateClosed, shares, ticker, purchasePrice, sellPrice) VALUES(?,?,?,?,?)";

$dateClosed = $_REQUEST["dateClosed"];
$shares = $_REQUEST["shares"];
$ticker = $_REQUEST["ticker"];
$purchasePrice = $_REQUEST["purchasePrice"];
$sellPrice = $_REQUEST["sellPrice"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsdd", $dateClosed, $shares, $ticker, $purchasePrice, $sellPrice);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/closed_stock_trades/closed_stock_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>