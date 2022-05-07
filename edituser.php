<?PHP
include "db_connect.php";

$sql = "SELECT * FROM user WHERE user_id = (?)";

$user_id = $_REQUEST["user_id"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
}
?>

<form action="updateuser.php">
    <label for="fname">First Name:</label></br>
    <input type="text" id="fname" name="fname" value="<?PHP echo $row[firstname]?>"></br>
    <label for="lname">Last Name:</label></br>
    <input type="text" id="lname" name="lname" value="<?PHP echo $row[lastname]?>"></br>
    <label for="username">Username:</label></br>
    <input type="text" id="username" name="username" value="<?PHP echo $row[username]?>"></br>
    <input type="hidden" id="user_id" name="user_id" value="<?PHP echo $row[user_id]?>"></br>
    <input type="submit" value="Submit">
</form>