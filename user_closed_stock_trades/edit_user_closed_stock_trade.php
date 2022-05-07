<?PHP
include "../db_connect.php";

$sql = "SELECT * FROM user_closed_stock_trades WHERE closed_stock_trades_transactionId = (?)";

$closed_stock_trades_transactionId = $_REQUEST["closed_stock_trades_transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $closed_stock_trades_transactionId);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<form action="/user_closed_stock_trades/update_user_closed_stock_trade.php">
    <label for="closed_stock_trades_transactionId">Transaction ID:</label></br>
    <input type="number" id="closed_stock_trades_transactionId" name="closed_stock_trades_transactionId" value="<?PHP echo $row[closed_stock_trades_transactionId]?>"></br>
    <input type="hidden" id="user_user_id" name="user_user_id" value="<?PHP echo $row[user_user_id]?>">
    <label for="user_username">Username:</label></br>
    <input type="text" id="user_username" name="user_username" value="<?PHP echo $row[user_username]?>"></br>
    <input type="hidden" id="closedProfitLoss" name="closedProfitLoss" value="<?PHP echo $row[closedProfitLoss]?>"></br>
    <input type="hidden" id="original_transactionId" name="original_transactionId" value="<?PHP echo $row[closed_stock_trades_transactionId]?>">
    <input type="submit" value="Submit">
</form>