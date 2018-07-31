<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class UCSDController extends BaseController
{
    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $this->flash->addMessage('info', 'Sample flash message');

        $this->view->render($response, 'home.twig');
        return $response;
    }

    public function catch(Request $request, Response $response, $args)
    {
        $this->logger->info("Testing Catch ...");

        $messages = $this->flash->getMessage('info');
/*
        try {
            $post = $this->em->find('App\Model\Post', intval($args['id']));
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
*/
        $this->view->render($response, 'poo.twig', ['post' => $post, 'flash' => $messages]);
        return $response;
    }
    
     public function sendMail(Request $request, Response $response, $args) {
       // $this->getApp()->contentType('text/html');
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'use-your-own-email-here@gmail.com';                 // SMTP username
            $mail->Password = 'your-password';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('mchiu0324@yahoo.com', 'Mike Chiu');
            $mail->addAddress('michiu@ucsd.edu', 'Mike Chiu');     // Add a recipient
//            $mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');

            //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
//        $this->render("index/mail.phtml");
        $this->view->render($response, 'home.twig');
        return $response;

    }    
    
    public function signUp(Request $request, Response $response, $args) {
        $this->view->render($response, 'basicform.twig');
        return $response;
    }

    public function handleSignUp(Request $request, Response $response, $args) {
    /*
        print_r($_POST);
        
        echo "<br /><br>\n";
        var_dump($_POST);
   */     
   $myarray = array("color"=>"Green", "size"=>"large");
    $this->view->render($response, 'process.twig', ['myarray'=>$myarray, 'fakevariable' =>1000, 'post' => $_POST, 'flash' => $messages]);
    return $response;

    }
}
