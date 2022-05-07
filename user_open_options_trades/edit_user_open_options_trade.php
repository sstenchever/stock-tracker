<?PHP
include "../db_connect.php";

$sql = "SELECT * FROM user_open_options_trades WHERE open_options_trades_transactionId = (?)";

$open_options_trades_transactionId = $_REQUEST["open_options_trades_transactionId"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $open_options_trades_transactionId);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<form action="/user_open_options_trades/update_user_open_options_trade.php">
    <label for="open_options_trades_transactionId">Transaction ID:</label></br>
    <input type="number" id="open_options_trades_transactionId" name="open_options_trades_transactionId" value="<?PHP echo $row[open_options_trades_transactionId]?>"></br>
    <input type="hidden" id="user_user_id" name="user_user_id" value="<?PHP echo $row[user_user_id]?>">
    <label for="user_username">Username:</label></br>
    <input type="text" id="user_username" name="user_username" value="<?PHP echo $row[user_username]?>"></br>
    <input type="hidden" id="openProfitLoss" name="openProfitLoss" value="<?PHP echo $row[openProfitLoss]?>"></br>
    <input type="hidden" id="original_transactionId" name="original_transactionId" value="<?PHP echo $row[open_options_trades_transactionId]?>">
    <input type="submit" value="Submit">
</form>