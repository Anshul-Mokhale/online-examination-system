<?php
include 'components/includes/connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $name = $_GET['name'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>PHP Print</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="print.css" media="print">
    <style>
        .log {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .log img {
            width: 240px !important;
            display: block;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="log">
                    <img src="assets/images/IMAGELOGO.svg" alt="">
                    <h2>
                        <?= $name ?>
                    </h2>
                </div>
                <div class="questions row">
                    <div class='col-md-12'>
                        <div class='card'>
                            <div class='card-body' style="align-items:start">
                                <?php
                                $sq2 = "SELECT * FROM demosections WHERE id = '$id'";
                                $ress = $mysql_connection->query($sq2);
                                if ($ress->num_rows > 0) {
                                    while ($rew = $ress->fetch_assoc()) {
                                        echo "<h2 class='text-center'>" . $rew['name'] . "</h2>";
                                        $section = $rew['sr'];
                                        $sq = "SELECT * FROM demoq_$id WHERE section = '$section'";
                                        $re = $mysql_connection->query($sq);
                                        $i = 1;

                                        if ($re->num_rows > 0) {

                                            while ($row = $re->fetch_assoc()) {
                                                echo "<h5>Question No: " . $i . "</h5>";
                                                if (isset($row['description']) && $row['description'] != "") {
                                                    echo "<strong>Description: </strong>" . $row['description'];
                                                    echo "<br>";
                                                    echo "<br>";
                                                }
                                                $question = $row['question'];
                                                $escapedQuestion = $mysql_connection->real_escape_string($question);

                                                echo "<strong>Question: </strong>" . $escapedQuestion;
                                                echo "<br>";
                                                echo "<br>";
                                                $choices = json_decode($row['choices'], true);
                                                foreach ($choices as $choice) {
                                                    if ($choice !== "") {
                                                        echo "<li>$choice</li>";
                                                    }
                                                }
                                                echo "<br>";
                                                echo "<br>";

                                                $i++;
                                            }
                                        }
                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button onclick="window.print();" class="btn btn-primary" id="print-btn">Print</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>