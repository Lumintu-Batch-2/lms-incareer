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

require "../../Model/Assignments.php";
require "../../Model/AssignmentSubmission.php";


$objAssignment = new Assignments;

$allAssignments = $objAssignment->getAssignmentBySubjectId($_GET['subject_id']);

if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case "edit":
            if ($_GET['assign_id']) {
              
                if (isset($_POST['edit_assignment'])) {
                    
                   $dataArray = [
                       "title" => $_POST['title'],
                       "desc" => $_POST['desc'],
                       "start-date" => date('Y-m-d h:i:s', strtotime( $_POST['startDate'])),
                       "end-date"=> date('Y-m-d h:i:s', strtotime( $_POST['dueDate'])),
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
            if ($_GET['assign_id']) {
                $objAssignment->setAssignmentId($_GET['assign_id']);
                $deleteStat = $objAssignment->deleteAssignment();

                if ($deleteStat) {
                    echo "
                    <script>
                        alert('Data berhasil dihapus!');
                        location.replace('assignment.php?subject_id=" . $_GET['subject_id'] . "')
                    </script>";
                } else {
                    echo "Data gagal dihapus!";
                    header("location: assignment.php?subject_id=" . $_GET['subject_id']);
                }
            }
            break;
        case "logout":
            if(isset($_GET['act'])){
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
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />

    <style>

        .active{
            color: #DDB07F !important;
            border-bottom: solid 4px #DDB07F;
        }

        .in-active{
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }
        .in-active ul li p{
            display: none !important;
        }

        .in-active ul li a{
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-incareer{
            display: none !important;
        }
        .hidden{
            display: none !important;
        }
        .sidebar{
            transition: .5s ease-in-out;
        }
    </style>
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
                            <a href="assignment.php?act=logout" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
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
                <p class="text-dark-green font-semibold"><?=$_SESSION['user']->{'user_first_name'} . " " . $_SESSION['user']->{'user_last_name'} ?></p>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green" href="#">Home</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="#">Courses</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="#">Sub Topic</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-dark-green font-semibold" href="#">Assignment</a>
                    </li>
                </ul>
            </div>

            <!-- Topic Title -->
            <div>
                <p class="text-4xl text-dark-green font-semibold">Session#1 Sub Topic Title</p>
            </div>

            <!-- Mentor -->
            <div class="flex items-center gap-x-4 w-full bg-white py-4 px-10 rounded-xl">
                <img class="w-14" src="../../Img/icons/default_profile.svg" alt="Profile Image">
                <div class="">
                    <p class="text-dark-green text-base font-semibold"><?=$_SESSION['user']->{'user_first_name'} . " " . $_SESSION['user']->{'user_last_name'} ?> | Mentor Code</p>
                    <p class="text-light-green">Mentor Specialization</p>
                </div>
            </div>

            <!-- Tab -->
            <div class="bg-white w-full h-[50px] flex content-center px-10">
                <ul class="flex items-center gap-x-8">
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer">
                        <p>Session</p>
                    </li>
                    <li class="text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer active">Assignment</li>
                </ul>
            </div>

            <!-- Direction -->
            <div class="bg-white w-full p-6">
                <p class="text-dark-green font-semibold">Description :</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex quo dolore atque eveniet iusto iste accusantium sint, obcaecati unde totam labore omnis sit laborum, architecto quia ea laboriosam libero soluta accusamus modi laudantium quod neque rerum quaerat. Quasi eaque officiis, commodi maiores, nisi asperiores distinctio magni quas, itaque facere consequuntur eos pariatur voluptatum illum tenetur esse. Provident excepturi velit maxime non officia voluptas nisi. Quod dolorum quisquam obcaecati ad laudantium maiores, aperiam eveniet voluptate ab. Asperiores ducimus, minus impedit enim reiciendis sit aperiam ut labore, facere rerum tempora. Molestias nesciunt beatae consequatur minus dolorum tempora culpa cum, tenetur corrupti facilis.</p>
            </div>

            <!-- Table Assignment -->
            <div>
                <table class="shadow-lg bg-white" style="width: 100%">
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
                        <tr class="text-dark-green">
                            <th class="border-b text-left px-4 py-2">Title</th>
                            <th class="border-b text-center px-4 py-2">Start Date</th>
                            <th class="border-b text-center px-4 py-2">Due Date</th>
                            <th class="border-b text-center px-4 py-2">Due Time</th>
                            <th class="border-b text-center px-4 py-2">Description</th>
                            <th class="border-b text-center px-4 py-2">Assignment Collection</th>
                            <th class="border-b text-center px-4 py-2">Actions</th>
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
                                <td class="p-5"><?= $assignment['assignment_name'] ?></td>
                                <td class="text-center"><?= $startDate; ?></td>
                                <td class="text-center"><?= $dueDate; ?></td>
                                <td class="text-center"><?= $dueTime; ?> WIB</td>
                                <td class="border-b px-4 py-2 text-center"><a href="#"><img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/detail_icon.svg" alt="Download Icon" type="button" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id']?>" id="showDesc" data-desc="<?= $assignment['assignment_desc']?>"></a></td>
                                <td>
                                <a href="assignment_collection.php?course_id=<?= (int)$_GET['course_id'] . '&assignment_id=' . $assignment['assignment_id'] . "&subject_id=" . $_GET['subject_id']; ?>"><img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/binoculars_icon.svg" alt="Collection Icon"></a></td>
                                <td class="flex flex-row justify-center items-center mx-3 my-3">
                                    <a><img class="w-7 mx-auto cursor-pointer mx-2" src="../../Img/icons/edit_icon.svg" alt="Edit Icon" type="button" data-modal-toggle="defaultModal" data-target="#exampleModal<?= $assignment['assignment_id']; ?>" data-assigment-id="<?=$assignment['assignment_id']?>" id="editBtn" data-title="<?= $assignment['assignment_name']?>" data-date-start="<?= $assignment['assignment_start_date']?>" data-date-end="<?= $assignment['assignment_end_date']?>" data-desc="<?= $assignment['assignment_desc']?>" data-type="<?= $assignment['assignment_type']?>"></a>
                                    <a href="assignment.php?act=delete&assign_id=<?= $assignment['assignment_id']?>&subject_id=<?=$_GET['subject_id']?>"<?= $assignment['assignment_id']?> onclick="return confirm('Apakah anda yakin menghapus data ini?')"><img class="w-7 mx-auto cursor-pointer" src="../../Img/icons/delete_icon.svg" alt="Remove Icon"></a>      
                                </td>
                            </tr>

                            <!-- Description Modal -->
                            <div id="medium-modal<?= "medium-modal" . $assignment['assignment_id']?>" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <!-- Modal header -->
                                        <div class="flex justify-between items-center p-5 rounded-t border-b dark:border-gray-600">
                                            <h3 class="text-xl font-medium text-center">
                                                Description
                                            </h3>
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id']?>">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
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
                                            <button data-modal-toggle="medium-modal<?= "medium-modal" . $assignment['assignment_id']?>" type="button" class="text-gray bg-cream focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent hover:text-white hover:bg-gray-600 dark:focus:ring-dark-800">Close</button>
                                            <!-- <button data-modal-toggle="medium-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Decline</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </tbody>                  
                </table>
            </div>

            <a class="bg-cream text-white font-semibold justify-end text-center py-2 rounded-lg w-[170px] ml-auto cursor-pointer" type="button" data-modal-toggle="addModal">Add Assignment</a>

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
                <form method="POST" id="modalEditAssignment" enctype="multipart/form-data">
                   <div class="mb-6">
                        <label for="title" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Title</label>
                        <input type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="title">
                    </div>
                     <div class="mb-6">
                        <label for="startDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Start Date</label>
                        <input type="datetime-local" id="startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="startDate">
                    </div>
                     <div class="mb-6">
                        <label for="dueDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Due Date</label>
                        <input type="datetime-local" id="dueDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="dueDate">
                    </div>
                    <div class="mb-6">
                       <label for="deksripsi" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Deksripsi</label>
                       <textarea id="deksripsi" rows="4" class="block p-2.5 w-full text-sm text-dark-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" name="desc"></textarea>
                    </div>
                    <div class="mb-6">
                      <label for="tipe" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Assigment Type</label>
                        <select id="tipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="assign_type">
                        <option value="exam">Exam</option>
                        <option value="task">Assignment</option>
                        
                        </select>
                    </div>
                     <div class="mb-6">
                      <label for="input" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Dokumen</label>
                      <input type="file" id="input" name="filename" required >
                    </div>
                </div>
                <!-- Modal Edit footer -->
                <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="defaultModal" type="button" class="text-gray bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent hover:text-white hover:bg-gray-600 dark:focus:ring-dark-800">Close</button>
                    <button type="submit" class="text-dark-500 bg-[#DDB07F] hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-[#DDB07F] dark:text--300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"  name="edit_assignment">Upload</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Main Add modal -->
    <div id="addModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal Add content -->
            <div class="relative bg-white rounded-lg shadow ">
                <!-- Modal Add header -->
                <div class="flex justify-center items-start p-5 rounded-t ">
                    <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-dark">
                        Add Assignment
                    </h3>
                </div>
                <!-- Modal Add body -->
                <div class="p-6 space-y-6">
                <form method="POST" action="./create_assignment.php?course_id=<?= $_GET['course_id']?>&subject_id=<?=$_GET['subject_id']?>" enctype="multipart/form-data">
                   <div class="mb-6">
                        <label for="title" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Title</label>
                        <input type="text" id="title" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="title">
                    </div>
                     <div class="mb-6">
                        <label for="startDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Start Date</label>
                        <input type="datetime-local" id="startDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="start-date">
                    </div>
                     <div class="mb-6">
                        <label for="dueDate" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Due Date</label>
                        <input type="datetime-local" id="dueDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" required name="end-date">
                    </div>
                    <div class="mb-6">
                       <label for="deksripsi" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Deksripsi</label>
                       <textarea id="deksripsi" rows="4" class="block p-2.5 w-full text-sm text-dark-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-white-700 dark:border-gray-300 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500" name="desc"></textarea>
                    </div>
                    <div class="mb-6">
                      <label for="countries" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Assigment Type</label>
                        <select id="assign_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="assign_type">
                        <option value="exam" >Exam</option>
                        <option value="task">Assigment</option>
                        
                        </select>
                    </div>
                     <div class="mb-6">
                      <label for="input" class="block mb-2 text-sm font-bold text-dark-900 dark:text-dark-300">Dokumen</label>
                      <input type="file" id="input" name="filename" required >
                    </div>
                </div>
                <!-- Modal Add footer -->
                <div class="flex justify-end p-6 space-x-2 rounded-b border-gray-200 dark:border-gray-600">
                    <button data-modal-toggle="addModal" type="button" class="text-gray bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-transparent hover:text-white hover:bg-gray-600 dark:focus:ring-dark-800">Close</button>
                    <button type="submit" class="text-dark-500 bg-[#DDB07F] hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-[#DDB07F] dark:text--300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"  name="upload">Upload</button>
                </div>
                </form>
            </div>
        </div>
    </div>    
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <script>
        let btnToggle = document.getElementById('btnToggle');
        let sidebar = document.querySelector('.sidebar');
        btnToggle.onclick = function(){
            sidebar.classList.toggle('in-active');
        }
        
        $(document).ready(function(){
            $(document).on('click', '#editBtn', function(){

                let title2 = document.getElementById('title');
                let desc2 = document.getElementById('deksripsi');
                let type2 = document.getElementById('tipe');
                
                let assigmentId = $(this).data('assigment-id');
                let title = $(this).data('title');
                let startDate = $(this).data('date-start');
                console.log(new Date(startDate).toJSON().slice(0,19))
                console.log();
                // 
                let dueDate = $(this).data('date-end');
                console.log(dueDate)
                let desc = $(this).data('desc');
                let type = $(this).data('type');
                $(title2).val(title)
                $(desc2).val(desc)
                $('#startDate').val(startDate.slice(0,10)+"T"+startDate.slice(11,16))
                $('#dueDate').val(dueDate.slice(0,10)+"T"+dueDate.slice(11,16))
                if(type == "task"){
                    $("option[value='task']").remove();
                    $(type2).append(`<option value="${type}" selected>
                                           Assignment
                                      </option>`);
                }else{
                    $("option[value='exam']").remove();
                    $(type2).append(`<option value="${type}" selected>
                                           Exam
                                      </option>`);
                }
                $('#modalEditAssignment').attr('action', 'assignment.php?act=edit&assign_id=' +assigmentId+'&subject_id=<?=$_GET['subject_id']?>')
            })

            $(document).on('click', '#showDesc', function() {
                let desc = $(this).data('desc');
            })
                
            
        })
    </script>
</body>
</html>