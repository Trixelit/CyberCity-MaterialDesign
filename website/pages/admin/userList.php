<?php include "../../includes/template.php";
/** @var $conn */

if (!authorisedAccess(false, false, true)) {
    header("Location:../../index.php");
}

?>
    <title>User List</title>
    <link rel="stylesheet" href="../../assets/css/moduleList.css">
    <h1>Enabled User List</h1>
<?php
$userList = $conn->query("SELECT ID, Username, AccessLevel, Enabled FROM Users WHERE Enabled=1"); #Get all Enabled Modules
while ($userData = $userList->fetch()) {
    $userID = $userData["ID"];
    echo "<div class='product_wrapper'>";
    echo "<div class='name'>" . $userData["Username"] . "</div>";
    echo "<a class='moduleButton' href='userEdit.php?UserID=" . $userID . "'>Edit</a>";
    echo "<a class='moduleButton' href='userResetPassword.php?UserID=" . $userID . "'>Password</a>";
    echo "</div>";
}

?>

