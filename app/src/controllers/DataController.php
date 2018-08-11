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
        $coAqi = $json['coAqi'];
        $no2Aqi = $json['no2Aqi'];
        $so2Aqi = $json['so2Aqi'];
        $o3Aqi = $json['o3Aqi'];
        $pm25Aqi = $json['pm25Aqi'];
        $temperature = $json['temperature'];
        $latitude = $json['latitude'];
        $longitude = $json['longitude'];
        $date = $json['date'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'air' AND STATUS = 1";
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

        $sql = "INSERT INTO AIR(USER_ID, AIR_SENSOR_ID, DATE, TEMPERATURE, CO, NO2, SO2, O3, PM2_5, CO_AQI, NO2_AQI, SO2_AQI, O3_AQI, PM2_5_AQI, LOCATION_LAT, LOCATION_LON) VALUES ($userID, $sensorID, $date, $temperature, $co, $no2, $so2, $o3, $pm25, $coAqi, $no2Aqi, $so2Aqi, $o3Aqi, $pm25Aqi, $latitude, $longitude)";
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
        $date = $json['date'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE ADDRESS = '".$address."' AND TYPE = 'heart' AND STATUS = 1";
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

        $sql = "INSERT INTO HEART(USER_ID, HEART_SENSOR_ID, DATE, HEART_RATE, RR_INTERVAL) VALUES ($userID, $sensorID, $date, $heartRate, $rrInterval)";
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
        else if($json['client']=='web') {
            $tokenWeb = $json['tokenWeb'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_WEB = '".$tokenWeb."'";
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

            $userID = $row["USER_ID"];
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
        $allUser = $json['allUser'];

        if($allUser == "true")
        {
            $sql = "SELECT DATE, CO, NO2, SO2, O3, PM2_5, CO_AQI, NO2_AQI, SO2_AQI, O3_AQI, PM2_5_AQI, TEMPERATURE, LOCATION_LAT, LOCATION_LON FROM AIR WHERE AIR_SENSOR_ID IN (SELECT SENSOR_ID FROM SENSOR WHERE STATUS = 1 AND TYPE = 'air') AND DATE in (SELECT MAX(DATE) FROM AIR GROUP BY AIR_SENSOR_ID)";
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
                array_push($airData, $air=array('date'=>$row["DATE"], 'temperature'=>$row["TEMPERATURE"], 'co'=>$row["CO"], 'no2'=>$row["NO2"], 'so2'=>$row["SO2"], 'o3'=>$row["O3"], 'pm25'=>$row["PM2_5"], 'coAqi'=>$row["CO_AQI"], 'no2Aqi'=>$row["NO2_AQI"], 'so2Aqi'=>$row["SO2_AQI"], 'o3Aqi'=>$row["O3_AQI"], 'pm25Aqi'=>$row["PM2_5_AQI"], 'latitude'=>$row["LOCATION_LAT"], 'longitude'=>$row["LOCATION_LON"]));
            }

        }
        else if($allUser == "false")
        {
            $sql = "SELECT SENSOR_ID FROM SENSOR WHERE USER_ID = '".$userID."' AND TYPE = 'air' AND STATUS = 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);
            
            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'You have not air sensor');
                $encoded=json_encode($data);
                header('Content-type: application/json');

                echo $encoded;
                exit();
            }

            $sensorID = $row["SENSOR_ID"];

            $sql = "SELECT DATE, CO, NO2, SO2, O3, PM2_5, CO_AQI, NO2_AQI, SO2_AQI, O3_AQI, PM2_5_AQI, TEMPERATURE, LOCATION_LAT, LOCATION_LON FROM AIR WHERE AIR_SENSOR_ID = '".$sensorID."' AND DATE in (SELECT MAX(DATE) FROM AIR GROUP BY AIR_SENSOR_ID)";
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
            $coAqi = $json['coAqi'];
            $no2Aqi = $json['no2Aqi'];
            $so2Aqi = $json['so2Aqi'];
            $o3Aqi = $json['o3Aqi'];
            $pm25Aqi = $json['pm25Aqi'];
            $temperature = $json['temperature'];
            $latitude = $row["LOCATION_LAT"];
            $longitude = $row["LOCATION_LON"];

            $airData = array('date'=>$row["DATE"], 'temperature'=>$row["TEMPERATURE"], 'co'=>$row["CO"], 'no2'=>$row["NO2"], 'so2'=>$row["SO2"], 'o3'=>$row["O3"], 'pm25'=>$row["PM2_5"], 'coAqi'=>$row["CO_AQI"], 'no2Aqi'=>$row["NO2_AQI"], 'so2Aqi'=>$row["SO2_AQI"], 'o3Aqi'=>$row["O3_AQI"], 'pm25Aqi'=>$row["PM2_5_AQI"], 'latitude'=>$row["LOCATION_LAT"], 'longitude'=>$row["LOCATION_LON"]);
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
        
        $timestamp = time();

        $data = array(
            'type'=>'success',
            'value'=>'The most current air data',
            'timestamp'=>$timestamp,
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
        else if($json['client']=='web') {
            $tokenWeb = $json['tokenWeb'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_WEB = '".$tokenWeb."'";
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
        else if($allUser == "false") {
            $sql = "SELECT SENSOR_ID FROM SENSOR WHERE USER_ID = '".$userID."' AND TYPE = 'heart' AND STATUS = 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($result);

            if($result->num_rows == 0) {
                $data = array(
                    'type'=>'error',
                    'value'=>'You have not heart sensor');
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
        else if($json['client']=='web') {
            $tokenWeb = $json['tokenWeb'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_WEB = '".$tokenWeb."'";
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
        $day = $json['day'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE USER_ID = '".$userID."' AND TYPE = 'air' AND STATUS = 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'You have not air sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];

        $sql = "SELECT AVG(CO) AS CO, AVG(NO2) AS NO2, AVG(SO2) AS SO2, AVG(O3) AS O3, AVG(PM2_5) AS PM2_5, AVG(CO_AQI) AS CO_AQI, AVG(NO2_AQI) AS NO2_AQI, AVG(SO2_AQI) AS SO2_AQI, AVG(O3_AQI) AS O3_AQI, AVG(PM2_5_AQI) AS PM2_5_AQI, FROM_UNIXTIME(DATE, '%H') AS HOUR FROM AIR WHERE AIR_SENSOR_ID = $sensorID AND FROM_UNIXTIME(DATE, '%Y-%m-%d')='".$day."' GROUP BY FROM_UNIXTIME(DATE, '%H')";
        $result = mysqli_query($conn, $sql);


        $airData = array();

        while($row = mysqli_fetch_array($result)) {
                array_push($airData, $air=array("co"=>$row["CO"], "no2"=>$row["NO2"], "so2"=>$row["SO2"], "o3"=>$row["O3"], "pm25"=>$row["PM2_5"], "coAqi"=>$row["CO_AQI"], "no2Aqi"=>$row["NO2_AQI"], "so2Aqi"=>$row["SO2_AQI"], "o3Aqi"=>$row["O3_AQI"], "pm25Aqi"=>$row["PM2_5_AQI"], "hour"=>$row["HOUR"]));
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
        else if($json['client']=='web') {
            $tokenWeb = $json['tokenWeb'];

            $sql = "SELECT USER_ID FROM USER WHERE TOKEN_WEB = '".$tokenWeb."'";
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
        $day = $json['day'];

        $sql = "SELECT SENSOR_ID FROM SENSOR WHERE USER_ID = '".$userID."' AND TYPE = 'heart' AND STATUS = 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        if($result->num_rows == 0) {
            $data = array(
                'type'=>'error',
                'value'=>'You have not heart sensor');
            $encoded=json_encode($data);
            header('Content-type: application/json');

            echo $encoded;
            exit();
        }

        $sensorID = $row["SENSOR_ID"];

        $sql = "SELECT AVG(HEART_RATE) AS HEART_RATE, AVG(RR_INTERVAL) AS RR_INTERVAL, FROM_UNIXTIME(DATE, '%H') AS HOUR FROM HEART WHERE HEART_SENSOR_ID = $sensorID AND FROM_UNIXTIME(DATE, '%Y-%m-%d')='".$day."' GROUP BY FROM_UNIXTIME(DATE, '%H')";
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