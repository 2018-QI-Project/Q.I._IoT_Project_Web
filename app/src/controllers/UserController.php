<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Firebase\JWT\JWT;

include_once('./vendor/autoload.php');
include_once('database.php');
include_once('secret.php');

define("NONCE_LENGTH", 50);


final class UserController extends BaseController
{
    public function signup(Request $request, Response $response, $args)
    {

        $receivedData = $request->getParsedBody();
        

        //Get Data From HTTP Body
        $email = $receivedData['email'];
        $password = $receivedData['password'];
        $name = $receivedData['name'];
        $age = $receivedData['age'];
        $gender = $receivedData['gender'];
        $respiratoryDisease = $receivedData['respiratoryDisease'];
        $cardiovascularDisease = $receivedData['cardiovascularDisease'];

        //DB Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if (!$conn) {
            echo "Connect failed:". $conn->connect_error;
            exit();
        }

        //Query
        $sql = "SELECT EXISTS(SELECT * FROM USER WHERE EMAIL = '".$email."')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        //Is duplicated?
        if($row[0] > 0) {
            $data = array(
                'type'=>'error',
                'value'=>'already existed');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
        }
        //Not duplicated
        else {
            //create Nonce
            $nonce = self::createNonce();

            //hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //Insert User Data
            $sql = "INSERT INTO USER(EMAIL, PASSWORD, NAME, AGE, GENDER, NONCE) VALUES ('".$email."','".$hashed_password."','".$name."',$age,'".$gender."','".$nonce."')";
            $result = mysqli_query($conn, $sql);

            $sql = "INSERT INTO DISEASE(USER_ID,RESPIRATORY,CARDIOVASCULAR) VALUES((SELECT USER_ID FROM USER WHERE EMAIL='".$email."'),$respiratoryDisease,$cardiovascularDisease)";
            $result = mysqli_query($conn, $sql);

            //send email
            self::sendVerificationMail($email, $nonce, $name);
        }

        mysqli_close($conn);
        return $response;
    }

    public function createNonce()
    {
        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

        srand((double)microtime()*1000000); 

        $random = '';

        for ($i = 0; $i < NONCE_LENGTH; $i++) {  
            $random .= $characters[rand() % strlen($characters)];  
        }
        
        return $random;
    }

    public function sendVerificationMail($email, $nonce, $name)
    {
       // $this->getApp()->contentType('text/html');
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'siyoungkim8994@gmail.com';                 // SMTP username
            $mail->Password = PW;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to


            //Recipients
            $mail->setFrom('siyoungkim8994@gmail.com', 'siyoung kim');
            $mail->addAddress($email, $name);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the Activation Mail From VOGLOG';
            $mail->Body    = 'http://'.SERVER_IP.'/accounts/approve/'.$nonce;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        //$this->render("index/mail.phtml");
        //$this->view->render($response, 'home.twig');
        return $response;

    }    

    public function approve(Request $request, Response $response, $args)
    {
        $nonce = $args['nonce'];

        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $sql = "SELECT EXISTS(SELECT * FROM USER WHERE NONCE = '".$nonce."')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($row[0] > 0) {
            $sql = "UPDATE USER SET NONCE = 'TRUE' WHERE NONCE = '".$nonce."'";
            $result = mysqli_query($conn, $sql);
        }

        $this->view->render($response, 'success.html');
        mysqli_close($conn);
        return $response;
    }

    public function authenticate(Request $request, Response $response, $args)
    {
        $receivedHeaderData = $request->getHeader('client');
        $receivedBodyData = $request->getParsedBody();
        

        //JSON PARSING
        $email = $receivedBodyData['email'];
        $password = $receivedBodyData['password'];

        //Database connect
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);
        
        //Check if email is existed
        $sql = "SELECT EXISTS(SELECT * FROM USER WHERE EMAIL = '".$email."')";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        
        if($row[0] > 0) {
            //Check if user is authorized
            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE EMAIL = '".$email."' AND NONCE = 'TRUE' )";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($row[0] > 0) {
                //Password correct?
                $sql = "SELECT PASSWORD FROM USER WHERE EMAIL = '".$email."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
                $hashed_password = $row["PASSWORD"];

                if(password_verify($password, $hashed_password)) {
                    //issue token
                    $token = self::createJWT($email);

                    if($receivedHeaderData[0]=="app") {
                       $data = array(
                           'token_app'=>$token);

                       $encoded=json_encode($data);

                       header('Content-type: application/json');

                       echo $encoded;

                       $sql = "UPDATE USER SET TOKEN_APP = '".$token."' WHERE EMAIL = '".$email."'";
                       $result = mysqli_query($conn, $sql);
                       $row = mysqli_fetch_array($result);
                    }
                    else if($receivedHeaderData[0]=="web") {
                       $data = array(
                           'token_web'=>$token);

                       $encoded=json_encode($data);

                       header('Content-type: application/json');

                       echo $encoded;

                       $sql = "UPDATE USER SET TOKEN_WEB = '".$token."' WHERE EMAIL = '".$email."'";
                       $result = mysqli_query($conn, $sql);
                       $row = mysqli_fetch_array($result);
                    }
                    else {
                        $data = array(
                           'type'=>'error',
                           'value'=>'not valid client, choose app or web');
                        $encoded=json_encode($data);
                        header('Content-type: application/json');

                        echo $encoded;
                    }
                }
                else {
                    $data = array(
                     'type'=>'error',
                     'value'=>'Wrong password');
                    $encoded=json_encode($data);
                    header('Content-type: application/json');

                    echo $encoded;
                }
            }
            else {
                $data = array(
                    'type'=>'error',
                    'value'=>'Unauthorized User');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
        }
        else {
            $data = array(
                'type'=>'error',
                'value'=>'Unregistered User');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
        }

        mysqli_close($conn);
        return $response;
    }


    public function validate(Request $request, Response $response, $args)
    {
        $receivedClientData = $request->getHeader('client');

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($receivedClientData[0]=='app') {
            $receivedTokenData = $request->getHeader('tokenApp');

            //Check if token is valid
            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$receivedTokenData[0]."')";
            echo $sql;
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            echo $row[0];
            if($row[0] > 0) {
                echo "success";
                $data = array(
                    'type'=>'success',
                    'value'=>'app signin success');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
            else {
                $data = array(
                    'type'=>'error',
                    'value'=>'not valid token');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
        }
        else if($receivedClientData[0]=='web'){
            $receivedTokenData = $request->getHeader('tokenWeb');

            //Check if token is valid
            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_WEB = '".$receivedTokenData[0]."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($row[0] > 0) {
                $data = array(
                    'type'=>'success',
                    'value'=>'web signin success');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
            else {
                $data = array(
                    'type'=>'error',
                    'value'=>'not valid token');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
        }
        else {
            $data = array(
                    'type'=>'error',
                    'value'=>'invalid client type');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
        }

        mysqli_close($conn);
        return $response;
    }

    public function createJWT($email)
    {

        $issuedAt = time();
        $notBefore = $issuedAt;
        $key = "voglogKey";

        $token = array(
            "iss" => SERVER_IP,
            "aud" => $email,
            "iat" => $issuedAt,
            "nbf" => $notBefore
        );


        $jwt = JWT::encode($token, $key);

        return $jwt;
    }

    public function resetPassword(Request $request, Response $response, $args)
    {
        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        $receivedData = $request->getParsedBody();
        
        //Get Data From HTTP Body
        $email = $receivedData['email'];
        
        $sql = "SELECT NAME FROM USER WHERE EMAIL = '".$email."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows>0) {
            $name = $row["NAME"];
            $newPassword = self::generateRandomPassword();
            $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

            $sql = "UPDATE USER SET PASSWORD = '".$hashed_password."' WHERE EMAIL = '".$email."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            self::sendNewPasswordMail($email, $newPassword, $name);
        }
        else {
            $data = array(
                    'type'=>'error',
                    'value'=>'Unregistered User');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;

                exit();
        }

        $data = array(
                    'type'=>'success',
                    'value'=>'Check you mail');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                
                exit();
        
        mysqli_close($conn);
        return $response;
    }

    public function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function sendNewPasswordMail($email, $newPassword, $name)
    {
       // $this->getApp()->contentType('text/html');
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'siyoungkim8994@gmail.com';                 // SMTP username
            $mail->Password = PW;                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to


            //Recipients
            $mail->setFrom('siyoungkim8994@gmail.com', 'siyoung kim');
            $mail->addAddress($email, $name);     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the New Password From VOGLOG';
            $mail->Body    = 'New password : '.$newPassword;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
        //$this->render("index/mail.phtml");
        //$this->view->render($response, 'home.twig');
        return $response;
    }

    public function changePassword(Request $request, Response $response, $args)
    {
        $receivedClientData = $request->getHeader('client');

        $receivedData = $request->getParsedBody();
        
        //Get Data From HTTP Body
        $currentPassword = $receivedData['currentPassword'];
        $newPassword = $receivedData['newPassword'];

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($receivedClientData[0]=='app') {
            $receivedTokenData = $request->getHeader('tokenApp');

            $sql = "SELECT EMAIL, PASSWORD FROM USER WHERE TOKEN_APP = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows==0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid tokenApp');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

        }
        else if($receivedClientData[0]=='web') {
            $receivedTokenData = $request->getHeader('tokenWeb');
            $sql = "SELECT EMAIL, PASSWORD FROM USER WHERE TOKEN_WEB = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows==0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid tokenWeb');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }
        }
        else {
            $data = array(
            'type'=>'error',
            'value'=>'invalid client type');
             $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $email = $row["EMAIL"];
        $dbPassword = $row["PASSWORD"];

        if(!password_verify($currentPassword, $dbPassword)) {
            $data = array(
            'type'=>'error',
            'value'=>'wrong password');
             $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE USER SET PASSWORD = '".$hashed_password."' WHERE EMAIL = '".$email."'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        echo "Password changed!";

        mysqli_close($conn);
        return $response;
    }

    public function IDcancellation(Request $request, Response $response, $args)
    {
        $receivedClientData = $request->getHeader('client');

        $receivedData = $request->getParsedBody();
        
        //Get Data From HTTP Body
        $receivedPassword = $receivedData['password'];

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);


        if($receivedClientData[0]=='app') {
            $receivedTokenData = $request->getHeader('tokenApp');

            $sql = "SELECT EMAIL, PASSWORD FROM USER WHERE TOKEN_APP = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows==0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid token');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }
        }
        else if($receivedClientData[0]=='web') {
            $receivedTokenData = $request->getHeader('tokenWeb');
            $sql = "SELECT EMAIL, PASSWORD FROM USER WHERE TOKEN_WEB = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows==0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid token');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }
        }
        else {
            $data = array(
            'type'=>'error',
            'value'=>'invalid client type');
             $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $email = $row["EMAIL"];
        $password = $row["PASSWORD"];

        if(password_verify($receivedPassword, $password)) {

            $sql = "DELETE FROM USER WHERE EMAIl = '".$email."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            echo "ID Cancellation!";
        }
        else {
            $data = array(
            'type'=>'error',
            'value'=>'wrong password');
             $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        mysqli_close($conn);
        return $response;
    }

     public function signout(Request $request, Response $response, $args)
    {
        $receivedClientData = $request->getHeader('client');

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($receivedClientData[0]=='app') {
            $receivedTokenData = $request->getHeader('tokenApp');

            $sql = "SELECT EMAIL FROM USER WHERE TOKEN_APP = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows!=0) {
                $email = $row["EMAIL"];
                $token = self::createNonce();

                $sql = "UPDATE USER SET TOKEN_APP = '".$token."' WHERE EMAIL = '".$email."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
            }
            else {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid tokenApp');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

        }
        else if($receivedClientData[0]=='web') {
            $receivedTokenData = $request->getHeader('tokenWeb');

            $sql = "SELECT EMAIL FROM USER WHERE TOKEN_WEB = '".$receivedTokenData[0]."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

             if($result->num_rows!=0) {
                $email = $row["EMAIL"];
                $token = self::createNonce();

                $sql = "UPDATE USER SET TOKEN_WEB = '".$token."' WHERE EMAIL = '".$email."'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);
            }
            else {
                $data = array(
                    'type'=>'error',
                    'value'=>'invalid tokenWeb');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }
        }
        else {
            $data = array(
            'type'=>'error',
            'value'=>'invalid client type');
             $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $data = array(
            'type'=>'success',
            'value'=>'sign out');
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;

        mysqli_close($conn);
        return $response;
    }

    /*
    public function BasicFunctionForm(Request $request, Response $response, $args)
    {
        $receivedClientData = $request->getHeader('client');

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($receivedClientData[0]=='app') {
            $receivedTokenData = $request->getHeader('tokenApp');
        }
        else if($receivedClientData[0]=='web') {
            $receivedTokenData = $request->getHeader('tokenWeb');
        }
        else {
            $data = array(
                    'type'=>'error',
                    'value'=>'invalid client type');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            mysqli_close($conn);
            return $response;
    }
    */
}