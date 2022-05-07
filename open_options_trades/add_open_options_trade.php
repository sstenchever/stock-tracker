<?PHP
include "../db_connect.php";

$sql = "INSERT INTO open_options_trades (dateOpened, contracts, ticker, contract_type, purchasePrice, currentPrice) VALUES(?,?,?,?,?,?)";

$dateOpened = $_REQUEST["dateOpened"];
$contracts = $_REQUEST["contracts"];
$ticker = $_REQUEST["ticker"];
$contract_type = $_REQUEST["contract_type"];
$purchasePrice = $_REQUEST["purchasePrice"];
$currentPrice = $_REQUEST["currentPrice"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdssdd", $dateOpened, $contracts, $ticker, $contract_type, $purchasePrice, $currentPrice);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = '/open_options_trades/open_options_trades.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>