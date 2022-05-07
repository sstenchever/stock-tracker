<?php
include "db_connect.php";

$sql = "call create_open_stock_trade(?,?,?,?,?,@status)";

$username = $_REQUEST["username"];
$shares = $_REQUEST["shares"];
$ticker = $_REQUEST["ticker"];
$purchasePrice = $_REQUEST["purchasePrice"];
$currentPrice = $_REQUEST["currentPrice"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sdsdd", $username, $shares, $ticker, $purchasePrice, $currentPrice);
if ($stmt->execute() === TRUE) {
    $sql = "SELECT @status as status";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error; 
}

?>

<script type="text/Javascript"> window.alert("<?php echo $row["status"]; ?>"); </script>
<script>window.location.href = '/open_stock_trades/open_stock_trades.php'</script>