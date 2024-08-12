<?php include_once ('components/includes/connection.php');
include_once ('components/includes/function.php');
include_once ('components/header.php');
$msg = '';
if (isset($_GET['msg']) && $_GET['msg'] == "login") {
    $msg = "<div class='alert alert-success alert-dismissible'>
          <strong>Login successfully!</strong>
        </div>";

} else {
    $msg = "";
}
// $active_user = getResultAsArray("SELECT COUNT(`id`) as `cnt` FROM `admin` WHERE `status` = 1");

?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

    body {
        -webkit-user-select: none !important;
        -moz-user-select: none !important;
        -ms-user-select: none !important;
        user-select: none !important;
    }

    .NavBar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5em;
        color: white;
        background-color: #4973bd;
        font-family: 'Roboto', sans-serif !important;
    }

    .box {
        margin: 1em;
        height: 75vh;
        border: 2px solid #959595;
        overflow-y: auto;

    }

    .user {
        display: flex;
        /* justify-content: center; */
        align-items: center;
        flex-direction: column;
    }

    .user img {
        height: 200px;
        width: 150px;
    }

    .shape0 {
        background-color: #dbd9da;
        padding: 15px 20px 15px 20px;
        border-radius: 5px;
        outline: 1px solid black;
        margin-right: 20px;
    }

    li {
        margin-left: 20px;
    }

    .shape {
        width: 80px;
        /* Adjust width as needed */
        height: 80px;
        /* Adjust height as needed */
        background-color: #75bc24;
        /* Blue color */
        clip-path: polygon(30% 0, 70% 0, 100% 42%, 100% 100%, 0 100%, 0 42%);
        padding: 10px 20px 10px 20px;
        outline: 2px solid black;
        color: white;
        margin-right: 20px;
        /* Border style */
    }

    .BB {
        list-style: lower-alpha;
    }

    .shape2 {
        width: 80px;
        /* Adjust width as needed */
        height: 80px;
        /* Adjust height as needed */
        background-color: #df3c01;
        /* Blue color */
        clip-path: polygon(0 0, 100% 0, 100% 45%, 70% 100%, 30% 100%, 0 45%);
        padding: 10px 20px 10px 20px;
        outline: 2px solid black;
        /* Border style */
        color: white;
        margin-right: 20px;
    }

    .shape3 {

        color: white;
        background-color: purple;
        padding: 13px 17px 13px 17px;
        border-radius: 50%;
        color: white;
        margin-right: 20px;
    }

    .shape4 {

        color: white;
        background-color: #FFE43E;
        padding: 13px 17px 13px 17px;
        border-radius: 50%;
        color: white;
        margin-right: 20px;
    }

    .tt {
        list-style: none;
    }

    .tt li {
        margin: 40px;

    }

    .redcolor {
        color: red;
        font-style: italic;
    }

    .boold {
        font-weight: bold;
    }
</style>

<body>
    <nav class="NavBar">
        <h2>Instruction</h2>

    </nav>
    <div class="row" style="height: 88vh; margin-top:10px;text-align:justify;">
        <div class="col-9" style="border-right: 2px solid #959595;">

            <div class="box">
                <div class="fflex" style="display:flex; align-items:center; justify-content:space-between;">
                    <h3>Please Read the following instructions carefully</h3>
                    <h6 id="timer">Timer:</h6>
                </div>

                <ol>
                    <h6 style="text-decoration:underline;">General instructions:</h6>

                    <li>total of 30 minutes duration will be given to attempt all the questions</li>
                    <li>The clock has been set at the server and the countdown time at the top right of your screen will
                        display the time remaining for you to complete the exam. When the clock runs out the exam ends
                        by default- you are not required to end or submit you exam.</li>
                    <li>The question pallet at the right of the screen shows the following status of each questions:
                        <ul class="tt">
                            <li>
                                <span class="shape0">0</span> You have not visited.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape2">0</span> You have not answered this question.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape">0</span> You have answered this question.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape3">0</span> You have not answered and marked for review.
                                <!-- <div class="bex">0</div> -->
                            </li>
                            <li>
                                <span class="shape4">0</span> You have answered and marked for review.
                                <!-- <div class="bex">0</div> -->
                            </li>

                            <li>
                                <!-- The marked for review status simply act as a reminder that you have set to look the
                                question again. <span class="redcolor">if answered is selected for questions that is
                                    marked for review,
                                    the answered is considerd in the final evaluations.</span> -->
                            </li>
                        </ul>
                    </li>
                    <h6 style="text-decoration:underline;">Navigate To a Question:</h6>
                    <li>To select a question to answer, you can do one of the following:
                        <ol class="BB">
                            <li>click on the question number on the question palette at the right of your screen to go
                                to that numbered question directly. Note that using this option does NOT save your
                                answer to the current question.</li>
                            <li>Click on Save and next to save answer to current question and to go to the next question
                                in sequence.</li>
                        </ol>
                    </li>
                    <li>You can view the entire paper by clicking on the <span class="boold">Question Paper</span>
                        button.</li>
                    <h6 style="text-decoration:underline;">Answering Questions:</h6>
                    <li>For multiple choice type question:
                        <ol class="BB">
                            <li>To select your answer, click on one of the option buttons.</li>
                            <li>To change you answer, click on the another desired option button.</li>
                            <li>To save your answer, you MUST click on <span class="boold">Save & Next<span>.</li>
                            <li>To deselect a chosen answer, click on the chosen option again or click on the <span
                                    class="boold">Clear Response</span> button.</li>
                        </ol>
                    </li>
                    <li>For a numerical answer type question.
                        <ol class="BB">
                            <li>To enter a number as your answer, use the virtual numerical keypad</li>
                            <li>A fraction(eg 0.3 or -0.3) can be entered as an answer ONLY with '0' befor the decimal
                                point</li>
                            <li>To save your answer, click on the <span class="boold">Save & Next</span></li>
                            <li>To clear your answer, click on the <span class="boold">Clear Response</span> button</li>
                        </ol>
                    </li>
                    <li>To change an answer to a question, first select the question and then click on the new answer
                        option followed by a click on the <span class="boold">Save & Next</span> button.</li>
                    <li>Questions that are saved or marked for review after answering will ONLY be considered for
                        evaluation.</li>
                    <h6 style="text-decoration:underline;">Navigate Through Sections:</h6>

                    <li>Section in this question paper are displayed on the top bar of the screen, Question in a
                        section can be viewed by clicking on the section name. The section you are currently viewing
                        is highlighted.</li>
                    <li>After clicking the <span class="boold">Save & Next</span> button on the last question for a
                        section, you will automatically be taken to the first question of the next section.</li>
                    <li>You can move the mouse cursor over the section names to view the status of the questions for
                        the status of the questions for that section.</li>
                    <li>You can shuffle between sections and questions anytime during the examination as per your
                        convnience.</li>

                </ol>


            </div>

            <script>
                function openRestrictedWindow(url) {
                    var options = "width=auto,height=auto,resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no";
                    var newWindow = window.open(url, '_blank', options);
                    newWindow.focus();
                }
            </script>

            <!-- <a class="d-block text-center" style="cursor:pointer;text-decoration:none;"
                onclick="openRestrictedWindow('exam.php?id=<?= $_GET['id'] ?>&examId=<?= $_GET['examId'] ?>')">Next>></a> -->
            <!-- <a href="exam.php?id=<?= $_GET['id'] ?>&examId=<?= $_GET['examId'] ?>"
                class="d-block text-center next-button">Next</a> -->
            <a href="exam.php?id=<?= $_GET['id'] ?>&examId=<?= $_GET['examId'] ?>"
                class="d-block text-center next-button" onclick="openFullScreen(this.href); return false;">Next</a>


        </div>
        <div class="col-3 user">
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

            <img src="<?= $path ?>" alt="">
            <h4>
                <?= $row['name'] ?>
            </h4>
            <p>
                <?= $row['phone'] ?>
            </p>
        </div>
    </div>

    <script>
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = "Timer: " + minutes + "m " + seconds + "s";

                if (--timer < 0) {
                    timer = 0;
                    // clearInterval(timerInterval);
                    // Automatically click the Next button when timer reaches zero
                    var nextButton = document.querySelector('.next-button');
                    if (nextButton) {
                        nextButton.click();
                    }
                }
            }, 1000);
        }

        window.onload = function () {
            var timerDisplay = document.getElementById('timer');
            var timerDuration = 60; // Timer duration in seconds
            startTimer(timerDuration, timerDisplay);
        };
        function openFullScreen(url) {
            var options = "width=" + screen.width + ",height=" + screen.height + ",resizable=no,scrollbars=no,status=no,toolbar=no,menubar=no,location=no";
            var newWindow = window.open(url, '_blank', options);

            if (newWindow) {
                newWindow.moveTo(0, 0);
                newWindow.resizeTo(screen.width, screen.height);
                newWindow.focus();

                // Disable keyboard interactions
                newWindow.document.addEventListener('keydown', function (event) {
                    event.preventDefault();
                });
                newWindow.document.addEventListener('keypress', function (event) {
                    event.preventDefault();
                });
                newWindow.document.addEventListener('keyup', function (event) {
                    event.preventDefault();
                });
            } else {
                alert('Your browser blocked opening the new window. Please check your browser settings.');
            }
        }


    </script>
</body>

</html>