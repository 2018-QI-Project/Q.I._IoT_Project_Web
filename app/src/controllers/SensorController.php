<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

include_once('database.php');

final class SensorController extends BaseController
{
    public function register(Request $request, Response $response, $args)
    {
    	$json = $request->getParsedBody();

        //Database Connection
    	$conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

    	if($json['client']=='app') {
    		$tokenApp = $json['tokenApp'];

    		$sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
    		$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);

    		if($row[0] > 0) {
    			$sql = "SELECT USER_ID FROM USER WHERE TOKEN_APP = '".$tokenApp."'";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);

    			$userID = $row["USER_ID"];


        		//Get Data From HTTP Body
    			$address = $json['address'];
    			$type = $json['type'];

    			$sql = "SELECT EXISTS(SELECT * FROM SENSOR WHERE ADDRESS = '".$address."' AND STATUS = 1)";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);

    			if($row[0]>0) {
    				$data = array(
    					'type'=>'error',
    					'value'=>'already registered sensor');
    				$encoded=json_encode($data);
    				header('Content-type: application/json');

    				echo $encoded;
    				exit();
    			}

                $sql = "SELECT EXISTS(SELECT * FROM SENSOR WHERE USER_ID = '".$userID."' AND TYPE = '".$type."' AND STATUS = 1)";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);

                if($row[0]>0) {
                    $data = array(
                        'type'=>'error',
                        'value'=>'you already have sensor');
                    $encoded=json_encode($data);
                    header('Content-type: application/json');

                    echo $encoded;
                    exit();
                }

    			$sql = "INSERT INTO SENSOR(USER_ID, ADDRESS, TYPE, STATUS) VALUES ('".$userID."','".$address."','".$type."', 1)";
    			$result = mysqli_query($conn, $sql);
    		}
    		else {
    			$data = array(
    				'type'=>'error',
    				'value'=>'not valid token');
    			$encoded=json_encode($data);
    			header('Content-type: application/json');

    			echo $encoded;
    			exit();
    		}
    	}
    	else if($json['client']=='web') {
    		$tokenWeb = $json['tokenWeb'];

    		$sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_WEB = '".$tokenWeb."')";
    		$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);


    		if($row[0] > 0) {
    			$sql = "SELECT USER_ID FROM USER WHERE TOKEN_WEB = '".$tokenWeb."'";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);
    			$userID = $row["USER_ID"];

            	//Get Data From HTTP Body
    			$address = $json['address'];
    			$type = $json['type'];
                
    			$sql = "SELECT EXISTS(SELECT * FROM SENSOR WHERE ADDRESS = '".$address."')";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);

    			if($row[0]>0) {
    				$data = array(
    					'type'=>'error',
    					'value'=>'already registered sensor');
    				$encoded=json_encode($data);
    				header('Content-type: application/json');

    				echo $encoded;
    				exit();
    			}

                $sql = "SELECT EXISTS(SELECT * FROM SENSOR WHERE USER_ID = '".$userID."' AND  TYPE = '".$type."' AND STATUS = 1)";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_array($result);

                if($row[0]>0) {
                    $data = array(
                        'type'=>'error',
                        'value'=>'you already have sensor');
                    $encoded=json_encode($data);
                    header('Content-type: application/json');

                    echo $encoded;
                    exit();
                }

    			$sql = "INSERT INTO SENSOR(USER_ID, ADDRESS, TYPE, STATUS) VALUES ('".$userID."','".$address."','".$type."', 1)";
    			$result = mysqli_query($conn, $sql);
    		}
    		else {
    			$data = array(
    				'type'=>'error',
    				'value'=>'not valid token');
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
    		'value'=>'sensor registered');
    	$encoded=json_encode($data);
    	header('Content-type: application/json');

    	echo $encoded;

    	mysqli_close($conn);
    	return $response;
    }

    public function deregister(Request $request, Response $response, $args)
    {
    	$conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

    	$json = $request->getParsedBody();

        //Get Data From HTTP Body
    	$address = $json['address'];
    	$type = $json['type'];

    	$sql = "SELECT EXISTS(SELECT * FROM SENSOR WHERE ADDRESS = '".$address."')";
    	$result = mysqli_query($conn, $sql);
    	$row = mysqli_fetch_array($result);

    	if($row[0]==0) {
    		$data = array(
    			'type'=>'error',
    			'value'=>'unregistered sensor');
    		$encoded=json_encode($data);
    		header('Content-type: application/json');

    		echo $encoded;
    		exit();
    	}        


    	if($json['client']=='app') {
    		$tokenApp = $json['tokenApp'];

    		$sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
    		$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);

    		if($row[0] > 0) {
    			$sql = "UPDATE SENSOR SET STATUS = 0 WHERE ADDRESS = '".$address."'";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);
    		}
    		else {
    			$data = array(
    				'type'=>'error',
    				'value'=>'not valid token');
    			$encoded=json_encode($data);
    			header('Content-type: application/json');

    			echo $encoded;
    			exit();
    		}
    	}
    	else if($json['client']=='web') {
    		$tokenWeb = $json['tokenWeb'];

    		$sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_WEB = '".$tokenWeb."')";
    		$result = mysqli_query($conn, $sql);
    		$row = mysqli_fetch_array($result);

    		if($row[0] > 0) {
    			$sql = "UPDATE SENSOR SET STATUS = 0 WHERE ADDRESS = '".$address."'";
    			$result = mysqli_query($conn, $sql);
    			$row = mysqli_fetch_array($result);
    		}
    		else {
    			$data = array(
    				'type'=>'error',
    				'value'=>'not valid token');
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
    		'value'=>'sensor deregistered');
    	$encoded=json_encode($data);
    	header('Content-type: application/json');

    	echo $encoded;

    	mysqli_close($conn);
    	return $response;
    }

    public function sensorlist(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_APP = '".$tokenApp."'";
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
        else if($json['client']=='web') {
            $tokenWeb = $json['tokenWeb'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_APP = '".$tokenWeb."'";
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

            $userID = $row["USER_ID"];

            $sql = "SELECT ADDRESS, TYPE FROM SENSOR WHERE USER_ID = '".$userID."' AND STATUS = 1";
            $result = mysqli_query($conn, $sql);

            if($result->num_rows==0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'There are not sensors registered now');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $type = array();
            $address = array();

            while($row = mysqli_fetch_array($result)) {
                array_push($type, $row["TYPE"]);
                array_push($address, $row["ADDRESS"]);
            }

            if("air"==$type[0]) {
                $data = array(
                    'type'=>'success',
                    'value'=>'sensor list',
                    'airAddress'=>$address[0],
                    'heartAddress'=>$address[1]);

                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }
            else if("heart"==$type[0]) {
                $data = array(
                    'type'=>'success',
                    'value'=>'sensor list',
                    'airAddress'=>$address[1],
                    'heartAddress'=>$address[0]);

                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
            }

            mysqli_close($conn);
            return $response;
    }
}
