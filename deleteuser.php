<?PHP
include "db_connect.php";

$sql = "DELETE FROM user WHERE user_id = (?)";

$user_id = $_REQUEST["user_id"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = 'users.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>