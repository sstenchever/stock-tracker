<?PHP
include "db_connect.php";

$sql = "UPDATE user SET firstname = ?, lastname = ?, username = ? WHERE user_id = ?";

$user_id = $_REQUEST["user_id"];
$fname = $_REQUEST["fname"];
$lname = $_REQUEST["lname"];
$username = $_REQUEST["username"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $fname, $lname, $username, $user_id);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = 'users.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>