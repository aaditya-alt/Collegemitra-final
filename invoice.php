<?php

namespace APITestCode;
session_start();
require_once '../collegemitra/assets/php/predictor.php';
require_once('../user-system/assets/php/payment/PayU.php');
$payu_obj = new PayU();

$payu_obj->env_prod = 0;  //  1 for Live Environment/ 0 for SandBox Environment
$payu_obj->key = 'gMBh5o';
$payu_obj->salt = 'dBUXALRJ0BEhgQM1xIYEwcqVzgrwBbnv';

$txnid = $_SESSION['txnid'];
$name = $_SESSION['name'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$counselling = $_SESSION['counselling'];
$counselling_tables = explode(',', $counselling);
$rank = $_SESSION['rank'];
$state = $_SESSION['state'];
$category = $_SESSION['category'];
$gender = $_SESSION['gender'];
$dob = $_SESSION['dob'];
$phone = $_SESSION['phone'];
$hpass = password_hash($password, PASSWORD_DEFAULT);

$res = $payu_obj->getTransactionByTxnId($txnid);
$paid_on = $res['addedon'];


if($res['status'] == 'success'){
    if(user_exist($email)){
        echo '<script type ="text/JavaScript">';  
        echo 'alert("User Already Exist!")';  
        echo '</script>';  
    }
    else{
        if(register($name,$email,$hpass,$counselling, $state, $category, $txnid, $paid_on, $gender, $rank, $dob, $phone, 1)){
            $_SESSION['user'] = $email;
        }
        else{
            echo 'Something went wrong! try again later!';
        }
    }

    $users_data = user_exist($email);
    $uid = $users_data['id'];

    for($i =0; $i<count($counselling_tables);){
    
        $sql = "INSERT INTO $counselling_tables[$i](uid, name, rank, phone, category, email, state, counselling, gender) VALUES (:uid, :name, :rank, :phone, :category, :email, :state, :counselling, :gender)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['counselling'=>$counselling, 'uid'=>$uid, 'name'=>$name, 'rank'=>$rank, 'phone'=>$phone, 'category'=>$category, 'email'=>$email, 'state'=>$state, 'gender'=>$gender]);
        $i =$i+1;
}
    
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Custom Style -->
    <style>
        :root {
    --body-bg: rgb(204, 204, 204);
    --white: #ffffff;
    --darkWhite: #ccc;
    --black: #000000;
    --dark: #615c60;
    --themeColor: #22b8d1;
    --pageShadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

/* Font Include */
@import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap');

body {
    background-color: var(--body-bg);
}

.page {
    background: var(--white);
    display: block;
    margin: 0 auto;
    position: relative;
    box-shadow: var(--pageShadow);
}

.page[size="A4"] {
    width: 21cm;
    height: 29.7cm;
    overflow: hidden;
}

.bb {
    border-bottom: 3px solid var(--darkWhite);
}

/* Top Section */
.top-content {
    padding-bottom: 15px;
}

.logo img {
    height: 80px;
    width: 150px;
}

.top-left p {
    margin: 0;
}

.top-left .graphic-path {
    height: 40px;
    position: relative;
}

.top-left .graphic-path::before {
    content: "";
    height: 20px;
    background-color: var(--dark);
    position: absolute;
    left: 15px;
    right: 0;
    top: -15px;
    z-index: 2;
}

.top-left .graphic-path::after {
    content: "";
    height: 22px;
    width: 17px;
    background: var(--black);
    position: absolute;
    top: -13px;
    left: 6px;
    transform: rotate(45deg);
}

.top-left .graphic-path p {
    color: var(--white);
    height: 40px;
    left: 0;
    right: -100px;
    text-transform: uppercase;
    background-color: var(--themeColor);
    font: 26px;
    z-index: 3;
    position: absolute;
    padding-left: 10px;
}

/* User Store Section */
.store-user {
    padding-bottom: 25px;
}

.store-user p {
    margin: 0;
    font-weight: 600;
}

.store-user .address {
    font-weight: 400;
}

.store-user h2 {
    color: var(--themeColor);
    font-family: 'Rajdhani', sans-serif;
}

.extra-info p span {
    font-weight: 400;
}

/* Product Section */
thead {
    color: var(--white);
    background: var(--themeColor);
}

.table td,
.table th {
    text-align: center;
    vertical-align: middle;
}

tr th:first-child,
tr td:first-child {
    text-align: left;
}

.media img {
    height: 60px;
    width: 60px;
}

.media p {
    font-weight: 400;
    margin: 0;
}

.media p.title {
    font-weight: 600;
}

/* Balance Info Section */
.balance-info .table td,
.balance-info .table th {
    padding: 0;
    border: 0;
}

.balance-info tr td:first-child {
    font-weight: 600;
}

tfoot {
    border-top: 2px solid var(--darkWhite);
}

tfoot td {
    font-weight: 600;
}

/* Cart BG */
.cart-bg {
    height: 250px;
    bottom: 32px;
    left: -40px;
    opacity: 0.3;
    position: absolute;
}

/* Footer Section */
footer {
    text-align: center;
    position: absolute;
    bottom: 30px;
    left: 75px;
}

footer hr {
    margin-bottom: -22px;
    border-top: 3px solid var(--darkWhite);
}

footer a {
    color: var(--themeColor);
}

footer p {
    padding: 6px;
    border: 3px solid var(--darkWhite);
    background-color: var(--white);
    display: inline-block;
}

    </style>

    <title>Invoice..!</title>
</head>

<body>
    <script>
        alert('Your Transaction Has Been SuccessFully Submitted!');
    </script>

   <div class="my-5 page" size="A4" id="invoice">
        <div class="p-5">
            <section class="top-content bb d-flex justify-content-between">
                <div class="logo">
                    <img src="assets/logo1.jpg" alt="" class="img-fluid" style="font-size: 150%;">
                </div>
                <div class="top-left">
                    <div class="graphic-path">
                        <p>Invoice</p>
                        
                    </div>
                    <div class="position-relative">
                        <p>Invoice No. <span>XXXX</span></p>
                    </div>
                </div>
            </section>

            <section class="store-user mt-5">
                <div class="col-10">
                    <div class="row bb pb-3">
                        <div class="col-7">
                            <p>Service,</p>
                            <h2 style="font-size: 110%;">Collegemitra</h2>
                            <p class="address"> Hisar, <br> Haryana, 125001 <br> </p>
                        </div>
                        <div class="col-5">
                            <p>Client,</p>
                            <h2 style="font-size: 110%;"><?php echo $res['firstname']; ?></h2>
                            <div class="txn mt-2">Transaction Id: <b style="color: var(--themeColor)"><?php echo $txnid; ?></b></div>
                        </div>
                    </div>
                    <div class="row extra-info pt-3">
                        <div class="col-7">
                            <p>Payment Method: <span><?php echo $res['mode']; ?></span></p>
                            <p>Order Number: <span>#868</span></p>
                        </div>
                        <div class="col-5">
                            <p>Deliver Date: <span><?php echo $res['addedon']; ?></span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="product-area mt-4">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Item Description</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="media">
                                    
                                    <div class="media-body">
                                        <p class="mt-0 title"><?php echo $res['productinfo']; ?></p>
                                        
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $res['amt']; ?></td>
                            <td>1</td>
                            <td><?php echo $res['amt']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section class="balance-info">
                <div class="row">
                    <div class="col-8">
                        <p class="m-0 font-weight-bold"> Note: </p>
                        <p>Thank You For Purchasing Collegemitra Premium Services! You'll Recieve an Email Soon Containing All The Details For Further Processes and User Mannual.</p>
                    </div>
                    <div class="col-4">
                        <table class="table border-0 table-hover">
                            <tr>
                                <td>Sub Total:</td>
                                <td><?php echo $res['amt']; ?></td>
                            </tr>
                            <tr>
                                <td>Tax:</td>
                                <td>₹78</td>
                            </tr>
                            <tr>
                                <td>Discount:</td>
                                <td>₹78</td>
                            </tr>
                            <tfoot>
                                <tr>
                                    <td>Total:</td>
                                    <td><?php echo $res['amt']; ?></td>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- Signature -->
                        <div class="col-12" style="padding-top: 50px;">
                            <img src="signature.png" class="img-fluid" alt="">
                            <p class="text-center m-0"> Director Signature </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cart BG -->
            <img src="/assets/logo.png" class="img-fluid cart-bg" alt="">

            <footer>
                <hr>
                <p class="m-0 text-center">
                    Access Premium Portal Here - <a href="https://collegemitra.net.in/collegemitra">collegemitra </a>
                </p>
                <div class="social pt-3">
                    <span class="pr-2">
                        <i class="fas fa-mobile-alt"></i>
                        <span>0123456789</span>
                    </span>
                    <span class="pr-2">
                        <i class="fas fa-envelope"></i>
                        <span>me@saburali.com</span>
                    </span>
                    <span class="pr-2">
                        <i class="fab fa-facebook-f"></i>
                        <span>/sabur.7264</span>
                    </span>
                    <span class="pr-2">
                        <i class="fab fa-youtube"></i>
                        <span>/abdussabur</span>
                    </span>
                    <span class="pr-2">
                        <i class="fab fa-github"></i>
                        <span>/example</span>
                    </span>
                </div>
            </footer>
        </div>
    </div>






<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    function CreatePDFfromHTML() {
    var HTML_Width = $("#invoice").width();
    var HTML_Height = $("#invoice").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#invoice")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("Your_PDF_Name.pdf");
        $("#invoice").hide();
    });
}
</script>



</body></html>