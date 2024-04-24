<?php include "../../includes/template.php";
/** @var $conn */


if (!authorisedAccess(false, false, true)) {
    header("Location:../../index.php");
}

?>

<title>User Edit</title>


<?php
if (isset($_GET["UserID"])) {
    $userToLoad = $_GET["UserID"];
    $sql = $conn->query("SELECT * FROM Users WHERE ID= " . $userToLoad);
    $userInformation = $sql->fetch();
    $userID = $userInformation["ID"];
    $userHashedPassword = $userInformation["HashedPassword"];
    $userName = $userInformation["Username"];
    $userAccessLevel = $userInformation["AccessLevel"];
    $userEnabled = $userInformation["Enabled"];
    $userScore = $userInformation["Score"];
} else {
    header("location:userList.php");
}
//function enableUser(){
//    echo "123";
//    $userEnabled = 1;
//
//}

?>


<h1>Edit User Information</h1>

<form action="userEdit.php?UserID=<?= $userToLoad ?>" method="post" enctype="multipart/form-data">
    <div class="container-fluid">
        <div class="row">
            <!--Customer Details-->
            <div class="col-md-6">
                <h2>User Details</h2>
                <p>User Name<label>
                        <input type="text" name="userName" class="form-control" required="required"
                               value="<?= $userName ?>">
                    </label></p>
<!--                <p>Password-->
<!--                    <label>-->
<!--                        <input type="text" name="password" class="form-control" required="required"-->
<!--                               value="--><?php //= $userHashedPassword ?><!--">-->
<!--                    </label></p>-->
            </div>
            <div class="col-md-6">
                <h2>More Details</h2>
                <!--Product List-->
                <p>Access Level
                    <label>
<!--                        <input type="text" name="AccessLevel" class="form-control" required="required"-->
<!--                               value="--><?php //= $userAccessLevel ?><!--">-->
                        <?php
                        if ($userAccessLevel == 1){
                        ?>
                        <select name="AccessLevel" size="1">
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                        <?php
                        }
                        if ($userAccessLevel == 2){
                        ?>
                        <select name="AccessLevel" size="1">
                            <option value="2">Admin</option>
                            <option value="1">User</option>
                        </select>
                        <?php
                        }
                        ?>
                    </label></p>

                <p>Enabled/Disabled
                    <label>
                        <?php
                        if ($userEnabled == 0){
                        ?>
                        <select name="Enabled" size="1">
                            <option value="0">Disable</option>
                            <option value="1">Enable</option>
                        </select>
                        <?php
                        }
                        if ($userEnabled == 1){
                        ?>
                        <select name="Enabled" size="1">
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                        </select>
                        <?php
                        }
                        ?>
                    </label></p>
                <p>Current Score
                    <label>
                        <input type="text" name="Score" class="form-control" required="required"
                               value="<?= $userScore ?>">
                    </label></p>

            </div>
        </div>
    </div>
    <input type="submit" name="formSubmit" value="Update">
</form>


<!-- If the user presses update, this code runs-->

<?php
// Back End
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = sanitise_data($_POST["userName"]);
//    $userPassword = sanitise_data($_POST["moduleLocation"]);
    $userAccessLevel = sanitise_data($_POST["AccessLevel"]);
    $userEnabled = sanitise_data($_POST["Enabled"]);
    $userScore = sanitise_data($_POST["Score"]);
//    $userHashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $userToLoad = $_GET["UserID"];

    $sql = "UPDATE Users SET Username= :newusername, AccessLevel= :newaccesslevel, Enabled= :newEnabled, Score=:newscore WHERE ID ='$userToLoad'";
    //$sql = "INSERT INTO `RegisteredModules` (Location, Module, HashedAPIKey, Enabled) VALUES (:newLocation, :newModule, :newHashedAPIkey, :enabled)";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":newusername", $userName);
//    $stmt->bindValue(":newpassword", $userHashedPassword);
    $stmt->bindValue(":newaccesslevel", $userAccessLevel);
    $stmt->bindValue(":newEnabled", $userEnabled);
    $stmt->bindValue(":newscore", $userScore);

    $stmt->execute();

//    header("location:moduleInformation.php?ModuleID=$moduleToLoad");

}
?>




<?php
/*echo '<h2 class="text-danger">Debug Information. Comment out as necessary</h2><pre>';
print_r($moduleInformation);
echo '</pre>';


*/ ?>


