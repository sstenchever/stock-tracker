<?PHP
header("Cache-Control: no-cache");
$servername = "localhost";
# Replace "REDACTED" with usernmae
$username = "REDACTED";
# Replace "REDACTED" with password
$password = "REDACTED";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
# Replace "REDACTED" with DB name
$conn->select_db("REDACTED");

?>