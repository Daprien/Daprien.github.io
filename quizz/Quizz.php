<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        .question {
            margin-bottom: 20px;
        }
        .answers {
            margin-left: 20px;
        }
        .answers div {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php
    // Database connection
    $dbname = "quiz.db";

    try {
        $conn = new SQLite3($dbname);
    } catch (Exception $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Fetch questions from the database
    $sql = "SELECT * FROM questions";
    $result = $conn->query($sql);

    if ($result) {
        $link = file_get_contents('page.txt');
        echo "<form method='post' action='" . htmlspecialchars($link) . "'>";
        while($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo "<div class='question'>";
            echo "<h2>" . htmlspecialchars($row["question"]) . "</h2>";
            $lien = htmlspecialchars($row["lien"]);
            if (strpos($lien, 'ladigitale.dev') !== false) {
                // Embed ladigitale.dev video
                echo "<iframe width='560' height='315' src='$lien' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe>";
            } elseif (preg_match('/\.(jpg|jpeg|png|gif)$/i', $lien)) {
                // Display image
                echo "<img src='$lien' alt='Image' width='560' height='315'>";
            }
            echo "<input type='hidden' name='questions[" . $row["id"] . "][correct_answer]' value='" . htmlspecialchars($row["reponseG"]) . "'>";
            echo "<div class='answers'>";
            echo "<div><input type='radio' name='questions[" . $row["id"] . "][answer]' value='1'>" . htmlspecialchars($row["reponse1"]) . "</div>";
            echo "<div><input type='radio' name='questions[" . $row["id"] . "][answer]' value='2'>" . htmlspecialchars($row["reponse2"]) . "</div>";
            echo "<div><input type='radio' name='questions[" . $row["id"] . "][answer]' value='3'>" . htmlspecialchars($row["reponse3"]) . "</div>";
            echo "<div><input type='radio' name='questions[" . $row["id"] . "][answer]' value='4'>" . htmlspecialchars($row["reponse4"]) . "</div>";
            echo "</div>";
            echo "</div>";
        }
        echo "<input type='submit' value='Submit'>";
        echo "</form>";
    } else {
        echo "0 results";
    }

    $conn->close();
    ?>
</body>
</html>
