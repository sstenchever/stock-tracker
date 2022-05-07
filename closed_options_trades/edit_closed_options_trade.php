<?PHP
include "../db_connect.php";

$sql = "SELECT * FROM closed_options_trades WHERE transactionId = (?)";

$transactionId = $_REQUEST["transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $transactionId);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<form action="/closed_options_trades/update_closed_options_trade.php">
    <label for="dateClosed">Date Closed:</label></br>
    <input type="text" id="dateClosed" name="dateClosed" value="<?PHP echo $row[dateClosed]?>"></br>
    <label for="contracts">Contracts:</label></br>
    <input type="number" id="contracts" name="contracts" value="<?PHP echo $row[contracts]?>"></br>
    <label for="ticker">Ticker:</label></br>
    <input type="text" id="ticker" name="ticker" value="<?PHP echo $row[ticker]?>"></br>
    <label for="contract_type">Type:</label></br>
    <select id="contract_type" name="contract_type">
        <option value="CALL">CALL</option>
        <option value="PUT">PUT</option>
    </select>   
    </br>
    <label for="purchasePrice">Purchase Price:</label></br>
    <input type="number" step="0.01" id="purchasePrice" name="purchasePrice" value="<?PHP echo $row[purchasePrice]?>"></br>
    <label for="sellPrice">Sell Price:</label></br>
    <input type="number" step="0.01" id="sellPrice" name="sellPrice" value="<?PHP echo $row[sellPrice]?>"></br>
    <input type="hidden" id="transactionId" name="transactionId" value="<?PHP echo $row[transactionId]?>"></br>
    <input type="submit" value="Submit">
</form>