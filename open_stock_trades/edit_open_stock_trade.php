<?PHP
include "../db_connect.php";

$sql = "SELECT * FROM open_stock_trades WHERE transactionId = (?)";

$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<form action="/open_stock_trades/update_open_stock_trade.php">
    <label for="dateOpened">Date Opened:</label></br>
    <input type="text" id="dateOpened" name="dateOpened" value="<?PHP echo $row[dateOpened]?>"></br>
    <label for="shares">Shares:</label></br>
    <input type="number" id="shares" name="shares" value="<?PHP echo $row[shares]?>"></br>
    <label for="ticker">Ticker:</label></br>
    <input type="text" id="ticker" name="ticker" value="<?PHP echo $row[ticker]?>"></br>
    <label for="purchasePrice">Purchase Price:</label></br>
    <input type="number" step="0.01" id="purchasePrice" name="purchasePrice" value="<?PHP echo $row[purchasePrice]?>"></br>
    <label for="currentPrice">Current Price:</label></br>
    <input type="number" step="0.01" id="currentPrice" name="currentPrice" value="<?PHP echo $row[currentPrice]?>"></br>
    <input type="hidden" id="transactionId" name="transactionId" value="<?PHP echo $row[transactionId]?>"></br>
    <input type="submit" value="Submit">
</form>