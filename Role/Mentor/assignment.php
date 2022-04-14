<?php

session_start();

$loginPath = "../../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
    die;
}

switch ($_SESSION['user']['role']) {
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

require "../../Model/Assignments.php";
require "../../Model/AssignmentSubmission.php";


$objAssignment = new Assignments;

$allAssignments = $objAssignment->getAssignmentBySubjectId($_GET['subject_id']);

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case "edit":
            if (isset($_GET['assign_id'])) {
                if (isset($_POST['edit_assignment'])) {
                    // var_dump($_FILES);
                    // die;
                    $edit = $objAssignment->editAssignment($_POST, $_FILES, $_GET['subject_id']);
                    $edit_status = $edit['is_ok'] ? "true" : "false";
                    if ($edit) {
                        echo "
                        <script>
                            alert('" . $edit['msg'] . "');
                            location.replace('assignment.php?subject_id=" . $_GET['subject_id'] . "')
                        </script>";
                    } else {
                        echo "
                        <script>
                            alert('" . $edit['msg'] . "');
                            location.replace('assignment.php?subject_id=" . $_GET['subject_id'] . "')
                        </script>";
                    }
                }
            }
            break;
        case "delete":
            if (isset($_GET['assign_id'])) {
                $objAssignment->setAssignmentId($_GET['assign_id']);
                $deleteStat = $objAssignment->deleteAssignment();

                if ($deleteStat) {
                    echo "
                    <script>
                        alert('Berhasil berhasil dihapus!');
                        location.replace('assignment.php?subject_id=" . $_GET['subject_id'] . "')
                    </script>";
                } else {
                    echo "Data gagal dihapus!";
                    header("location: assignment.php?subject_id=" . $_GET['subject_id']);
                }
            }
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Assigment</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body>
    <a class="btn btn-primary" href="./create_assignment.php?subject_id=<?= $_GET['subject_id']; ?>">Create new Assignment</a>
    <table>
        <thead>
            <tr>
                <th>Assignment Name</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Due Time</th>
                <th>Desciption</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allAssignments as $row => $assignment) : ?>
                <?php
                $arrStartDate = explode(" ", $assignment['assignment_start_date']);
                $arrEndDate = explode(" ", $assignment['assignment_end_date']);

                // var_dump($arrEndDate);
                $startDate = date("d/m/Y", strtotime($arrStartDate[0]));
                $dueDate = date("d/m/Y", strtotime($arrEndDate[0]));
                $dueTime = $arrEndDate[1];

                ?>
                <tr>
                    <td><?= $assignment['assignment_name'] ?></td>
                    <td><?= $startDate; ?></td>
                    <td><?= $dueDate; ?></td>
                    <td><?= $dueTime; ?></td>
                    <td><?= $assignment['assignment_desc'] ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal<?= $assignment['assignment_id']; ?>">Edit</button>
                        <a class="btn btn-info" href="assignment_collection.php?assignment_id=<?= $assignment['assignment_id'] . "&subject_id=" . $_GET['subject_id']; ?>">Assignment Collection</a>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal<?= $assignment['assignment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Assignment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" action="./assignment.php?subject_id=<?= $_GET['subject_id']; ?>&act=edit&assign_id=<?= $assignment['assignment_id']; ?>" enctype="multipart/form-data">
                                        <div class="modal-body">

                                            <?php
                                            $assigments = $objAssignment->getAssignmentById($assignment['assignment_id']);
                                            ?>
                                            <input type="hidden" name="id" value="<?= $assigments['assignment_id']; ?>">
                                            <label for="title">Assignment Title: </label>
                                            <input type="text" id="title" name="title" value="<?= $assigments['assignment_name']; ?>">
                                            <br>
                                            <label for="start-date">Tanggal mulai: </label>
                                            <input type="datetime-local" name="start-date" id="start-date" value="<?= date("Y-m-d\TH:i", strtotime($assigments['assignment_start_date'])); ?>">
                                            <br>
                                            <label for="end-date">Tanggal akhir: </label>
                                            <input type="datetime-local" name="end-date" id="end-date" value="<?= date("Y-m-d\TH:i", strtotime($assigments['assignment_end_date'])); ?>">

                                            <?php

                                            $objSubmission = new AssignmentSubmission;

                                            $allSubmissions = $objSubmission->getAllSubmissionByAssignmentId($assigments['assignment_id']);

                                            if (!$allSubmissions) {

                                            ?>

                                                <div class="form-group">
                                                    <label for="exampleFormControlFile1">Tambahkan file</label>
                                                    <input type="file" class="form-control-file" id="exampleFormControlFile1" name="filename">
                                                </div>

                                            <?php } ?>

                                            <label for="desc">Deksripsi: </label>
                                            <br>
                                            <textarea name="desc" id="desc" cols="30" rows="10" value><?= $assigments['assignment_desc']; ?></textarea>
                                            <br>
                                            <?php ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit_assignment">Save changes</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <a class="btn btn-danger" href="assignment.php?subject_id=<?= $_GET['subject_id']; ?>&act=delete&assign_id=<?= $assignment['assignment_id']; ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</body>

</html>