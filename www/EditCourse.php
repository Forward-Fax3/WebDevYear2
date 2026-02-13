<?php
    session_start();
    if (!isset($_SESSION["ID"])) {
        header("Location: http://localhost:80/backend/Logout.php?reson=Invalid%20Session.<br>Please%20login%20again.");
    }

    if (!isset($_COOKIE["ID"])) {
        setcookie("ReturnURL", "http://localhost:80/EditCourse.php?CourseID=" . $_GET["CourseID"], time() + (3600 * 24), "/");
        header("Location: http://localhost:80/backend/Logout.php?reson=Automaticly%20Logout%20due%20to%20timeout.<br>Please%20login%20again.");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";

    if (!isset($_GET["CourseID"])) {
        header("Location: http://localhost:80/HomePage.php");
    }

    $usrCourses = explode(",", $usr["CourseIndexes"]);
    $usrCourses = array_filter($usrCourses, "is_numeric");

    // check if the user has access to the course
    if (!in_array($_GET["CourseID"], $usrCourses)) {
        header("Location: http://localhost:80/HomePage.php");
    }

    require "./backend/Core.php";
    require "./Backend/GetUser.php";
    
    if ($usr["IsTeacher"] == 0) {
        header("Location: http://localhost:80/HomePage.php");
    }
?>

<!Doctype html>
<html lang="en">
    <head>
        <title>Ace Training</title>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            .w3-sidebar a {font-family: "Roboto", sans-serif}
            body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
        </style>
        <script src="./backend/JS/SideBar.js"></script>
        <script src="./JS/EditCourse.js"></script>
    </head>
    <body class="w3-content w3-light-grey">
        <?php
            include "./Backend/SideBar.php";

            $sql = "SELECT * FROM Courses WHERE ID = " . (int)$_GET["CourseID"];
            $result = $conn->query($sql);
            
            if ($result->num_rows == 0) {
                $conn->close();
                die("no course found");
            }
            
            $courseData = $result->fetch_assoc();
        ?>
        <form action="javascript:EditCourse()" class="w3-bar w3-container w3-bordery w3-padding">
            <p id="error" class="w3-text-red" hidden></p>
            <header class="w3-container w3-xlarge w3-left" style="width:100%">
                <h1 class="w3-left w3-wide">
                    <label for="Name">Name:</label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" id="Name" value="<?php echo $courseData["Name"]; ?>">
                </h1>
                <div class="w3-right w3-padding">
                    <!--
                    <i class="fa fa-search"></i>
                    TODO: if have time add search
                    -->
                </div>
            </header>
            <div class="w3-section w3-container w3-left w3-wide" style="width:100%">
                <h2 class="w3-wide" style="width:100%">
                    <label for="Description">
                        Description:
                    </label>
                </h2>
                <textarea class="w3-input w3-text w3-border w3-wide" id="Description" rows="8" maxlength="65535" style="min-width:100%"><?php echo $courseData["Description"]; ?></textarea>
            </div>
            <div class="w3-section w3-container w3-left w3-wide" style="width:100%">
                <div class="" style="left:250px">
                    <?php
                        $dataID = $courseData["FirstData"];
                        $elementNumber = -1;
                        while ($dataID != NULL) {
                            $elementNumber++;
                            $sql = "SELECT * FROM CourseData WHERE ID = " . (int)$dataID;
                            $result = $conn->query($sql);
                            $data = $result->fetch_assoc();
                            $dataID = $data["NextID"];
                            $element = "Element" . $elementNumber;

                            echo "<div class=\"w3-section w3-container w3-left w3-wide\" style=\"width:100%\"><br>";
                            switch ($data["Type"]) {
                                case 0: // text
                                {
                                    echo "<label for=\"" . $element . "\">" . $data["Name"] . "</label><br>" .
                                            "<textarea class=\"w3-input w3-text w3-border w3-wide\" id=". $element . ">" . $data["Data"] . "</textarea>";
                                    break;
                                }
                                case 1: // file
                                {
                                    $fileData = json_decode($data["Data"]);
                                    echo "<label for=\"" . $element . "\">" . $data["Name"] . "</label><br>" .
                                            "<a href=\"http://localhost:80/backend/DownloadFile.php?FileID=" . $data["ID"] . "\" id=\"" . $element . "\" class=\"w3-button w3-block w3-blue w3-bar-item\" style=\"width:100%\" type=\"button\">Download: " . $fileData->Name . "</a>";
                                    break;
                                }
                            }
                            echo "<br><button onclick=\"javascript:RemoveElement(" . $elementNumber . ")\" class=\"w3-button w3-block w3-red w3-bar-item\" style=\"width:100px\" type=\"button\">Remove</button><br><br>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div hidden id="currentElementID"><?php echo $elementNumber + 1; ?></div>
                <button class="w3-button w3-block w3-section w3-padding w3-green" type="submit">Save</button>
            </div>
        </form>
        <div class="w3-left" style="width:49%">
            <a href="./AddTextToCourse.php?CourseID=<?php echo $_GET["CourseID"] ?>" class="w3-button w3-block w3-section w3-padding w3-red" type="button">add text</a>
        </div>
        <div class="w3-right" style="width:49%">
            <a href="./AddFileToCourse.php?CourseID=<?php echo $_GET["CourseID"] ?>" class="w3-button w3-block w3-section w3-padding w3-red" type="button">add file</a>
        </div>
        <!-- users -->
        <form class="" style="max-width: 100%" id="userForm">
            <h4 style="max-width: 100%">Users</h4>
            <?php
                $users = $courseData["Users"];
                $users = explode(",", $users);
                $users = array_filter($users, "is_numeric");
                foreach ($users as $usr) {
                    if ($usr == NULL || $usr == $_SESSION["ID"]) {
                        continue;
                    }
                    $sql = "SELECT * FROM usrs WHERE ID = " . (int)$usr;
                    $result = $conn->query($sql);
                    $usrData = $result->fetch_assoc();
                    echo "<div class=\"w3-left w3-margin w3-box\" style=\"max-width: 100%\">" . $usrData["Fname"] . " " . $usrData["Surname"] . ", " . $usrData["Email"] . "</div>" .
                            "<div class=\"w3-left\" style=\"max-width=300px\">";

                    if ((int)$usrData["IsTeacher"] == 1) {
                        echo "<button onclick=\"javascript:MakeStudent(" . $usr . ")\" class=\"w3-button w3-block w3-blue w3-bar-item\" style=\"width:150px\" type=\"button\">Make Student</button>";
                    } else {
                        echo "<button onclick=\"javascript:MakeTeacher(" . $usr . ")\" class=\"w3-button w3-block w3-green w3-bar-item\" style=\"width:150px\" type=\"button\">Make Teacher</button>";
                    }

                    echo "<button onclick=\"javascript:RemoveUser(" . $usr . ")\" class=\"w3-button w3-block w3-red w3-bar-item w3-right\" style=\"width:100px\" type=\"button\">Remove</button></div><br><br><br><br>";
                }
            ?>
            <br>
        </form>
        <h4>Add User</h4>
        <form action="javascript:AddUser()" class="w3-container w3-border w3-padding w3-left w3-margin" id="AddUserForm">
            <label for="Fname">First name:</label>
            <input class="w3-input w3-border w3-margin-bottom" onkeyup="javascript:UserSearch()" id="Fname" type="text" placeholder="first name">
            <label for="Surname">surname:</label>
            <input class="w3-input w3-border w3-margin-bottom" onkeyup="javascript:UserSearch()" id="Surname" type="text" placeholder="surname">
            <label for="Email">Email:</label>
            <input class="w3-input w3-border w3-margin-bottom" onkeyup="javascript:UserSearch()" id="Email" type="text" placeholder="email">
            <label for="UsrID">ID:</label>
            <input class="w3-input w3-border w3-margin-bottom" onkeyup="javascript:UserSearch()" id="UsrID" type="text" placeholder="ID">
            <button class="w3-button w3-block w3-section w3-padding w3-green" type="submit" id="AddUserButton" disabled>Add</button>
        </form>
        <div id="SearchResults"></div>
        <div class="w3-container w3-left w3-bar w3-padding w3-grey w3-magin">
            <a class="w3-button w3-black" href="http://localhost:80/backend/DeleteCourse.php?CourseID=<?php echo $courseData["ID"]; ?>">Delete Course</a>
        </div>
    </body>
</html>
<?php $conn->close(); ?>
