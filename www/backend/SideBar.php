<?php
    echo "<nav class=\"w3-sidebar w3-light-grey w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left\" style=\"z-index:3;width:250px;left:0\" id=\"mySidebar\">" .

         "<div class=\"w3-container w3-display-container w3-padding-16 w3-top\" style=\"z-index:3;width:250px\">" .
         "<a class=\"w3-wide\" href=\"http://localhost:80/HomePage.php\">Ace Training</a>" .
         "</div>" .
    
         "<div class=\"w3-padding-64 w3-large w3-text-grey\" style=\"font-weight:bold\">";

    if (!isset($isHomePage) || $isHomePage != true)
        echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/HomePage.php\">Home</a>";

    $UsrCourses = $usr["CourseIndexes"];
    $CoursendexesValues = explode(",", $UsrCourses);

    // check size of array
    if ($CoursendexesValues[0] == "") {
        echo "<div class=\"w3-bar-item\">No Courses</div>";
    } else {
        for ($i = 0; $i < count($CoursendexesValues); $i++) {
            $sql = "SELECT * FROM courses WHERE ID = " . (int)$CoursendexesValues[$i];
            $result = $conn->query($sql);

            if ($result->num_rows == 0)
                continue;
                        
            $courseData = $result->fetch_assoc();
                        
            echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/Course.php?CourseID=" . $courseData["ID"] . "\">" .
                 $courseData["Name"] .
                 "</a>";
        }
    }

    if ($usr["IsTeacher"] == 1 && isset($isHomePage) && $isHomePage == true)
        echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/CreateCourse.php\">Create New Course</a>";

    echo "</div></nav>" .

         "<header class=\"w3-bar w3-top w3-hide-large w3-black w3-xlarge\">" .
         "<div class=\"w3-bar-item w3-padding-24 w3-wide\">LOGO</div>" .
         "<a href=\"javascript:void(0)\" class=\"w3-bar-item w3-button w3-padding-24 w3-right\" onclick=\"w3_open()\"><i class=\"fa fa-bars\"></i></a>" .
         "</header>" .
    
         "<div class=\"w3-overlay w3-hide-large w3-animate-opacity\" onclick=\"w3_close()\" style=\"cursor:pointer\" title=\"close side menu\" id=\"myOverlay\"></div>" .
    
         "<div class=\"w3-container w3-display-container w3-padding-16 w3-bottom\" style=\"z-index:3;width:250px;left:0\">" .
         "<a class=\"w3-wide\" href=\"http://localhost:80/Profile.php\">Profile</a><br>" .
         "<a class=\"w3-wide\" href=\"http://localhost:80/backend/Logout.php\">Logout</a>" .
         "</div>";
?>
