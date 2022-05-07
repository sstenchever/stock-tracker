<?PHP
include "../db_connect.php";

$sql = "INSERT INTO closed_options_trades (dateClosed, contracts, ticker, contract_type, purchasePrice, sellPrice) VALUES(?,?,?,?,?,?)";

$dateClosed = $_REQUEST["dateClosed"];
$contracts = $_REQUEST["contracts"];
$ticker = $_REQUEST["ticker"];
$contract_type = $_REQUEST["contract_type"];
$purchasePrice = $_REQUEST["purchasePrice"];
$sellPrice = $_REQUEST["sellPrice"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssdd", $dateClosed, $contracts, $ticker, $contract_type, $purchasePrice, $sellPrice);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/closed_options_trades/closed_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>