<?php
include("connect.php");
require 'vendor/autoload.php';

use Mpdf\Mpdf;

// Data for the admit card
$registration_no=$_GET['registration_no'];
$exam=$_GET['exam'];
$sql="select * from student where registration_no='$registration_no'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
$name=$row['name'];
$hall=$row['hall'];
$department=$row['department'];
$session=$row['session'];
$exam_roll=$row['exam_roll'];
$class_roll=$row['id'];
// Create an instance of mPDF
$mpdf = new Mpdf([
  'format' => 'A4-L' // Set the format to A4 size in landscape mode
]);

// Create HTML content for the admit card
$html = '
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            align:center;
        }
        .logo, .header, .exam-name {
          text-align: center;
      }
        .admit-card {
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            position: relative;
        }
        .logo {
            margin-right: 20px;
        }
        .header {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .details {
            display: flex;
            justify-content: space-between;
        }
        .details-left, .details-right {
            flex: 1;
        }
        .content {
            font-size: 18px;
            line-height: 1.6;
        }
        .content p {
            margin: 5px 0;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            font-size: 16px;
        }
        .exam-name {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .uni
        {
          font-size: 15px;
        }
        .center {
          margin: 0 auto;
          width: 50%; /* Adjust as per your requirement */
          padding: 20px;
        }
    
        /* Styling the table */
        table {
          width: 100%;
          border-collapse: collapse;
        }
    
        th, td {
          padding: 8px;
          text-align: left;
          font-size: 18px;
          font-weight: bold;
        }
        img
        {
          display: block;
          margin-left: auto;
          margin-right: auto;

        }
        #sign
        {
          float: right;
        }
        .new4 {
          border: 1px solid red;
        }
    </style>
</head>
<body>
    <div class="admit-card">
        <div  class="center">
        <table>
        <tr>
        <td rowspan="2"> <img src="logo-ju.png" alt="JU Logo" width="100" height="100">
        <td> 
        <div class="header">
                    Office of the Controller of Examinations
                    <br>
                    <span class="uni">
                    Jahangirnagar University, Savar, Dhaka
                    </span>
                </div>
        </td>
        </tr>
        </table>
        </div>
            <div class="details-right">
                <div class="header">
                    Admit Card
                </div>
                <div class="exam-name">' . $exam . '</div>
                <div>
                    <table>
                    <tr>
                    <td> <p><strong>Student Name:</strong> ' . $name . '</p></td>
                    <td rowspan=5><img src="images/'.$row['image'].'" width="120px" height="120px" alt=""></td>
                    </tr>
                    <tr>
                    <td> <p><strong>Hall:</strong> ' . $hall . '</p></td>
                    </tr>
                    <tr>
                    <td> <p><strong>Department:</strong> ' . $department . '</p></td>
                    </tr>
                    <tr>
                    <td> <p><strong>Registration No:</strong> ' . $registration_no . '</p></td>
                    </tr>
                    <tr>
                    <td><p><strong>Admission Session:</strong> ' . $session . '</p></td>
                    </tr>
                    <tr>
                    <td><p><strong>Examination Roll:</strong> ' . $exam_roll . '</p></td>
                    <td class="center" id="sign"> <img src="sign.png" alt="JU Logo" width="100" height="50" class="sign"></td>
                    </tr>
                    <tr>
                    <td><p><strong>Class Roll:</strong> ' . $class_roll . '</p></td>
                    <td><hr class="new4"> <br> Assistant Controller of examination </td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
';

// Write HTML content to PDF
$mpdf->WriteHTML($html);

// Output the PDF to browser
$mpdf->Output('admit_card.pdf', \Mpdf\Output\Destination::INLINE);
