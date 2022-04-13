<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ['Montserrat'],
                    },
                    colors: {
                        'dark-green': '#1E3F41',
                        'light-green': '#659093',
                        cream: '#DDB07F',
                        cgray: '#F5F5F5',
                    },
                },
            },
        }
    </script>
</head>

<body>
    <table class="bg-white" style="width: 100%;">
        <colgroup>
            <col span="1" style="width: 30%;" />
            <col span="1" style="width: 30%;" />
            <col span="1" style="width: 30%;" />
        </colgroup>
        <thead>
            <tr class="text-dark-green">
                <th class="border-b text-left px-4 py-2">Name</th>
                <th class="border-b text-center px-4 py-2">
                    Published Date
                </th>
                <th class="border-b text-center px-4 py-2">File</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require "../../Model//AssignmentSubmission.php";

            $objAssignment = new AssignmentSubmission;

            $allAssignments = $objAssignment->getAllAssignmentBySubject($_GET['subject_id']);
            var_dump($allAssignments);
            // var_dump($allAssignments);
            foreach ($allAssignments as $row => $assignment) :
                // foreach ($assignment as $key => $item) :

                //     echo ($item);
            ?>


                <tr>
                    <td class="border-b px-4 py-2">
                        <p class="text-dark-green"><?= $assignment['username']; ?></p>
                    </td>
                    <td class="border-b px-4 py-2 text-center">
                        <p class="text-dark-green"><?= $assignment['submitted_date']; ?></p>
                    </td>


                    <td class="border-b px-4 py-2 text-center">
                        <a href="download.php?path=./Upload/Assignment/Submission/Submission<?= $assignment['submission_filename']; ?>">
                            <p class="text-dark-green"><?= $assignment['submission_filename']; ?></p>
                        </a>
                    </td>
                </tr>
            <?php
            // endforeach;

            endforeach ?>

        </tbody>
    </table>
</body>

</html>