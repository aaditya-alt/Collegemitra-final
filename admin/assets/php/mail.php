<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=db_user_system", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require './phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer();


if(isset($_FILES['pdf'])){
    $id =$_POST['id'];
    $email = $_POST['email'];
    $percentile = $_POST['percentile'];
    $state = $_POST['state'];
    $category = $_POST['category'];

    $folder = 'collegeList/';

    $newPDF = $folder.$_FILES['pdf']['name'];
    move_uploaded_file($_FILES['pdf']['tmp_name'], $newPDF);

    $query = "UPDATE free_pdf SET sent=1 WHERE id=:id";
    $stmt = $conn->prepare($query);
    $stmt->execute(['id'=>$id]);


    try{

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'desilondoo@gmail.com';
        $mail->Password = 'cegmkgrrvslgntts';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('desilondoo@gmail.com', 'CollegeMitra');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'College List Based On Your Percentile';
        $mail->Body = '<html>
        <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
          <style>
            .container {
              width: 600px;
              margin: 0 auto;
              font-family: Arial, sans-serif;
            }
            h1 {
              color: #00b0ff;
              text-align: center;
              margin: 40px 0;
            }
            p {
              color: #333;
              font-size: 16px;
              line-height: 1.5;
              margin: 30px 0;
            }
            .link {
              color: #00b0ff;
              text-decoration: none;
              border-bottom: 1px solid #00b0ff;
            }
            .cta {
              background-color: #00b0ff;
              color: #fff;
              font-size: 18px;
              padding: 10px 20px;
              border-radius: 5px;
              text-align: center;
              display: inline-block;
              margin: 30px 0;
              text-decoration: none;
            }
            .features {
              list-style: none;
              margin: 30px 0;
              padding: 0;
            }
            .features li {
              margin-bottom: 20px;
              display: flex;
              align-items: center;
            }
            .features li i {
              font-size: 24px;
              margin-right: 20px;
              color: #00b0ff;
            }
            .features li span {
              font-size: 16px;
              color: #333;
            }
          </style>
        </head>
        <body>
          <div class="container">
            <h1>Hii Aaditya</h1>
            <p>Thank you for using our service! If you feel any kind of difficulty in the counselling process, <a href="https://collegemitra.com" class="link">collegemitra</a> is always there to help with our tremendous and affordable premium service.</p>
            <a href="https://collegemitra.com/premium-service" class="cta">Upgrade to premium</a>
            <ul class="features">
              <li>
                <i class="fas fa-check-circle"></i>
                <span>Dedicated support team</span>
              </li>
              <li>
                <i class="fas fa-check-circle"></i>
                <span>Priority response times</span>
              </li>
              <li>
                <i class="fas fa-check-circle"></i>
                <span>Expert advice and guidance</span>
              </li>
              <li>
                <i class="fas fa-check-circle"></i>
                <span>Customized support plans</span>
              </li>
            </ul>
          </div>
        </body>
      </html>
      
        ';
        $mail->addAttachment($newPDF);
        $mail->SMTPDebug = 2;

        $mail->send();
        echo 'success We have sent you the reset link in your e-mail ID, please check your email!';
    }
    catch(Exception $e){
        echo 'Something went wrong, Please try again later!';
    }

        
    
}






}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}