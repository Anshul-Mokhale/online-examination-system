<?php
// Include the file containing your database connection
include "../components/includes/connection.php";

// Get the JSON data from the request body
$jsonData = file_get_contents('php://input');

// Decode the JSON data into an associative array
$data = json_decode($jsonData, true);

// Check if examId exists in the decoded JSON data
if (isset($data['examId'])) {
    // Sanitize the input to prevent SQL injection
    $examId = mysqli_real_escape_string($mysql_connection, $data['examId']);

    // Prepare the SQL statement to fetch the sections for the exam
    $sql = "SELECT * FROM sections WHERE id = '$examId'";

    // Perform the query to fetch sections
    $result = mysqli_query($mysql_connection, $sql);

    // Initialize an empty array to store exam data
    $examData = array();

    // Check if there are results
    if (mysqli_num_rows($result) > 0) {
        // Loop through each section
        while ($row = mysqli_fetch_assoc($result)) {
            // Get the section data
            $sectionId = $row['sr'];

            // Prepare the SQL statement to fetch questions for this section
            $sqlQuestions = "SELECT * FROM question_$examId WHERE section = '$sectionId'";

            // Perform the query to fetch questions for this section
            $resultQuestions = mysqli_query($mysql_connection, $sqlQuestions);

            // Initialize an empty array to store questions for this section
            $questions = array();

            // Check if there are questions for this section
            if (mysqli_num_rows($resultQuestions) > 0) {
                // Loop through each question for this section
                while ($questionRow = mysqli_fetch_assoc($resultQuestions)) {
                    // Add the question to the $questions array
                    $questions[] = $questionRow;
                }
            }

            // Add the section data along with questions to the $examData array
            $row['questions'] = $questions;
            $examData[] = $row;
        }
    }

    // Encode the $examData array to JSON format
    $response = json_encode($examData);

    // Output the JSON data
    echo $response;
} else {
    // If examId is not provided in the JSON data, return an error message
    echo json_encode(array('error' => 'No examId provided in JSON data'));
}
?>