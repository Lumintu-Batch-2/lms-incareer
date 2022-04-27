<?php
session_start();

$loginPath = "../../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
    die;
}

switch ($_SESSION['user']->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../../Admin/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../../Student/');
        </script>
        ";
        break;
    default:
        break;
}


require_once "../../api/get_api_data.php";

$userData = array();
$modulJSON = json_decode(http_request("https://ppww2sdy.directus.app/items/modul_name"));
$userBatchJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user_batch"));
$userJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user"));


for ($i = 0; $i < count($modulJSON->{'data'}); $i++) {
    if ($modulJSON->{'data'}[$i]->{'id'} == (int)$_GET['course_id']) {
        for ($j = 0; $j < count($userBatchJSON->{'data'}); $j++) {
            if ($modulJSON->{'data'}[$i]->{'batch_id'} == $userBatchJSON->{'data'}[$j]->{'batch_batch_id'}) {
                for ($k = 0; $k < count($userJSON->{'data'}); $k++) {
                    if ($userBatchJSON->{'data'}[$j]->{'user_user_id'} == $userJSON->{'data'}[$k]->{'user_id'} && $userJSON->{'data'}[$k]->{'role_id'} == 3) {
                        array_push($userData, $userJSON->{'data'}[$k]);
                    }
                }
            }
        }
    }
}

// var_dump($courseData);
// var_dump($userData);

require_once('../../Model/AssignmentSubmission.php');
$submitted = new AssignmentSubmission;
$submitted->setAssignmentId($_GET['assignment_id']);
$sub = $submitted->getSubmittedFile();

// var_dump($sub);
$studentSub = array();
for ($i = 0; $i < count($userData); $i++) {
    for ($j = 0; $j < count($sub); $j++) {
        if ($userData[$i]->{'user_id'} == $sub[$j]['student_id']) {
            array_push($studentSub, array(
                "user_id" => $userData[$i]->{'user_id'},
                "assignment_id" => $sub[$j]['assignment_id'],
                "student_name" => $userData[$i]->{'user_username'},
                "submitted_date" => $sub[$j]['submitted_date'],
                "submission_token" => $sub[$j]['submission_token'],
                "submission_filename" => $sub[$j]['submission_filename'],
                "score_id" => $sub[$j]['score_id'],
                "score_value" => $sub[$j]['score_value']
            ));
        }
    }
}

// var_dump($studentSub);
// var_dump($userData);
$data = array();

// usort($studentSub, function ($items1, $items2) {
//     return $items1['user_id'] <=> $items2['user_id'];
// });

var_dump($studentSub);


// for ($i = 0; $i < count($studentSub); $i++) {
//     // if($studentSub[$i]['user_id'] == $studentSub[$i+1]['user_id']) {
//     //     if(strtotime($studentSub[$i]['submitted_date']) < strtotime($studentSub[$i+1]['submitted_date'])) {
//     //         array_push($data, $studentSub[$i+1]);
//     //     }
//     // } else {
//     //     array_push($data, $studentSub[$i+1]);
//     // }
//     // if ($studentSub[$i]['user_id'] != $studentSub[$i + 1]['user_id']) {
//     //     array_push($data, $studentSub[$i]);
//     // }
// }

// var_dump($studentSub);

// var_dump($data);

$didntsub = $submitted->getStudentNotSubmit();
if (isset($_POST['submit'])) {
    require_once('../../Model/Scores.php');
    $score = new Scores;
    $score->setScoreId($_POST['sid']);
    $score->setScoreValue($_POST['score']);
    $score->setMentorId($_SESSION['user']->{'user_id'});
    $update  = $score->updateScore();
    if ($update) {
        echo "
        <script>
            alert('Berhasil Menambahkan score');
            location.replace('assignment_collection.php?course_id=" . $_GET['course_id'] . "&assignment_id=" . $_GET['assignment_id'] . "&subject_id=" . $_GET['subject_id'] . "');
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal');
            location.replace('assignment_collection.php?course_id=" . $_GET['course_id'] . "&assignment_id=" . $_GET['assignment_id'] . "&subject_id=" . $_GET['subject_id'] . "');
        </script>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Page</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Jqueey -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">


    <!-- CSS -->
    <!-- <link rel="stylesheet" href="./CSS/UploafField.css"> -->


    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ["Montserrat"],
                    },
                    colors: {
                        "dark-green": "#1E3F41",
                        "light-green": "#659093",
                        "cream": "#DDB07F",
                        "cgray": "#F5F5F5",
                    }
                }
            }
        }
    </script>
    <style>
        p.note {
            font-size: 1rem;
            color: red;
        }

        label.error {
            color: red;
            font-size: 1rem;
            display: block;
            margin-top: 5px;
        }

        label.error.fail-alert {

            line-height: 1;
            padding: 2px 0 6px 6px;

        }

        .in-active {
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }

        .in-active ul li p {
            display: none !important;
        }

        .in-active ul li a {
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-incareer {
            display: none !important;
        }

        .hidden {
            display: none !important;
        }

        .sidebar {
            transition: .5s ease-in-out;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[350px] h-screen px-8 py-6 flex flex-col justify-between sidebar in-active">
            <!-- Top nav -->
            <div class="flex flex-col gap-y-6">
                <!-- Header -->
                <div class="flex items-center space-x-4 px-2">
                    <img src="../../Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle">
                    <img class="w-[150px] logo-incareer" src="../../Img/logo/logo_primary.svg" alt="Logo In Career">
                </div>

                <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">

                <!-- List Menus -->
                <div>
                    <ul class="flex flex-col gap-y-1">
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/home_icon.svg" alt="Dashboard Icon">
                                <p class="font-semibold">Dashboard</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                                <img class="w-5" src="../../Img/icons/course_icon.svg" alt="Course Icon">
                                <p class="text-white font-semibold">Courses</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/discussion_icon.svg" alt="Forum Icon">
                                <p class="font-semibold">Forum Dicussion</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/schedule_icon.svg" alt="Schedule Icon">
                                <p class="font-semibold">Schedule</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/attendance_icon.svg" alt="Attendance Icon">
                                <p class="font-semibold">Attendance</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/score_icon.svg" alt="Score Icon">
                                <p class="font-semibold">Score</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/consult_icon.svg" alt="Consult Icon">
                                <p class="font-semibold">Consult</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Bottom nav -->
            <div>
                <ul class="flex flex-col ">
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/logout_icon.svg" alt="Log out Icon">
                            <p class="font-semibold">Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>


        <!-- Right side -->
        <div class="bg-cgray w-full h-screen px-10 py-6 flex flex-col gap-y-6 overflow-y-scroll">
            <!-- Header / Profile -->
            <div class="flex items-center gap-x-4 justify-end">
                <img class="w-10" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                <p class="text-dark-green font-semibold"><?= $_SESSION['user']->{'user_username'}  ?></p>
            </div>



            <!-- Topic Title -->
            <div class="flex justify-between">
                <form action="">
                    <div class="w-4"> <button type="button" class="text-dark-green inline-flex font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 "><img class="w-5" src="../../Img/icons/back_icons.svg" alt="Back Image">
                            <p class="ml-2"> Back</p>
                        </button>
                    </div>
                </form>
                <div>
                    <p class="text-4xl text-dark-green font-semibold">Assignment Collection</p>
                </div>
                <div class="w-4">

                </div>

            </div>

            <div>
                <p class="text-4xl text-dark-green font-semibold">Completed Assignment</p>
            </div>

            <!-- Table Assignment -->
            <div>
                <table class="shadow-lg bg-white rounded-xl" style="width: 100%">
                    <colgroup>
                        <col span="1" style="width: 5%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 15%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">

                    </colgroup>
                    <thead>
                        <tr class="text-dark-green">
                            <th class="border-b text-left px-4 py-2">No</th>
                            <th class="border-b text-center px-4 py-2">Name</th>
                            <th class="border-b text-center px-4 py-2">Published Date</th>
                            <th class="border-b text-center px-4 py-2">File</th>
                            <th class="border-b text-center px-4 py-2">Score</th>
                            <th class="border-b text-center px-4 py-2">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($studentSub as $key => $item) {

                        ?>
                            <tr>
                                <td class="border-b px-4 py-2"><?= $no ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $item['student_name']  ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $item['submitted_date']  ?></td>
                                <td class="border-b px-4 py-2  "><a href="download.php?file=<?= $item['submission_filename']; ?>">
                                        <?= $item['submission_filename']; ?> </a>
                                    <?php
                                    require_once('../../Model/AssignmentSubmission.php');
                                    $multipleup = new AssignmentSubmission;
                                    $multipleup->setSubmissionToken($item['submission_token']);
                                    $file = $multipleup->getSubmissionByToken();
                                    $jumlahfile = $multipleup->getRowSubmissionByToken();

                                    if (count($jumlahfile) > 1) {
                                        foreach ($file as $key => $val) { ?>
                                            <a href="download.php?file=<?= $val['submission_filename']; ?>">
                                                <p class=" border-t"><?= $val['submission_filename']; ?></p>
                                            </a>

                                    <?php }
                                    } ?>
                                </td>
                                <td class="border-b px-4 py-2 text-center "><?= $item['score_value']  ?></td>
                                <td class="border-b px-4 py-2 "><a href=""></a> <img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/edit_icon.svg" data-modal-toggle="defaultModal" data-username="<?= $item['student_name']; ?>" data-scoreid="<?= $item['score_id'] ?>" data-userid="<?= $item['user_id'] ?>" data-scorevalue="<?= $item['score_value']  ?>" alt="Edit Icon" type="button" data-target="#defaultModal" id="editbtn"></td>

                            </tr>

                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-12">
                <p class="text-4xl text-dark-green font-semibold">Unfinished Assignment</p>
            </div>

            <!-- Table Assignment -->
            <div>
                <table class="shadow-lg bg-white rounded-xl" style="width: 100%">
                    <colgroup>
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 25%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 20%">
                        <col span="1" style="width: 15%">
                    </colgroup>
                    <thead>
                        <tr class="text-dark-green">
                            <th class="border-b text-left px-4 py-2">No</th>
                            <th class="border-b text-center px-4 py-2">Name</th>
                            <th class="border-b text-center px-4 py-2">Published Date</th>
                            <th class="border-b text-center px-4 py-2">File</th>
                            <th class="border-b text-center px-4 py-2">Score</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($didntsub as $key => $item) {

                        ?>
                            <tr>
                                <td class="border-b px-4 py-2 text-red-600"><?= $no  ?></td>
                                <td class="border-b px-4 py-2 text-center text-red-600"><?= $item['username']  ?></td>
                                <td class="border-b px-4 py-2 text-center text-red-600">-</td>
                                <td class="border-b px-4 py-2 text-center text-red-600">-</td>
                                <td class="border-b px-4 py-2 text-center text-red-600">0</td>

                            </tr>
                        <?php $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- modal FINISHED ASSIGNMENT -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal header -->
                <div class="flex justify-center items-start p-5 rounded-t ">
                    <h3 class="text-xl font-bold  lg:text-2xl text-dark-green">
                        Edit Score
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="px-6 space-y-6">
                    <form class="flex flex-col gap-y-4" id="scoreform" action="" method="POST">
                        <div class="mb-6">
                            <input type="hidden" id="sid" name="sid">
                            <input type="hidden" id="uid" name="uid">
                            <input type="number" id="score" name="score" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <li class="font-semibold text-dark-green text-xs mt-2">Input score between 0-100</li>
                        </div>
                        <div class="flex justify-end p-6 space-x-3 rounded-b ">
                            <button data-modal-toggle="defaultModal" class="w-24" type="button">Cancel</button>
                            <button class="bg-yellow-600 text-white  font-semibold justify-end text-center py-2 rounded-lg w-24 ml-auto" type="submit" name="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL -->



    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>

    <script>
        let btnToggle = document.getElementById('btnToggle');
        let sidebar = document.querySelector('.sidebar');
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }

        $(document).ready(function() {
            $(document).on('click', '#editbtn', function() {
                let username = $(this).data('username');
                let scoreID = $(this).data('scoreid');
                let userID = $(this).data('userid');
                let scoreValue = $(this).data('scorevalue');
                $('#sid').val(scoreID);
                $('#uid').val(userID);
                console.log(userID);

                $('#score').attr('placeholder', 'Input score for ' + username);
            })
            $('#scoreform').validate({
                errorClass: "error fail-alert",
                validClass: "valid success-alert",
                rules: {
                    score: {
                        number: true,
                        min: 0,
                        max: 100,
                    }
                },
                messages: {
                    score: {
                        number: 'Score must be number',
                        min: 'Min score is 0 ',
                        max: 'max score is 100'
                    }
                }
            })




        })
    </script>


</body>

</html>