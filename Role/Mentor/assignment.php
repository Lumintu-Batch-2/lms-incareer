<?php
// MEMULAI SESSION
session_start();
// KEAMANAN HALAMAN BACK-END IDENTIFIKASI USER [START]
// PENGECEKAN USER APAKAH SUDAH LOGIN DENGAN AKUN YANG SESUAI ATAU BELUM SEBELUM MEMASUKI HALAMAN INI
$loginPath = "../../login.php";
if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("location: " . $loginPath);
}

if (!isset($_SESSION['user_data'])) {
    header("location: " . $loginPath);
    die;
}

switch ($_SESSION['user_data']->{'user'}->{'role_id'}) {
    // KONDISI KETIKA USER MEMASUKI HALAMAN NAMUN LOGIN SEBAGAI ADMIN
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Admin/');
        </script>
        ";
        break;
        // KONDISI KETIKA USER MEMASUKI HALAMAN NAMUN LOGIN SEBAGAI STUDENT
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
// KEAMANAN HALAMAN BACK-END IDENTIFIKASI USER [FINISH]

// MEMANGGIL FUNGSI DAN API
require "../../Model/Assignments.php";
require "../../Model/AssignmentSubmission.php";
require "../../api/get_api_data.php";

// MENYIMPAN DATA KEDALAM ARRAY
$subModulData = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_modul_rows.php"));
$subModul = array();

for ($i = 0; $i < count($subModulData->{'data'}); $i++) {
    if ($subModulData->{'data'}[$i]->{'id'} == $_GET['subject_id']) {
        array_push($subModul, $subModulData->{'data'}[$i]);
    }
}
// MENGAMBIL ASSIGNMENT SESUAI DENGAN TOPIK DAN SUB-TOPIK TERTENTU
$objAssignment = new Assignments;

$allAssignments = $objAssignment->getAssignmentBySubjectId($_GET['subject_id']);

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        // FUNGSI EDIT ASSIGNMENT
        case "edit":
            if ($_GET['assign_id']) {

                if (isset($_POST['edit_assignment'])) {

                    $dataArray = [
                        "title" => $_POST['title'],
                        "desc" => $_POST['desc'],
                        "start-date" => date('Y-m-d h:i:s', strtotime($_POST['startDate'])),
                        "end-date" => date('Y-m-d h:i:s', strtotime($_POST['dueDate'])),
                        "id" => $_GET['assign_id'],
                        "assign_type" => $_POST['assign_type']
                    ];
                    //    var_dump($dataArray);
                    //     die;
                    $edit = $objAssignment->editAssignment($dataArray, $_FILES, $_GET['subject_id']);
                    $edit_status = $edit['is_ok'] ? "true" : "false";
                    if ($edit) {
                        echo "
                        <script>
                            alert('" . $edit['msg'] . "');
                            location.replace('assignment.php?course_id=" . $_GET['course_id'] . "&subject_id=" . $_GET['subject_id'] . "')
                        </script>";
                    } else {
                        echo "
                        <script>
                            alert('" . $edit['msg'] . "');
                            location.replace('assignment.php?course_id=" . $_GET['course_id'] . "&subject_id=" . $_GET['subject_id'] . "')
                        </script>";
                    }
                }
            }
            break;
        // FUNGSI DELETE ASSIGNMENT
        case "delete":
            if ($_GET['assign_id']) {
                $objAssignment->setAssignmentId((int)$_GET['assign_id']);
                $deleteStat = $objAssignment->deleteAssignment();

                if ($deleteStat) {
                    echo "
                    <script>
                        alert('Data berhasil dihapus!');
                        location.replace('assignment.php?course_id=" . $_GET['course_id'] . "&subject_id=" . $_GET['subject_id'] . "')
                    </script>";
                } else {
                    echo "
                    <script>
                        alert('Data gagal dihapus!');
                        location.replace('assignment.php?course_id=" . $_GET['course_id'] . "&subject_id=" . $_GET['subject_id'] . "')
                    </script>";
                }
            }
            break;
        // FUNGSI LOGOUT 
        case "logout":
            if (isset($_GET['act'])) {
                require $_SERVER['DOCUMENT_ROOT'] . "\Model\Users.php";
                $objUser = new Users;
                // $logout = $objUser->logoutUser();
            }
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

    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
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

    <!-- CUSTOM STYLE CSS -->
    <style>
       .sidebar #username_logo {
            display: none;
        }

        /* #profil_image {
            display: none !important;
        } */

        /* .responsive-top {
            display: none;
        } */

        .active {
            color: #DDB07F !important;
            border-bottom: solid 4px #DDB07F;
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

        /* .hidden {
            display: none !important;
        } */

        .sidebar {
            transition: .5s ease-in-out;
        }

    </style>
</head>

<body>
    <div class="responsive-top p-5 sm:hidden">
        <div class="flex justify-center bg-gray-300 p-2 rounded-lg">
            lms in-career
        </div>
        <div class="container flex flex-column justify-between mt-4 mb-4">
            <img class="w-[150px] logo-incareer" src="../../Img/logo/logo_primary.svg" alt="Logo In Career">
            <img src="../../Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle2">
        </div>
    </div>
    <!-- LIST MENU SIDEBAR [START]-->
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[350px] h-screen px-8 py-6 sm:flex flex-col justify-between sidebar in-active hidden">
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
                        <!-- ICON DAN TEXT DASHBOARD -->    

                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/home_icon.svg" alt="Dashboard Icon">
                                <p class="font-semibold">Dashboard</p>
                            </a>
                        </li>
                        <!-- ICON DAN TEXT FORUM COURSES -->
                        <li>
                            <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                                <img class="w-5" src="../../Img/icons/course_icon.svg" alt="Course Icon">
                                <p class="text-white font-semibold">Courses</p>
                            </a>
                        </li>
                        <!-- ICON DAN TEXT SCHEDULE -->
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/schedule_icon.svg" alt="Schedule Icon">
                                <p class="font-semibold">Schedule</p>
                            </a>
                        </li>
                        <!-- ICON DAN TEXT ATTENDANCE -->
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/attendance_icon.svg" alt="Attendance Icon">
                                <p class="font-semibold">Attendance</p>
                            </a>
                        </li>
                        <!-- ICON DAN TEXT SCORE -->
                        <!-- <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/score_icon.svg" alt="Score Icon">
                                <p class="font-semibold">Score</p>
                            </a>
                        </li> -->
                        <!-- ICON DAN TEXT CONSULT -->
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
                    <!-- ICON DAN TEXT HELP -->
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </a>
                    </li>
                    <!-- ICON DAN TEXT LOG OUT -->
                    <li>
                        <a href="assignment.php?act=logout" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="../../Img/icons/logout_icon.svg" alt="Log out Icon">
                            <p class="font-semibold">Log out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Mobile navbar -->
        <div id="left-nav" class="bg-opacity-50 bg-gray-500 absolute inset-x-0 hidden z-10 transition-all ease-in-out duration-500 sm:hidden">

            <div class="bg-white w-[250px] h-screen px-8 py-6 ">
                <!-- Top nav -->
                <div class="flex flex-col gap-y-6">

                    <!-- List Menus -->
                    <div>
                        <ul class="flex flex-col gap-y-1">
                            <li>
                                <a href="" class="flex items-center gap-x-4 h-[50px] px-4" id="profil_image">
                                    <img class="w-5" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                                    <p class="font-semibold"><?= $_SESSION['user_data']->{'user'}->{'user_first_name'} . " " . $_SESSION['user_data']->{'user'}->{'user_last_name'} ?></p>
                                    <!-- <p class="font-semibold"></p> -->
                                </a>
                            <!-- ICON DAN TEXT DASHBOARD -->    
                            </li>
                            <li>
                                <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../../Img/icons/home_icon.svg" alt="Dashboard Icon">
                                    <p class="font-semibold">Dashboard</p>
                                </a>
                            </li>
                            <!-- ICON DAN TEXT FORUM COURSES -->
                            <li>
                                <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                                    <img class="w-5" src="../../Img/icons/course_icon.svg" alt="Course Icon">
                                    <p class="text-white font-semibold">Courses</p>
                                </a>
                            </li>
                            <!-- ICON DAN TEXT SCHEDULE -->
                            <li>
                                <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../../Img/icons/schedule_icon.svg" alt="Schedule Icon">
                                    <p class="font-semibold">Schedule</p>
                                </a>
                            </li>
                            <!-- ICON DAN TEXT ATTENDANCE -->
                            <li>
                                <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../../Img/icons/attendance_icon.svg" alt="Attendance Icon">
                                    <p class="font-semibold">Attendance</p>
                                </a>
                            </li>
                            <!-- ICON DAN TEXT SCORE -->
                            <!-- <li>
                                <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                    <img class="w-5" src="../../Img/icons/score_icon.svg" alt="Score Icon">
                                    <p class="font-semibold">Score</p>
                                </a>
                            </li> -->
                            <!-- ICON DAN TEXT CONSULT -->
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
                        <!-- ICON DAN TEXT HELP -->
                        <li>
                            <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/help_icon.svg" alt="Help Icon">
                                <p class="font-semibold">Help</p>
                            </a>
                        </li>
                        <!-- ICON DAN TEXT LOG OUT -->
                        <li>
                            <a href="assignment.php?act=logout" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="../../Img/icons/logout_icon.svg" alt="Log out Icon">
                                <p class="font-semibold">Log out</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!-- Right side -->
        <div class="bg-cgray w-full h-screen px-10 py-6 flex flex-col gap-y-6 overflow-y-scroll rightbar">
            <!-- Header / Profile -->
            <div class="items-center gap-x-4 justify-end hidden sm:flex" id="profil_image2">
                <img class="w-10" src="../../Img/icons/default_profile.svg" alt="Profile Image" >
                <p class="text-dark-green font-semibold"><?= $_SESSION['user_data']->{'user'}->{'user_first_name'} . " " . $_SESSION['user_data']->{'user'}->{'user_last_name'} ?></p>
            </div>

            <!-- Breadcrumb -->
            <div class="">
                <ul class="flex items-center gap-x-4 text-xs lg:text-base">
                    <!-- NAVIGATOR HALAMAN HOME -->
                    <li class="flex items-center space-x-2">
                        <div>
                            <a class="text-light-green hover:text-dark-green hover:font-semibold" href="#">Home</a>
                        </div>
                        <div>
                            <span class="text-light-green">/</span>
                        </div>
                    </li>

                    
                    <!-- NAVIGATOR HALAMAN COURSES -->

                    <div class="flex items-center space-x-2">
                        <li>
                            <a class="text-light-green hover:text-dark-green hover:font-semibold" href="index.php">Courses</a>
                        </li>
                        <li>
                            <span class="text-light-green">/</span>
                        </li>
                    </div>
                    <div class="flex items-center space-x-2">
                        <li>
                            <a class="text-light-green" href="subject.php?course_id=<?= $_GET['course_id']; ?>">Sub Topic</a>
                        </li>
                        <li>
                            <span class="text-light-green">/</span>
                        </li>
                    </div>
                    <div>
                        <li>
                            <a class="text-dark-green font-semibold" href="#">Assignment</a>
                        </li>
                    </div>
                </ul>
            </div>

            <!-- Topic Title -->
            <div class="topic-title">
                <p class="text-sm sm:text-lg lg:text-2xl  xl:text-4xl text-dark-green font-semibold">Session# <?= $subModul[0]->{'modul_name'}; ?></p>
            </div>

            <!-- Mentor -->
            <div class="flex items-center gap-x-4 w-full bg-white py-4 px-5 lg:px-10 rounded-xl mentor-profile">
                <img class="w-8 lg:w-14" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                <div class="">
                    <p class="text-dark-green text-sm lg:text-base font-semibold"><?= $_SESSION['user_data']->{'user'}->{'user_first_name'} . " " . $_SESSION['user_data']->{'user'}->{'user_last_name'} ?></p>
                    <!-- <p class="text-light-green">Mentor Specialization</p> -->
                </div>
            </div>

            <!-- Tab -->
            <div class="bg-white w-full h-[50px] flex content-center px-10 tab-menu">
                <ul class="flex items-center gap-x-8 text-sm lg:text-base">
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer">
                        <p>Session</p>
                    </li>
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer active">
                        <p>Assignment</p>
                    </li>
                </ul>
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white w-full p-6 direction">
                <p class="text-dark-green text-sm lg:text-base font-semibold">Description :</p>
                <p class="text-sm lg:text-base"><?= $subModul[0]->{'modul_description'}; ?></p>
            </div>

            <!-- CONTENT TABEL ASSIGNMENT -->
            <div class="container-lg">
                <div class="assignment-table relative overflow-x-auto">
                    <table class="shadow-lg bg-white" style="width: 100%">
                        <!-- MENGATUR PANJANG JARAK ANTARA FIELD SATU DENGAN YANG LAIN -->
                        <colgroup>
                            <col span="1" style="width: 20%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 10%">
                            <col span="1" style="width: 5%">
                            <col span="1" style="width: 20%">
                            <col span="1" style="width: 10%">
                        </colgroup>
                        <thead>
                            <!-- CONTENT TABEL [JUDUL FIELD] -->
                            <tr class="text-dark-green text-sm lg:text-base">
                                <th class="border-b text-left px-4 py-2">Title</th>
                                <th class="border-b text-center px-4 py-2">Start Date</th>
                                <th class="border-b text-center px-4 py-2">Due Date</th>
                                <th class="border-b text-center px-4 py-2">Due Time</th>
                                <th class="border-b text-center px-4 py-2">Description</th>
                                <th class="border-b text-center px-4 py-2">Assignment Collection</th>
                                <th class="border-b text-center px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <!-- CONTENT TABEL [ISI FIELD] -->
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
                                <!-- MENAMPILKAN SELURUH INFORMASI ASSIGNMENT YANG TELAH DIBUAT -->
                                <tr class="text-sm lg:text-base">
                                    <td class="p-5"><?= $assignment['assignment_name'] ?></td>
                                    <td class="text-center"><?= $startDate; ?></td>
                                    <td class="text-center"><?= $dueDate; ?></td>
                                    <td class="text-center"><?= $dueTime; ?> WIB</td>
                                    <td class=" px-4 py-2 text-center"><a href="#"><img class="w-5 lg:w-7 mx-auto cursor-pointer" src="../../Img/icons/detail_icon.svg" alt="Download Icon" type="button" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" id="showDesc" data-desc="<?= $assignment['assignment_desc'] ?>"></a></td>
                                    <td>
                                        <a href="assignment_collection.php?course_id=<?= $_GET['course_id'] . '&assignment_id=' . $assignment['assignment_id'] . '&subject_id=' . $_GET['subject_id']; ?>"><img class="w-5 lg:w-7 mx-auto cursor-pointer" src="../../Img/icons/binoculars_icon.svg" alt="Collection Icon"></a>
                                    </td>
                                    <td class="flex flex-row justify-center items-center mx-3 my-3">
                                        <a><img class="w-5 lg:w-7 mx-auto cursor-pointer" src="../../Img/icons/edit_icon.svg" alt="Edit Icon" type="button" data-modal-toggle="defaultModal" data-target="#exampleModal<?= $assignment['assignment_id']; ?>" data-assigment-id="<?= $assignment['assignment_id'] ?>" id="editBtn" data-title="<?= $assignment['assignment_name'] ?>" data-date-start="<?= $assignment['assignment_start_date'] ?>" data-date-end="<?= $assignment['assignment_end_date'] ?>" data-desc="<?= $assignment['assignment_desc'] ?>" data-type="<?= $assignment['assignment_type'] ?>"></a>
                                        <a href="assignment.php?act=delete&assign_id=<?= $assignment['assignment_id'] ?>&subject_id=<?= $_GET['subject_id'] ?>&course_id=<?= $_GET['course_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data ini?')"><img class="w-5 lg:w-7 mx-auto cursor-pointer" src="../../Img/icons/delete_icon.svg" alt="Remove Icon"></a>
                                    </td>
                                </tr>

                                <!-- Description Modal -->
                                <div id="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow ">
                                            <!-- Modal header -->
                                            <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                                <h3 class="text-base sm:text-lg lg:text-xl font-medium text-center">
                                                    Description
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-6 space-y-6">
                                                <p class="text-base leading-relaxed">
                                                    <?= $assignment['assignment_desc'] ?>
                                                </p>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                                                <button data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id'] ?>" type="button" class="text-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:ring-2 hover:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2 text-center dark:bg-transparent dark:focus:ring-dark-800 border border-gray-400">Close</button>
                                                <!-- <button data-modal-toggle="medium-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TOMBOL TAMBAH ASSIGNMENT BARU -->
            <a class="text-xs lg:text-base bg-cream text-white font-semibold justify-end text-center py-2 rounded-lg w-[120px] md:w-[170px] ml-auto cursor-pointer" type="button" data-modal-toggle="addModal">Add Assignment</a>

        </div>
    </div>


    <!-- Main Edit modal -->
    <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal Edit content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal Edit header -->
                <div class="flex justify-center items-start p-5 rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-dark">
                        Edit Assignment
                    </h3>
                </div>
                <!-- Modal Edit body -->
                <div class="p-6 space-y-6">
                    <!-- CONTENT FORM EDIT ASSIGNMENT -->
                    <form method="POST" id="modalEditAssignment" enctype="multipart/form-data">
                        <!-- LABEL TITLE -->
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Title</label>
                            <input type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="title">
                        </div>
                        <!-- LABEL START DATE -->
                        <div class="mb-6">
                            <label for="startDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Start Date</label>
                            <input type="datetime-local" id="startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="startDate">
                        </div>
                        <!-- LABEL DUE DATE -->
                        <div class="mb-6">
                            <label for="dueDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Due Date</label>
                            <input type="datetime-local" id="dueDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="dueDate">
                        </div>
                        <!-- LABEL DESKRIPSI -->
                        <div class="mb-6">
                            <label for="deksripsi" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Deskripsi</label>
                            <textarea id="deksripsi" rows="4" class="block p-2.5 w-full text-sm text-dark-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" name="desc"></textarea>
                        </div>
                        <!-- LABEL DROPDOWN TIPE ASSIGNMENT -->
                        <div class="mb-6">
                            <label for="tipe" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Assigment Type</label>
                            <select id="tipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="assign_type">
                                <!-- CONTENT DROPDOWN -->
                                <option value="exam">Exam</option>
                                <option value="task">Assignment</option>

                            </select>
                        </div>
                        <!-- LABEL TOMBOL UPLOAD FILE -->
                        <div class="mb-6">
                            <label for="input" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Dokumen</label>
                            <input type="file" id="input" name="filename" required>
                        </div>
                </div>
                <!-- Modal Edit footer -->
                <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                    <!-- TOMBOL CLOSE -->
                    <button data-modal-toggle="defaultModal" type="button" class="text-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:ring-2 hover:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent dark:focus:ring-dark-800">Close</button>
                    <!-- TOMBOL UPLOAD -->
                    <button type="submit" class="text-white bg-cream focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:bg-gray-600 hover:text-white focus:z-10 dark:bg-[#DDB07F] dark:text--300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" name="edit_assignment">Upload</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Add modal -->
    <div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-screen md:h-full">
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal Add content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal Add header -->
                <div class="flex justify-center items-start p-5 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-dark">
                        Add Assignment
                    </h3>
                </div>
                <!-- Modal Add body -->
                <div class="p-6 space-y-6">
                    <!-- CONTENT FORM TAMBAH ASSIGNMENT BARU -->
                    <form method="POST" action="" id="modalupload" enctype="multipart/form-data">
                        <div class="mb-6">
                            <label for="title" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Title</label>
                            <input type="text" id="upload_title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="title">
                        </div>
                        <!-- LABEL START DATE -->
                        <div class="mb-6">
                            <label for="startDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Start Date</label>
                            <input type="datetime-local" id="upload_startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="start-date">
                        </div>
                        <!-- LABEL DUE DATE -->
                        <div class="mb-6">
                            <label for="dueDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Due Date</label>
                            <input type="datetime-local" id="upload_dueDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="end-date">
                        </div>
                        <!-- LABEL DESKRIPSI -->
                        <div class="mb-6">
                            <label for="deksripsi" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Deksripsi</label>
                            <textarea id="upload_deksripsi" rows="4" class="block p-2.5 w-full text-sm text-dark-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" name="desc"></textarea>
                        </div>
                        <!-- LABEL DROPDOWN TIPE ASSIGNMENT -->
                        <div class="mb-6">
                            <label for="countries" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Assigment Type</label>
                            <select id="upload_assign_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="assign_type">
                                <!-- CONTENT DROPDOWN -->
                                <option value="1">Exam</option>
                                <option value="2">Assigment</option>
                                <option value="3">Try Out</option>

                            </select>
                        </div>
                        <!-- TOMBOL UPLOAD FILE -->
                        <div class="mb-3">
                            <label for="input" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Dokumen</label>
                            <input type="file" id="upload_file" name="filename" required>
                        </div>
                </div>
                <div class="px-5">
                    <div class="progress hidden w-full bg-gray-200 rounded-full dark:bg-gray-700 " id="progressup">
                        <div id="progressbarup" class="bg-dark-green text-xs font-medium text-white text-center p-0.5 leading-none rounded-full">0%</div>
                    </div>
                </div>

                <!-- Modal Add footer -->
                <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                    <!-- TOMBOL CLOSE -->
                    <button data-modal-toggle="addModal" type="button" class="text-gray-500 focus:ring-4 focus:outline-none focus:ring-blue-300 hover:ring-2 hover:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent dark:focus:ring-dark-800" id="btnClsUp">Close</button>
                    <!-- TOMBOL UPLOAD -->
                    <button type="submit" class="text-white bg-cream focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:bg-gray-600 hover:text-white focus:z-10 dark:bg-[#DDB07F] dark:text--300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" name="upload" id="btnUpload">Upload</button>
                    <!-- FUNGSI DISABLE BUTTON -->
                    <button disabled type="button" id="loading" class="hidden text-white bg-cream rounded font-medium ml-auto py-2 px-2 items-center">
                        <svg role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                        </svg>
                        Uploading...
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- CDN FLOWBITE -->
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <!-- CDN JQUERY -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- FUNGSI TOGGLE SIDEBAR -->
    <script>
        let btnToggle = document.getElementById('btnToggle');
        let btnToggle2 = document.getElementById('btnToggle2');
        let sidebar = document.querySelector('.sidebar');
        let leftNav = document.getElementById("left-nav");
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }

        btnToggle2.onclick = function() {
            leftNav.classList.toggle('hidden');
        }
        
        // Bug on click mobile navbar
        // leftNav.onclick = function() {
        //     leftNav.classList.toggle('hidden');
        // }

        $(document).ready(function() {
            // FUNGSI UPLOAD ASSIGNMENT
            $('#btnUpload').click(function(evt) {

                let title = $("#upload_title").val();
                let dueData = $("#upload_dueDate").val();
                let assgType = $("#upload_assign_type").val();
                let startDate = $("#upload_startDate").val();
                let description = $("#upload_deksripsi").val();
                let file = document.getElementById("upload_file");

                console.log(startDate);
                // console.log(file.files[0].type);
                let validTypeFile = [
                    "image/png", // png
                    "image/jpg", // jpg
                    "image/jpeg", // jpeg
                    "text/plain", // txt or html
                    "application/pdf", // pdf
                    "application/vnd.ms-powerpoint",
                    "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // docx
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", // xlsx
                    "application/vnd.openxmlformats-officedocument.presentationml.presentation", // pptx
                    "application/vnd.ms-excel", // xls
                    "application/msword", // doc
                    "application/zip", // zip
                    "application/x-rar" // rar
                ];
                if (title == '' || dueDate == '' || assgType == '' || startDate == '' || description == '' || file == '') {
                    alert('FIeld tidak boleh kosong');
                    evt.preventDefault();
                } else if (jQuery.inArray(file.files[0].type, validTypeFile) == -1) {
                    alert('Ekstensi tidak sesuai !!');
                    evt.preventDefault();
                } else if (file.files[0].size > 2000000) {
                    alert('file tidak boleh lebih dari 2mb');
                    evt.preventDefault();
                } else {
                    $('#btnUpload').attr('disabled', 'true');
                    $('#btnClsUp').attr('disabled', 'true');
                    $('#btnUpload').removeClass('hover:bg-gray-600 hover:text-white focus:z-10');
                    $('#btnClsUp').removeClass('hover:ring-2 hover:ring-gray-400');
                    $('#progressup').removeClass('hidden');
                    $('#progressbarup').width('0%');

                    $('#loading').removeClass('hidden');
                    $('#btnUpload').hide();

                    let data = {
                        "title": title,
                        "dueDate": dueData,
                        "assgType": assgType,
                        "startDate": startDate,
                        "description": description
                    }

                    let formData = new FormData();
                    formData.append("file", file.files[0]);
                    formData.append("data", JSON.stringify(data));

                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    var precentComplete = evt.loaded / evt.total;
                                    precentComplete = parseInt(precentComplete * 100);
                                    $('#progressbarup').html(precentComplete + '%');
                                    $('#progressbarup').width(precentComplete + '%');
                                    console.log(evt.lengthComputable);
                                }
                            }, false);
                            return xhr;
                        },
                        url: "create_assignment.php?course_id=<?= $_GET['course_id'] ?>&subject_id=<?= $_GET['subject_id'] ?>",
                        type: "post",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            let val = JSON.parse(data);
                            if (val.is_ok) {
                                alert(val.msg);
                                location.reload();
                            } else {
                                alert("Error!" + val.msg);
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('Error! Check your connection!');
                        }
                    })
                }

            })
            // FUNGSI EDIT ASSIGNMENT
            $(document).on('click', '#editBtn', function() {

                let title2 = document.getElementById('title');
                let desc2 = document.getElementById('deksripsi');
                let type2 = document.getElementById('tipe');

                let assigmentId = $(this).data('assigment-id');
                let title = $(this).data('title');
                let startDate = $(this).data('date-start');
                console.log(new Date(startDate).toJSON().slice(0, 19))
                console.log();
                //
                let dueDate = $(this).data('date-end');
                console.log(dueDate)
                let desc = $(this).data('desc');
                let type = $(this).data('type');
                $(title2).val(title)
                $(desc2).val(desc)
                $('#startDate').val(startDate.slice(0, 10) + "T" + startDate.slice(11, 16))
                $('#dueDate').val(dueDate.slice(0, 10) + "T" + dueDate.slice(11, 16))
                if (type == "task") {
                    $("option[value='task']").remove();
                    $(type2).append(`<option value="${type}" selected>Assignment</option>`);
                } else {
                    $("option[value='exam']").remove();
                    $(type2).append(`<option value="${type}" selected>Exam</option>`);
                }
                $('#modalEditAssignment').attr('action', 'assignment.php?act=edit&assign_id=' + assigmentId + '&subject_id=<?= $_GET['subject_id'] ?>&course_id=<?= $_GET['course_id']; ?>')
            })

            $(document).on('click', '#showDesc', function() {
                let desc = $(this).data('desc');
            })


        })
    </script>


</body>

</html>