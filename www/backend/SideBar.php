<?php
    echo "<nav class=\"w3-sidebar w3-light-grey w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left w3-border\" style=\"z-index:3;width:250px;left:0\" id=\"mySidebar\">" .

         "<div class=\"w3-padding-64 w3-large w3-text-grey\" style=\"font-weight:bold;style=max-width: 239px\">" .

         "<a class=\"w3-bar-item w3-button w3-top w3-light-grey\" style=\"max-width: 239px\" href=\"http://localhost:80/HomePage.php\">Ace Training</a>";

    if (!isset($isHomePage) || !$isHomePage)
        echo "<a class=\"w3-bar-item w3-button\" style=\"max-width: 239px\" href=\"http://localhost:80/HomePage.php\">Home</a>";

    require "./Backend/Core.php";
    require "./Backend/GetUser.php";

    $UsrCourses = $usr["CourseIndexes"];
    $CourseIndexesValues = explode(",", $UsrCourses);

    // check the size of the array
    if ($CourseIndexesValues[0] == "") {
        echo "<div class=\"w3-bar-item\">No Courses</div>";
    } else {
        for ($i = 0; $i < count($CourseIndexesValues); $i++) {
            $sql = "SELECT * FROM courses WHERE ID = " . (int)$CourseIndexesValues[$i];
            $result = $conn->query($sql);

            if ($result->num_rows == 0)
                continue;
                        
            $courseData = $result->fetch_assoc();
                        
            echo "<a class=\"w3-bar-item w3-button\" style=\"max-width: 239px\" href=\"http://localhost:80/Course.php?CourseID=" . $courseData["ID"] . "\">" .
                 $courseData["Name"] .
                 "</a>";
        }
    }

    if ($usr["IsTeacher"] == 1 && isset($isHomePage) && $isHomePage)
        echo "<a class=\"w3-bar-item w3-button\" style=\"max-width: 239px\" href=\"http://localhost:80/CreateCourse.php\">Create New Course</a>";


    echo "<br>" .
         "<div class=\"w3-bottom w3-left w3-light-grey\" style=\"max-width: 239px\">" .
         "<a class=\"w3-bar-item w3-button\" style=\"max-width: 239px\" href=\"http://localhost:80/Profile.php\">Profile</a>" .
         "<a class=\"w3-bar-item w3-button\" style=\"max-width: 239px\" href=\"http://localhost:80/backend/Logout.php\">Logout</a>" .
         "</div>" .

         "</div></nav>" .

         "<header class=\"w3-bar w3-top w3-hide-large w3-black w3-xlarge\">" .
         "</header>" .
    
         "<div class=\"w3-overlay w3-hide-large w3-animate-opacity\" onclick=\"w3_close()\" style=\"cursor:pointer\" title=\"close side menu\" id=\"myOverlay\"></div>";
?>
