<?php

session_start();

$loginPath = "../../login.php";

if(!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
    die;
}

switch($_SESSION['user']->{'role'}) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Admin/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Student/');
        </script>
        ";
        break;
    default:
        break;
}


require "../../Model/Courses.php";
$objCourse = new Courses;
$allCourses = $objCourse->gelAllCourseByUserId($_SESSION['user']->{'user_id'});

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assigment</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
    <h1>Halaman Mentor</h1>

    <table>
        <thead>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Link</th>
        </thead>
        <tbody>
            <?php foreach ($allCourses as $key => $course) : ?>
                <tr>
                    <td><?= $course['course_id']; ?></td>
                    <td><?= $course['course_name']; ?></td>
                    <td><?= $course['course_desc']; ?></td>
                    <td><a href="./course.php?course_id=<?= $course['course_id']; ?>">Link</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>

</html>