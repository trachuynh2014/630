<?php
$id = $_GET['id']; // get id through query string
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "testnew";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$del="delete from art_work where id = '$id'";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if ($conn->query($del) === TRUE) {

    $conn->close();
    header("location:index.php"); // redirects to all records page
    exit;
} else {
    $conn->close();
    echo "Error deleting record"; // display error message if not delete
    echo "<br/><a href='index.php'>Return to homepage</a>";
}
?>