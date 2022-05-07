<?PHP
include "db_connect.php";

$sql = "SELECT username FROM user";
$result = $conn->query($sql);
$username = $result->fetch_all(MYSQLI_ASSOC);
?>

<form action='create_open_stock_trade_srv.php'>
    <label for="username">Username:</label></br>
    <select id="username" name="username">
    <?PHP
    for ($i=0;$i<count($username);$i++)
    {
        echo '<option value = "' . $username[$i]["username"];
        echo '">';
        echo $username[$i]["username"] . "</option>";
    }
    ?>
    </select></br>
    <label for="shares">Shares:</label></br>
    <input type="number" id="shares" name="shares"></br>
    <label for="ticker">Ticker:</label></br>
    <input type="text" id="ticker" name="ticker"></br>
    <label for="purchasePrice">Purchase Price:</label></br>
    <input type="number" step="0.01" id="purchasePrice" name="purchasePrice"></br>
    <label for="currentPrice">Current Price:</label></br>
    <input type="number" step="0.01" id="currentPrice" name="currentPrice"></br>
    <input type="submit" value="Submit">
</form>

<?PHP
$conn->close();
?>