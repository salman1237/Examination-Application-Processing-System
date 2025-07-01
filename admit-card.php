<?php
session_start();
include("connect.php");

// Data for the admit card
$registration_no = isset($_GET['registration_no']) ? $_GET['registration_no'] : '';
$exam = isset($_GET['exam']) ? $_GET['exam'] : '';

if (!empty($registration_no)) {
    $sql = "select * from student where registration_no='$registration_no'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($result);
    $name = $row['name'];
    $hall = $row['hall'];
    $department = $row['department'];
    $session = $row['session'];
    $exam_roll = $row['exam_roll'];
    $class_roll = $row['id'];
    $image = $row['image'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admit Card</title>
    <link href="https://fonts.googleapis.com/css?family=Inconsolata&display=swap" rel="stylesheet" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .admit-card {
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                page-break-after: always;
            }
        }

        body {
            font-family: 'Inconsolata', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .admit-card {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
            /* 16:9 aspect ratio container */
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* 9/16 = 0.5625 or 56.25% */
        }

        .admit-card-inner {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }

        .university-header {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }

        .logo {
            margin-right: 10px;
        }

        .university-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .university-subtitle {
            font-size: 12px;
            text-align: center;
        }

        .exam-name {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .card-body {
            padding: 15px;
            display: flex;
            flex: 1;
            font-size: 14px;
        }

        .student-details {
            flex: 3;
        }

        .student-photo {
            flex: 1;
            display: flex;
            justify-content: right;
            align-items: flex-start;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 6px;
            font-size: 14px;
            border-bottom: 1px solid #dee2e6;
        }

        .details-table td:first-child {
            font-weight: bold;
            width: 40%;
        }

        .signature-section {
            margin-top: -20px;
            /* Adjust this value as needed to move the signature up */
            text-align: right;
            position: absolute;
            bottom: 20px;
            /* You can reduce this value as well if necessary */
            right: 30px;
        }


        .signature-line {
            width: 150px;
            border-top: 1px solid #000;
            margin-top: 5px;
            margin-left: auto;
            margin-right: 0;
        }

        .signature-title {
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }


        img.student-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid #007bff;
            border-radius: 5px;
        }

        img.signature-img {
            height: 40px;
            margin-bottom: 5px;
        }

        img.logo-img {
            height: 60px;
            width: auto;
        }

        .print-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .print-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="no-print" style="margin-bottom: 15px;">
            <button class="print-button" onclick="window.print()">Print Admit Card</button>
            <a href="student-dashboard.php" class="btn btn-secondary" style="margin-left: 10px;">Back to Dashboard</a>
        </div>

        <div class="admit-card">
            <div class="admit-card-inner">
                <div class="card-header">Admit Card</div>

                <div class="university-header">
                    <div class="logo">
                        <img src="logo-ju.png" alt="JU Logo" class="logo-img">
                    </div>
                    <div>
                        <div class="university-title">Office of the Controller of Examinations</div>
                        <div class="university-subtitle">Jahangirnagar University, Savar, Dhaka</div>
                    </div>
                </div>

                <div class="exam-name"><?php echo $exam; ?></div>

                <div class="card-body">
                    <div class="student-details">
                        <table class="details-table">
                            <tr>
                                <td>Student Name</td>
                                <td><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <td>Hall</td>
                                <td><?php echo $hall; ?></td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td><?php echo $department; ?></td>
                            </tr>
                            <tr>
                                <td>Registration No</td>
                                <td><?php echo $registration_no; ?></td>
                            </tr>
                            <tr>
                                <td>Admission Session</td>
                                <td><?php echo $session; ?></td>
                            </tr>
                            <tr>
                                <td>Examination Roll</td>
                                <td><?php echo $exam_roll; ?></td>
                            </tr>
                            <tr>
                                <td>Class Roll</td>
                                <td><?php echo $class_roll; ?></td>
                            </tr>
                        </table>

                        <div class="signature-section">
                            <img src="sign.png" alt="Signature" class="signature-img">
                            <div class="signature-line"></div>
                            <div class="signature-title">Assistant Controller of Examinations</div>
                        </div>
                    </div>

                    <div class="student-photo">
                        <img src="images/<?php echo $image; ?>" alt="Student Photo" class="student-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>