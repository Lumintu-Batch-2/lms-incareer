<?php

session_start();

$loginPath = "../../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
}

switch ($_SESSION['user']->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses Ditolak');
            location.replace('../Admin/index.php')
        </script>";
        break;
    case 3:
        echo "
        <script>
            alert('Akses Ditolak');
            location.replace('../Student/login.php')
        </script>";
        break;

    default:
        break;
}

require_once "../../api/get_api_data.php";

$subjectData = array();

$modulJSON = json_decode(http_request("https://ppww2sdy.directus.app/items/modul_name"));

for($i = 0; $i < count($modulJSON->{'data'}); $i++) {
    if($modulJSON->{'data'}[$i]->{'parent_id'} == $_GET['course_id']) {
        array_push($subjectData, $modulJSON->{'data'}[$i]);
    }
}

var_dump($subjectData);

// require_once('../../Model/Subjects.php');

// $objSub = new Subjects;
// $allSubjects = $objSub->getSubjectByCourseId($_GET['course_id']);


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
            <!-- <th>Desc</th> -->
            <th>Assignment</th>
        </thead>
        <tbody>
            <?php foreach ($subjectData as $row => $subject) : ?>
                <tr>
                    <td><?= $subject->{'id'}; ?></td>
                    <td><?= $subject->{'modul_name'}; ?></td>
                    <td><a href="assignment.php?course_id=<?=$_GET['course_id'] ?>&subject_id=<?= $subject->{'id'}; ?>">assignment</a></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>

</html>