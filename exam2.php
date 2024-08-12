<?php
include_once ('components/includes/connection.php');
include_once ('components/includes/function.php');
include_once ('components/header.php');
$msg = '';
if (isset($_GET['ab'])) {
    $msg = $_GET['ab'];
    $studId = $_GET['id'];
    $examId = $_GET['examId'];

} else {
    $msg = "";
}
$sid = htmlspecialchars($_GET['id']);
$vauesd = htmlspecialchars($_GET['examId']);
$no = htmlspecialchars($_GET['no']);
echo $no;
echo $vauesd;
// echo $vauesd;
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Exam</title>
    <link rel="stylesheet" href="exam.css">
</head>

<body>
    <nav class="NavBar">
        <img src="assets/images/IMAGELOGO.svg" alt=""> Test Exam 1
        <a class="nav-link" style="color:white;">
            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
        </a>
    </nav>


    <div class="row" style="height: 88vh; text-align:justify;">
        <div class="col-9">
            <div class="navi">
                <li class="first">
                    <p>Section</p>
                    <h6 id="timer">Time Limit:</h6>
                </li>
                <li class="first" style="border-top:1px solid black; border-bottom:1px solid black;">
                    <div class="acr">
                        <a href="#" id="prev-section-button"><i class="fa-solid fa-caret-left"></i></a>
                        <h6 id="section" style="padding:5px; background-color: #4973bd; color:white; margin:0;">
                        </h6>
                    </div>
                    <div class="last">
                        <a href="#" id="next-section-button"><i class="fa-solid fa-caret-right"></i></a>
                    </div>
                </li>
                <li class="first">
                    <p>question type: MCQs</p>
                </li>
                <li class="NavBar" id="qno">

                </li>
            </div>
            <div class="bodde">
                <form id="questionForm">

                    <div id="sections-container">
                        <!-- Divs will be dynamically added here -->
                    </div>
                </form>
            </div>
            <div class="botom">
                <div class="lefto">
                    <button id="mark-review">Mark as Review & next</button>
                    <button class="clearbutton">Clear response</button>
                </div>
                <div class="rightto">
                    <button id="nexxt">save & next</button>
                </div>
            </div>
        </div>
        <div class="col-3 user">
            <div class="top1">
                <?php
                $sdtuid = $_GET['id'];
                $studimg = "SELECT * FROM students WHERE id = '$sdtuid'";
                $reesult = $mysql_connection->query($studimg);
                if ($reesult->num_rows > 0) {
                    $row = $reesult->fetch_assoc();
                    $path = $row['Simage']; // Assuming the image path is fetched from the database
                    // Replace '../' with 'admin/'
                    $path = str_replace('..', 'admin', $path);
                    // // Output the modified path
                    // echo $path;
                }
                ?>
                <div class="cc">
                    <img src="<?= $path ?>" alt="">
                </div>
                <div class="value">
                    <h3>
                        <?= $row['name'] ?>
                    </h3>
                    <p>
                        <?= $row['phone'] ?>
                    </p>
                </div>
            </div>
            <div id="sidebar" class="pp"></div>
            <a class="submitBtn" id="subBtn">Submit Test</a>
        </div>
    </div>
    <?php

    $vd = "SELECT timeLimit FROM demoexam WHERE id = '$vauesd'";
    $re = $mysql_connection->query($vd);
    if ($re->num_rows > 0) {
        $res = $re->fetch_assoc();
    }
    $tim = $res['timeLimit'];
    ?>

    <script>


        document.addEventListener('DOMContentLoaded', function () {
            var timeLimit = 60 * <?= $tim ?>; // 60 minutes

            // Function to update the timer
            // Function to update the timer
            function updateTimer() {
                var minutes = Math.floor(timeLimit / 60);
                var seconds = timeLimit % 60;
                var timerDisplay = document.getElementById('timer');
                // console.log("Timer Display Element:", timerDisplay); // Debugging
                if (timerDisplay) {
                    timerDisplay.textContent = 'Time Left: ' + (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                } else {
                    console.error("Timer display element not found."); // Debugging
                }

                // Decrement timeLimit every second
                if (timeLimit > 0) {
                    timeLimit--;
                    setTimeout(updateTimer, 1000); // Update every second
                } else {
                    // When time runs out, submit the answers
                    submitAnswers2();
                }
            }


            updateTimer();
            var fullscreenButton = document.getElementById('fullscreen-button');
            var sectionContainer = document.getElementById('sections-container');
            var saveAndNextButton = document.getElementById('nexxt');
            var markReviewButton = document.getElementById('mark-review');

            var secHead = document.getElementById('section');
            var showNum = document.getElementById('qno');
            var sbmt = document.getElementById('subBtn');
            var sections = [];
            var exam = <?= $vauesd ?>;
            var sid = <?= $sid ?>;
            var pno = <?= $no ?>;
            console.log(pno);


            function fetchSectionsData() {
                var url = 'BackendAPI/getQuesti2.php'; // Modify the URL with your endpoint
                var params = {
                    method: 'POST',
                    body: JSON.stringify({ examId: exam })
                };

                fetch(url, params)
                    .then(response => response.json())
                    .then(data => {
                        // Parse choices property from JSON to array for each question
                        data.forEach(section => {
                            section.questions.forEach(question => {
                                question.choices = JSON.parse(question.choices);
                            });
                        });

                        // Assign fetched sections data to the sections variable
                        sections = data;
                        console.log(sections);
                        // Show the first section and its first question when the data is fetched
                        showCurrentSection();
                        updateSidebar(currentSectionIndex);
                    })
                    .catch(error => {
                        console.error('Error fetching sections data:', error);
                        // Handle errors if needed
                    });
            }
            fetchSectionsData();

            var currentSectionIndex = 0;
            var currentQuestionIndex = 0;
            var answers = {}; // Object to store user answers
            var unanswers = {};
            var markUnanswer = {};
            var markAnswer = {};
            // Function to show the current section and its questions
            function showCurrentSection() {
                sectionContainer.innerHTML = ""; // Clear previous content

                var currentSection = sections[currentSectionIndex];

                // Update section heading
                secHead.textContent = currentSection.name;

                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Display description if present
                if (currentQuestion.description) {
                    var descriptionDiv = document.createElement('div');
                    descriptionDiv.classList.add('description');
                    descriptionDiv.innerHTML = "<strong>Description:</strong> " + currentQuestion.description;
                    sectionContainer.appendChild(descriptionDiv);
                }

                // Update question number
                var questionNumber = currentQuestionIndex + 1;
                // Update question number display
                showNum.innerHTML = "<strong>Question No: </strong>" + questionNumber;

                // Create elements for question and choices
                var questionDiv = document.createElement('div');
                questionDiv.classList.add('question');
                questionDiv.innerHTML = currentQuestion.question;

                // Append question to section container
                sectionContainer.appendChild(questionDiv);

                // Create radio buttons for choices
                if (currentQuestion.choices.length > 0) {
                    var choicesContainer = document.createElement('div');
                    choicesContainer.classList.add('choices-grid'); // Use a grid layout for choices

                    currentQuestion.choices.forEach(function (choice, index) {
                        var choiceWrapper = document.createElement('div');
                        choiceWrapper.classList.add('choice-wrapper'); // Wrapper for each choice

                        var choiceInput = document.createElement('input');
                        choiceInput.setAttribute('type', 'radio');
                        choiceInput.setAttribute('name', 'choice');
                        choiceInput.setAttribute('value', choice.value);
                        choiceInput.setAttribute('id', 'choice' + index);

                        // Check if the choice is the previously selected one
                        if (answers[currentSection.name] && answers[currentSection.name][currentQuestion.question] === choice.value) {
                            choiceInput.setAttribute('checked', 'checked');
                        }

                        // Append the input element
                        choiceWrapper.appendChild(choiceInput);

                        // Determine if choice is text or image
                        if (choice.type === 'image') {
                            var choiceImage = document.createElement('img');
                            choiceImage.setAttribute('src', 'admin/' + choice.value); // Add 'admin/' prefix here
                            choiceImage.setAttribute('alt', 'Choice Image ' + (index + 1));
                            choiceImage.classList.add('choice-image'); // Add a class for styling
                            choiceImage.style.width = '100px'; // Adjust the size as needed
                            choiceImage.style.height = '100px';
                            var choiceLabel = document.createElement('label');
                            choiceLabel.setAttribute('for', 'choice' + index);
                            choiceLabel.appendChild(choiceImage); // Append image to label
                        } else {
                            var choiceLabel = document.createElement('label');
                            choiceLabel.setAttribute('for', 'choice' + index);
                            choiceLabel.textContent = choice.value;
                        }

                        // Append choice label to choiceWrapper
                        choiceWrapper.appendChild(choiceLabel);

                        // Append choiceWrapper to choicesContainer div
                        choicesContainer.appendChild(choiceWrapper);
                    });

                    // Append choicesContainer div to section container
                    sectionContainer.appendChild(choicesContainer);
                }

                // Update sidebar with current section's questions
                updateSidebar(currentSectionIndex);
            }


            function saveAnswer(answer) {
                // Find the selected choice
                // var selectedChoice = document.querySelector('input[name="choice"]:checked');
                // var answer = selectedChoice ? selectedChoice.value : '';

                // Get the current section and question
                var currentSection = sections[currentSectionIndex];
                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Check if the section exists in answers, if not create it
                if (!answers[currentSection.name]) {
                    answers[currentSection.name] = {};
                }

                // Store the answer for the current question in the answers object
                answers[currentSection.name][currentQuestion.question] = answer;
            }

            function saveMarkAnswer(answer) {
                var currentSection = sections[currentSectionIndex];
                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Check if the section exists in answers, if not create it
                if (!markAnswer[currentSection.name]) {
                    markAnswer[currentSection.name] = {};
                }

                // Store the answer for the current question in the answers object
                markAnswer[currentSection.name][currentQuestion.question] = answer;
            }

            function saveUnAnswer() {
                // var selectedChoice = document.querySelector('input[name="choice"]:checked');
                // var answer = selectedChoice ? selectedChoice.value : '';

                // Get the current section and question
                var currentSection = sections[currentSectionIndex];
                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Check if the section exists in answers, if not create it
                if (!unanswers[currentSection.name]) {
                    unanswers[currentSection.name] = {};
                }

                // Store the answer for the current question in the answers object
                unanswers[currentSection.name][currentQuestion.question] = "";
            }

            function markUnAnswer() {
                // var selectedChoice = document.querySelector('input[name="choice"]:checked');
                // var answer = selectedChoice ? selectedChoice.value : '';

                // Get the current section and question
                var currentSection = sections[currentSectionIndex];
                var currentQuestion = currentSection.questions[currentQuestionIndex];

                // Check if the section exists in answers, if not create it
                if (!markUnAnswer[currentSection.name]) {
                    markUnanswer[currentSection.name] = {};
                }

                // Store the answer for the current question in the answers object
                markUnanswer[currentSection.name][currentQuestion.question] = "";
            }

            var prevSectionButton = document.getElementById('prev-section-button');
            prevSectionButton.addEventListener('click', function () {
                // Decrement currentSectionIndex to move to the previous section
                if (currentSectionIndex > 0) {
                    currentSectionIndex--;
                    // Show the current section
                    if (confirm("Are you sure you want to Change the section?")) {
                        showCurrentSection();
                    }
                } else {
                    // Display alert if already on the first section
                    alert("You are already on the first section.");
                }
            });

            // Event listener for the "Next Section" button
            var nextSectionButton = document.getElementById('next-section-button');
            nextSectionButton.addEventListener('click', function () {
                // Increment currentSectionIndex to move to the next section
                if (currentSectionIndex < sections.length - 1) {
                    currentSectionIndex++;
                    // Show the current section
                    if (confirm("Are you sure you want to Change the section?")) {
                        showCurrentSection();
                    }
                } else {
                    // Display alert if already on the last section
                    alert("You are already on the last section.");
                }
            });
            // Event listener for the "Save and Next" button
            let confirmedSectionChange = false; // Add this variable to track confirmation

            saveAndNextButton.addEventListener('click', function () {
                // Save the answer before moving to the next question

                var selectedChoice = document.querySelector('input[name="choice"]:checked');
                var answer = selectedChoice ? selectedChoice.value : '';
                saveAnswer(answer);
                var currentSection = sections[currentSectionIndex];
                var currentQuestion = currentSection.questions[currentQuestionIndex];
                if (answers[currentSection.name] && markAnswer[currentSection.name]) {
                    // Check if the question exists in both `answers` and `markAnswer`
                    if (answers[currentSection.name][currentQuestion.question] && markAnswer[currentSection.name][currentQuestion.question]) {
                        delete markAnswer[currentSection.name][currentQuestion.question];
                    }
                }


                if (answer == '') {
                    saveUnAnswer();
                }

                // Check if it's the last question in the current section
                if (currentQuestionIndex < sections[currentSectionIndex].questions.length - 1) {
                    // Move to the next question
                    currentQuestionIndex++;
                    // Show the next question
                    showCurrentSection();
                } else {
                    // Check if it's the last section and last question
                    if (currentSectionIndex === sections.length - 1 && currentQuestionIndex === sections[currentSectionIndex].questions.length - 1) {
                        // Handle submission via AJAX
                        // submitAnswers();
                        sbmt.style.display = "block";
                        sbmt.onclick = submitAnswers;

                    } else {
                        // Check if the user has confirmed the section change
                        if (!confirmedSectionChange) {
                            // If not confirmed, prompt for confirmation
                            if (confirm("Do you want to proceed to the next section?")) {
                                // If confirmed, set the variable to true
                                confirmedSectionChange = true;
                            } else {
                                // If not confirmed, return without proceeding
                                return;
                            }
                        }

                        // Reset the confirmedSectionChange flag for the next section
                        confirmedSectionChange = false;

                        // Move to the next section
                        var previousSectionIndex = currentSectionIndex;
                        currentQuestionIndex = 0;
                        currentSectionIndex++;

                        // If section changed, show confirmation
                        if (previousSectionIndex !== currentSectionIndex) {
                            // Show the next section
                            showCurrentSection();
                        }
                    }
                }
            });
            markReviewButton.addEventListener('click', function () {
                // Add the 'shape3' class to the corresponding sidebar button
                var selectedChoice = document.querySelector('input[name="choice"]:checked');
                var answer = selectedChoice ? selectedChoice.value : '';
                saveAnswer(answer);

                if (answer != '') {
                    saveMarkAnswer(answer);
                }
                else {
                    markUnAnswer();

                }

                // Check if it's the last question in the current section
                if (currentQuestionIndex < sections[currentSectionIndex].questions.length - 1) {
                    // Move to the next question
                    currentQuestionIndex++;
                    // Show the next question
                    showCurrentSection();
                } else {
                    // Check if it's the last section and last question
                    if (currentSectionIndex === sections.length - 1 && currentQuestionIndex === sections[currentSectionIndex].questions.length - 1) {
                        // Handle submission via AJAX
                        // submitAnswers();
                        sbmt.style.display = "block";
                        sbmt.onclick = submitAnswers;

                    } else {
                        // Check if the user has confirmed the section change
                        if (!confirmedSectionChange) {
                            // If not confirmed, prompt for confirmation
                            if (confirm("Do you want to proceed to the next section?")) {
                                // If confirmed, set the variable to true
                                confirmedSectionChange = true;
                            } else {
                                // If not confirmed, return without proceeding
                                return;
                            }
                        }

                        // Reset the confirmedSectionChange flag for the next section
                        confirmedSectionChange = false;

                        // Move to the next section
                        var previousSectionIndex = currentSectionIndex;
                        currentQuestionIndex = 0;
                        currentSectionIndex++;

                        // If section changed, show confirmation
                        if (previousSectionIndex !== currentSectionIndex) {
                            // Show the next section
                            showCurrentSection();
                        }
                    }
                }
            });

            var clearResponseButton = document.querySelector('.clearbutton');
            clearResponseButton.addEventListener('click', function () {
                // Find the selected choice and reset it
                var selectedChoice = document.querySelector('input[name="choice"]:checked');
                if (selectedChoice) {
                    selectedChoice.checked = false;
                }
                // Clear the answer from the answers object
                answers[sections[currentSectionIndex].name][sections[currentSectionIndex].questions[currentQuestionIndex].question] = '';
            });

            // Show the next question or move to the next section
            showCurrentSection();




            function updateSidebar(sectionIndex) {
                var sidebar = document.getElementById('sidebar');
                sidebar.innerHTML = ""; // Clear previous content

                sections[sectionIndex].questions.forEach(function (question, index) {
                    var questionButton = document.createElement('button');
                    questionButton.textContent = index + 1;
                    questionButton.classList.add('question-button');
                    questionButton.classList.add(sectionIndex + '_' + index);

                    // Check if the question has been answered

                    if (answers[sections[sectionIndex].name] && answers[sections[sectionIndex].name][question.question]) {
                        if (markAnswer[sections[sectionIndex].name] && markAnswer[sections[sectionIndex].name][question.question]) {
                            questionButton.classList.add('shape4');
                        } else {
                            questionButton.classList.add('shape');

                        }

                    } else if (unanswers[sections[sectionIndex].name] && unanswers[sections[sectionIndex].name][question.question] == "") {
                        questionButton.classList.add('shape2');
                    } else if (markUnanswer[sections[sectionIndex].name] && markUnanswer[sections[sectionIndex].name][question.question] == "") {
                        questionButton.classList.add('shape3');
                    }
                    else {
                        questionButton.classList.add('shape0');
                    }

                    questionButton.addEventListener('click', function () {
                        if (currentSectionIndex !== sectionIndex) {
                            // Display alert when changing sections
                            alert("Changing section. Do you want to continue?");
                        }
                        currentQuestionIndex = index;
                        showCurrentSection();
                    });

                    sidebar.appendChild(questionButton);
                });

                // Reset classList for previous section's questions
                if (currentSectionIndex !== sectionIndex) {
                    var previousSectionQuestions = sections[currentSectionIndex].questions;
                    previousSectionQuestions.forEach(function (question, index) {
                        var button = document.querySelector('.question-button.' + currentSectionIndex + '_' + index);
                        if (button) {
                            // Remove both shape and shape0 classes
                            button.classList.remove('shape');
                            button.classList.remove('shape0');
                        }
                    });
                }

                // Update current section index
                currentSectionIndex = sectionIndex;
            }

            // Fullscreen functionality
            fullscreenButton.addEventListener('click', function () {
                if (document.fullscreenElement) {
                    exitFullscreen();
                } else {
                    enterFullscreen();
                }
            });

            function enterFullscreen() {
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) { /* Firefox */
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                    document.documentElement.webkitRequestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) { /* IE/Edge */
                    document.documentElement.msRequestFullscreen();
                }
            }

            function exitFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.mozCancelFullScreen) { /* Firefox */
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) { /* IE/Edge */
                    document.msExitFullscreen();
                }
            }

            function submitAnswers() {
                const examId = exam; // Example exam_id value, replace with your actual exam_id
                const studentId = sid;
                const no = pno;

                // Construct the data object to be sent in the request body
                const postData = {
                    studentId: studentId,
                    examId: examId,
                    examNo: no,
                    answers: answers
                };
                // console.log(postData);

                // Ask for confirmation before submitting
                if (confirm("Are you sure you want to submit your answers?")) {
                    // Perform AJAX request to submit answers
                    fetch('val2.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(postData)
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            // Redirect or handle response as needed
                            return response.text(); // This will return the response body as text
                        })
                        .then(data => {
                            // alert(data); // Display the response message
                            // Redirect to new.php or handle response as needed
                            console.log(data);
                            window.location.href = 'thanYou.php'; // Uncomment this line if you want to redirect
                        })
                        .catch(error => {
                            console.error('Error submitting answers:', error.message);
                        });
                }
            }
            function submitAnswers2() {
                const examId = exam; // Example exam_id value, replace with your actual exam_id
                const studentId = sid;
                const no = pno;

                // Construct the data object to be sent in the request body
                const postData = {
                    studentId: studentId,
                    examId: examId,
                    examNo: no,
                    answers: answers// Assuming answers is defined somewhere
                };
                // console.log(postData);
                // Perform AJAX request to submit answers
                fetch('val2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(postData)
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        alert(response);
                        // Redirect to thanYou.php or handle response as needed
                        window.location.href = 'thanYou.php'; // Uncomment this line if you want to redirect
                    })
                    .catch(error => {
                        console.error('Error submitting answers:', error.message);
                    });
            }


            // Start the timer when the page loads
            // window.onload = function () {
            //     updateTimer();
            // };
        });

    </script>

    <script src="https://kit.fontawesome.com/ca0110489d.js" crossorigin="anonymous"></script>
</body>

</html>