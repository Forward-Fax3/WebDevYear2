<?php
    echo "<nav class=\"w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left\" style=\"z-index:3;width:250px\" id=\"mySidebar\">";

    echo "<div class=\"w3-container w3-display-container w3-padding-16\" style=\"z-index:3;width:250px\">";
    echo "<a class=\"w3-wide\" href=\"http://localhost:80/HomePage.php\">Ace Training</a>";
    echo "</div>";
    
    echo "<div class=\"w3-padding-64 w3-large w3-text-grey\" style=\"font-weight:bold\">";

    if (!isset($isHomePage) || $isHomePage != true)
        echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/HomePage.php\">Home</a>";

    $json = $usr["CourseIndexes"];
    $ClassIndexes = json_decode($json, true);
    $ClassIndexesValues = array_values($ClassIndexes)[0];

    for ($i = 0; $i < count($ClassIndexesValues); $i++) {
        $sql = "SELECT * FROM CourseData WHERE ID = " . (int)$ClassIndexesValues[$i];
        $result = $conn->query($sql);
                        
        if ($result->num_rows == 0) {
            $conn->close();
            die("no courses found");
        }
                        
        $courseData = $result->fetch_assoc();
                        
        echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/Course.php?CourseID=" . $courseData["ID"] . "\">";
        echo $courseData["CourseName"];
        echo "</a>";
        
//      $json = $courseData["CourseData"];
//      $json = json_decode($json, false);

//      echo "<p id=description>Description: " . $json->Description . "</p><br>";
    }

    if ($usr["IsTeacher"] == 1 && isset($isHomePage) && $isHomePage == true)
        echo "<a class=\"w3-bar-item w3-button\" href=\"http://localhost:80/CreateCourse.php\">Create New Course</a>";

    echo "</div>";
    
    echo "<div class=\"w3-container w3-display-container w3-padding-16 w3-bottom\" style=\"z-index:3;width:250px\">";
    echo "<a class=\"w3-wide\" href=\"http://localhost:80/backend/Logout.php\">Logout</a>";
    echo "</div>";
    
    echo "</nav>";
    
    echo "<div class=\"w3-overlay w3-hide-large w3-animate-opacity\" onclick=\"w3_close()\" style=\"cursor:pointer\" title=\"close side menu\" id=\"myOverlay\"></div>";
?>
