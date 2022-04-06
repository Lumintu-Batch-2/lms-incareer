<?php 

session_start();

require "./Model/AssignmentQuestion.php";

$objQuest = new AssignmentQuestion;

$questions = $objQuest->getAllQuestions();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Questions</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

</head>
<body>
    <table>
        <thead>
            <th>ID</th>
            <th>Filename</th>
            <th>Upload Date</th>
            <th>File</th>
        </thead>
        <tbody>
            <?php foreach($questions as $row => $quest) : ?>
                <tr>
                    <td><?=$quest['assignment_question_id'];?></td>
                    <td><?=$quest['question_filename'];?></td>
                    <td><?=$quest['question_upload_date'];?></td>
                    <td>
                        <a href="download.php?path=./Upload/Assignment/Questions/<?php echo $quest['question_filename'] ?>">
                            <span class="badge bg-primary"><i class="bi bi-download" style="font-size: 1.5rem; "></i></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>