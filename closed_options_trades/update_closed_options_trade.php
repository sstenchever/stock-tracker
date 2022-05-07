<?PHP
include "../db_connect.php";

$sql = "UPDATE closed_options_trades SET dateClosed = ?, contracts = ?, ticker = ?, contract_type = ?, purchasePrice = ?, sellPrice = ? WHERE transactionId = ?";

$dateClosed = $_REQUEST["dateClosed"];
$contracts = $_REQUEST["contracts"];
$ticker = $_REQUEST["ticker"];
$contract_type = $_REQUEST["contract_type"];
$purchasePrice = $_REQUEST["purchasePrice"];
$sellPrice = $_REQUEST["sellPrice"];
$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssddi", $dateClosed, $contracts, $ticker, $contract_type, $purchasePrice, $sellPrice, $transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/closed_options_trades/closed_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>