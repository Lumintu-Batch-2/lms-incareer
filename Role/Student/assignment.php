<?php
require_once('../../Model/Assignments.php');
$objAssign = new Assignments;

$allAssignments = $objAssign->getAssignmentBySubjectId($_GET['subject_id']);
echo $_GET['subject_id'];
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>

    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Start Date</th>
            <th>Due Date</th>
            <th>Due Time</th>
            <th>Desc</th>
            <th>Submit</th>
        </thead>
        <tbody>
            <?php foreach ($allAssignments as $row => $assignment) : ?>
                <?php
                $arrStartDate = explode(" ", $assignment['assignment_start_date']);
                $arrEndDate = explode(" ", $assignment['assignment_end_date']);

                // var_dump($arrEndDate);
                $startDate = $arrStartDate[0];
                $dueDate = $arrEndDate[0];
                $dueTime = $arrEndDate[1];
                ?>
                <tr>
                    <td><?= $assignment['assignment_id']; ?></td>
                    <td><?= $assignment['assignment_name']; ?></td>
                    <td><?= $startDate; ?></td>
                    <td><?= $dueDate; ?></td>
                    <td><?= $dueTime; ?></td>
                    <td><?= $assignment['assignment_desc']; ?></td>
                    <td><a href="submission.php?assignment_id=<?= $assignment['assignment_id']; ?>">Submit</a></td>

                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>

</html>