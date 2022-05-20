<?php

session_start();

$loginPath = "../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
    die;
}

switch ($_SESSION['user']->{'role_id'}) {
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


require_once './api/get_api_data.php';

$data = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_modul_rows.php"));
$courseData = array();

for ($i = 0; $i < count($data->{'data'}); $i++) {
    if ($data->{'data'}[$i]->{'parent_id'} == null) {
        array_push($courseData, $data->{'data'}[$i]);
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

</head>

<body>
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <div class="bg-white w-[350px] h-screen px-8 py-6 flex flex-col justify-between sidebar in-active">
            <!-- Top nav -->
            <div class="flex flex-col gap-y-6">
                <!-- Header -->
                <div class="flex items-center space-x-4 px-2">
                    <img src="Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle">
                    <img class="w-[150px] logo-incareer" src="./Img/logo/logo_primary.svg" alt="Logo In Career">
                </div>

                <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">

                <!-- List Menus -->
                <div>
                    <ul class="flex flex-col gap-y-1">
                        <li>

                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="./Img/icons/home_icon.svg" alt="Dashboard Icon">
                                <p class="font-semibold">Dashboard</p>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                                <img class="w-5" src="./Img/icons/course_icon.svg" alt="Course Icon">
                                <p class="text-white font-semibold">Courses</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="./Img/icons/score_icon.svg" alt="Score Icon">
                                <p class="font-semibold">Score</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="./Img/icons/schedule_icon.svg" alt="Schedule Icon">
                                <p class="font-semibold">Schedule</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="./Img/icons/attendance_icon.svg" alt="Attendance Icon">
                                <p class="font-semibold">Attendance</p>
                            </a>
                        </li>
                        <li>
                            <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                                <img class="w-5" src="./Img/icons/consult_icon.svg" alt="Consult Icon">
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
                            <img class="w-5" src="./Img/icons/help_icon.svg" alt="Help Icon">
                            <p class="font-semibold">Help</p>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                            <img class="w-5" src="./Img/icons/logout_icon.svg" alt="Log out Icon">
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
                <img class="w-10" src="./Img/icons/default_profile.svg" alt="Profile Image">
                <p class="text-dark-green font-semibold">User Name</p>
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
                        <a class="text-dark-green font-semibold" href="#">Score</a>
                    </li>
                </ul>
            </div>
            <div class="container- bg-white p-4 rounded">
                <div class="container" style="display: table;">
                    <div class="container p-4 rounded my-4">
                        <div class="container" style="display: table;">
                            <div class="section-period" style="display: table-row;">
                                <p class="font-bold" style="display: table-cell; width: 5%;">Period :</p>
                                <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected></option>
                                    <option value="US">Filter 1</option>
                                    <option value="US">Filter 2</option>
                                    <option value="US">Filter 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <colgroup>
                                <col span="1" style="width: 10%">
                                <col span="1" style="width: 10%">
                                <col span="1" style="width: 10%">
                                <col span="1" style="width: 10%">
                                <col span="1" style="width: 10%">
                                <col span="1" style="width: 10%">

                            </colgroup>
                            <thead class="text-xs text-gray-700 uppercase bg-cream">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Course
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Assignment Subject
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Weight
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Score
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Grade
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courseData as $item) : ?>
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <?= $item->modul_name ?>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <table>
                                                <?php
                                                $dataSub = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_childs.php?id=$item->id"));
                                                $dataSub = $dataSub->data;
                                                ?>
                                                <?php foreach ($dataSub as $itemSub) { ?>
                                                    <tr>
                                                        <td>
                                                            <p class="py-2"><?= $itemSub->modul_name ?></p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>

                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <table>
                                                <?php
                                                $dataWeg = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_childs.php?id=$item->id"));
                                                $dataWeg = $dataWeg->data; ?>
                                                <?php foreach ($dataWeg as $itemWeg) { ?>
                                                    <tr>
                                                        <td>
                                                            <p class="py-2"><?= $itemWeg->modul_weight * 100 ?>%</p>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            </table>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <table>

                                            </table>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            92
                                        </td>
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            A
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
            <script>
                let btnToggle = document.getElementById('btnToggle');
                let sidebar = document.querySelector('.sidebar');
                btnToggle.onclick = function() {
                    sidebar.classList.toggle('in-active');
                }
            </script>


</body>

</html>