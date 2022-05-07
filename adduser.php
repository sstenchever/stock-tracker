<?PHP
include "db_connect.php";

$sql = "INSERT INTO user (firstname, lastname, username) VALUES(?,?,?)";

$fname = $_REQUEST["fname"];
$lname = $_REQUEST["lname"];
$username = $_REQUEST["username"];

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fname, $lname, $username);

if ($stmt->execute() === TRUE) {
    echo "<script>window.location.href = 'users.php'</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>