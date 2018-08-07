<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

include_once('database.php');

final class DataController extends BaseController
{
    public function AQInsert(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_APP = '".$tokenApp."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

        $userID = $row["USER_ID"];

        $address = $json['address'];
        $co = $json['co'];
        $no2 = $json['no2'];
        $so2 = $json['so2'];
        $o3 = $json['o3'];
        $pm25 = $json['pm25'];
        $latitude = $json['latitude'];
        $longitude = $json['longitude'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'air' ";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'not registered sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];
        $timestamp = time();

        $sql = "INSERT INTO AIR(USER_ID, AIR_SENSOR_ID, DATE, CO, NO2, SO2, O3, PM2_5, LOCATION_LAT, LOCATION_LON) VALUES ($userID, $sensorID, $timestamp, $co, $no2, $so2, $o3, $pm25, $latitude, $longitude)";
        $result = mysqli_query($conn, $sql);

        $data = array(
            'type'=>'success',
            'value'=>'recorded air data');
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;

        mysqli_close($conn);
        return $response;
    }

    public function HRInsert(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_APP = '".$tokenApp."'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

        $userID = $row["USER_ID"];

        $address = $json['address'];
        $heartRate = $json['heartRate'];
        $rrInterval = $json['rrInterval'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'heart'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'not registered sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];
        $timestamp = time();

        $sql = "INSERT INTO HEART(USER_ID, HEART_SENSOR_ID, DATE, HEART_RATE, RR_INTERVAL) VALUES ($userID, $sensorID, $timestamp, $heartRate, $rrInterval)";
        $result = mysqli_query($conn, $sql);

        $data = array(
            'type'=>'success',
            'value'=>'recorded heart data');
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;

        mysqli_close($conn);
        return $response;
    }

    public function getRealtimeAQ(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

            if($result->num_rows == 0) {
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

        $allUser = $json['allUser'];

        if($allUser == "true")
        {
            $sql = "SELECT DATE, CO, NO2, SO2, O3, PM2_5, LOCATION_LAT, LOCATION_LON FROM AIR WHERE AIR_SENSOR_ID IN (SELECT SENSOR_ID FROM SENSOR WHERE STATUS = 1 AND TYPE = 'air') AND DATE in (SELECT MAX(DATE) FROM AIR GROUP BY AIR_SENSOR_ID)";
            $result = mysqli_query($conn, $sql);

            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'nothing data');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $airData = array();

            while($row = mysqli_fetch_array($result)) {
                array_push($airData, $air=array('date'=>$row["DATE"], 'co'=>$row["CO"], 'no2'=>$row["NO2"], 'so2'=>$row["SO2"], 'o3'=>$row["O3"], 'pm25'=>$row["PM2_5"], 'latitude'=>$row["LOCATION_LAT"], 'longitude'=>$row["LOCATION_LON"]));
            }

        }
        else if($allUser == 'false')
        {
            $address = $json['address'];

            $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'air'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'not registered sensor');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $sensorID = $row["SENSOR_ID"];

            $sql = "SELECT DATE, CO, NO2, SO2, O3, PM2_5, LOCATION_LAT, LOCATION_LON FROM AIR WHERE AIR_SENSOR_ID = '".$sensorID."' AND DATE in (SELECT MAX(DATE) FROM AIR GROUP BY AIR_SENSOR_ID)";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);


            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'nothing data');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $date = $row["DATE"];
            $co = $row["CO"];
            $no2 = $row["NO2"];
            $so2 = $row["SO2"];
            $o3 = $row["O3"];
            $pm25 = $row["PM2_5"];
            $latitude = $row["LOCATION_LAT"];
            $longitude = $row["LOCATION_LON"];

            $airData = array('date'=>$date, 'co'=>$co, 'no2'=>$no2, 'so2'=>$so2, 'o3'=>$o3, 'pm25'=>$pm25, 'latitude'=>$latitude, 'longitude'=>$longitude);
        }
        else {
            $data = array(
                'type'=>'error',
                'value'=>'enter allUser tag');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }
        
        $data = array(
            'type'=>'success',
            'value'=>'The most current air data',
            'airData'=>$airData);
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;

        mysqli_close($conn);
        return $response;
    }

    public function getRealtimeHR(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

            if($result->num_rows == 0) {
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

        $allUser = $json['allUser'];

        if($allUser == "true") {
            $sql = "SELECT DATE, HEART_RATE, RR_INTERVAL FROM HEART WHERE HEART_SENSOR_ID IN (SELECT SENSOR_ID FROM SENSOR WHERE STATUS = 1 AND TYPE = 'heart') AND DATE in (SELECT MAX(DATE) FROM HEART GROUP BY HEART_SENSOR_ID)";
            $result = mysqli_query($conn, $sql);

            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'nothing data');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $heartData = array();

            while($row = mysqli_fetch_array($result)) {
                array_push($heartData, $heart=array('date'=>$row["DATE"], 'heartRate'=>$row["HEART_RATE"], 'rrInterval'=>$row["RR_INTERVAL"]));
            }
        }
        else if($alluser == "false") {
            $address = $json['address'];

            $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'heart'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'not registered sensor');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $sensorID = $row["SENSOR_ID"];

            $sql = "SELECT DATE, HEART_RATE, RR_INTERVAL FROM HEART WHERE HEART_SENSOR_ID = '".$sensorID."' AND DATE in (SELECT MAX(DATE) FROM HEART GROUP BY HEART_SENSOR_ID)";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);


            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'nothing data');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $date = $row["DATE"];
            $heartRate = $row["HEART_RATE"];
            $rrInterval = $row["RR_INTERVAL"];

            $heartData = array('date'=>$date, 'heartRate'=>$heartRate, 'rrInterval'=>$rrInterval);
        }
        else {
            $data = array(
                'type'=>'error',
                'value'=>'enter allUser tag');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $data = array(
            'type'=>'success',
            'value'=>'The most current heart data',
            'heartData'=>$heartData);
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;

        mysqli_close($conn);
        return $response;
    }

    public function getHistoricalAQ(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

            if($result->num_rows == 0) {
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

        $address = $json['address'];
        $day = $json['day'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'air'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'not registered sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];

        $sql = "SELECT AVG(CO) AS CO, AVG(NO2) AS NO2, AVG(SO2) AS SO2, AVG(O3) AS O3, AVG(PM2_5) AS PM2_5, FROM_UNIXTIME(DATE, '%H') AS HOUR FROM AIR WHERE FROM_UNIXTIME(DATE, '%Y-%m-%d')='".$day."' GROUP BY FROM_UNIXTIME(DATE, '%H')";
        $result = mysqli_query($conn, $sql);

        $airData = array();

        while($row = mysqli_fetch_array($result)) {
                array_push($airData, $air=array("co"=>$row["CO"], "no2"=>$row["NO2"], "so2"=>$row["SO2"], "o3"=>$row["O3"], "pm25"=>$row["PM2_5"], "hour"=>$row["HOUR"]));
            }

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'nothing data');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $data = array(
            'type'=>'success',
            'value'=>'The most current air data',
            'airData'=>$airData);
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;
        
        mysqli_close($conn);
        return $response;
    }

    public function getHistoricalHR(Request $request, Response $response, $args)
    {
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

            if($result->num_rows == 0) {
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

        $address = $json['address'];
        $day = $json['day'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'heart'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'not registered sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];

        $sql = "SELECT AVG(HEART_RATE) AS heartRate, AVG(RR_INTERVAL) AS rrInterval, FROM_UNIXTIME(DATE, '%H') AS HOUR FROM HEART WHERE FROM_UNIXTIME(DATE, '%Y-%m-%d')='".$day."' GROUP BY FROM_UNIXTIME(DATE, '%H')";
        $result = mysqli_query($conn, $sql);

        $heartData = array();
        
        while($row = mysqli_fetch_array($result)) {
                array_push($heartData, $air=array("heartRate"=>$row["HEART_RATE"], "rrInterval"=>$row["RR_INTERVAL"], "hour"=>$row["HOUR"]));
            }

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'nothing data');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $data = array(
            'type'=>'success',
            'value'=>'The most current heart data',
            'heartData'=>$heartData);
        $encoded=json_encode($data);
        header('Content-type: application/json');

        echo $encoded;
        
        mysqli_close($conn);
        return $response;
    }
}


/*
        $json = $request->getParsedBody();

        //Database Connection
        $conn = mysqli_connect(DATABASE_IP, DATABASE_USER, DATABASE_PASSWORD, DATABASE_DATABASE);

        if($json['client']=='app') {
            $tokenApp = $json['tokenApp'];

            $sql = "SELECT EXISTS(SELECT * FROM USER WHERE TOKEN_APP = '".$tokenApp."')";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
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

            if($result->num_rows == 0) {
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

        mysqli_close($conn);
        return $response;
*/