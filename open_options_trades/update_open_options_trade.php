<?PHP
include "../db_connect.php";

$sql = "UPDATE open_options_trades SET dateOpened = ?, contracts = ?, ticker = ?, contract_type = ?, purchasePrice = ?, currentPrice = ? WHERE transactionId = ?";

$dateOpened = $_REQUEST["dateOpened"];
$contracts = $_REQUEST["contracts"];
$ticker = $_REQUEST["ticker"];
$contract_type = $_REQUEST["contract_type"];
$purchasePrice = $_REQUEST["purchasePrice"];
$currentPrice = $_REQUEST["currentPrice"];
$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssddi", $dateOpened, $contracts, $ticker, $contract_type, $purchasePrice, $currentPrice, $transactionId);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/open_options_trades/open_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>