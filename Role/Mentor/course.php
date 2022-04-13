<?php
session_start();

$loginPath = "../../login.php";

if(!isset($_SESSION['user'])) {
    header("location: " . $loginPath );
    die;
}

switch($_SESSION['user']['role']) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Student/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Admin/');
        </script>
        ";
        break;
    default:
        break;
}

require_once('../../Model/Subjects.php');

$objSub = new Subjects;
$allSubjects = $objSub->getSubjectByCourseId($_GET['course_id']);


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
            <th>Desc</th>
            <th>Assignment</th>
        </thead>
        <tbody>
            <?php foreach ($allSubjects as $row => $subject) : ?>
                <tr>
                    <td><?= $subject['subject_id']; ?></td>
                    <td><?= $subject['subject_name']; ?></td>
                    <td><?= $subject['subject_desc']; ?></td>
                    <td><a href="assignment.php?subject_id=<?= $subject['subject_id']; ?>">assignment</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>

</html>