<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <title>Hello, world!</title>
</head>

<body>
    <div class="container">
        <h1>List Submission</h1>
        <div class="conatiner mt-3">
            <table class="table table-bordered">
                <tr class="text-center">
                    <td>Name</td>
                    <td>Published Date</td>
                    <td>File</td>
                    <?php
                    require_once('./Model/AssignmentSubmission.php');
                    $aq = new AssignmentSubmission;
                    $all = $aq->getAllAssignment();
                    // var_dump($all);
                    foreach ($all as $key => $value) {


                    ?>
                </tr>
                <td><?php echo $value['assignment_submission_id'] ?></td>
                <td><?php echo $value['submitted_date'] ?></td>
                <td>
                    <a href="download.php?path=./Upload/Assignment/Submission/Submission<?php echo $value['submission_filename'] ?>">
                        <span class="badge bg-primary"><i class="bi bi-download" style="font-size: 1.5rem; "></i></span>

                    </a>
                </td>
            <?php } ?>

            <tr>

            </tr>
            </table>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>