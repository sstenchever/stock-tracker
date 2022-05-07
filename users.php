<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<script src="menu.js"></script>

<body>
<div class="container overflow-hidden" style="padding: 1em;">
<?PHP
include "db_connect.php";

$sql = "SELECT * FROM u511358360_stock_tracker.user";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table class='table table-dark table-striped' border=1><tr><th>First Name</th><th>Last Name</th><th>Username</th><th></th><th></th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td>" . $row["username"] . "</td>";
        echo "<td>" . "<a href='deleteuser.php?user_id=" . $row["user_id"] . "'>Del</a>" . "</td>";
        echo "<td>" . "<a href='edituser.php?user_id=" . $row["user_id"] . "'>Edit</a>" . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();

?>
<a href="adduser.htm">Add User</a></br>

</div>
</body>