<?php
session_start();
if (isset($_POST['upload'])) {
    require "./Model/Assignments.php";
    $objAsign = new Assignments;
    $create = $objAsign->createAssignment($_POST, $_FILES);
    var_dump($create);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new Assigment</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Assignment Title: </label>
        <input type="text" id="title" name="title">
        <br>
        <label for="start-date">Tanggal mulai: </label>
        <input type="datetime-local" name="start-date" id="start-date">
        <label for="end-date">Tanggal akhir: </label>
        <input type="datetime-local" name="end-date" id="end-date">
        <div class="form-group">
            <label for="exampleFormControlFile1">Tambahkan file</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="filename">
        </div>
        <label for="desc">Deksripsi: </label>
        <br>
        <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
        <br>
        <button class="btn btn-primary" type="submit" name="upload">Upload assignment</button>
    </form>
</body>

</html>