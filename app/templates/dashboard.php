<!doctype html>
<html lang="en">
<head>
    <title>VogLog_Main</title>
	<meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <?php include_once('database.php'); ?>
	
    <link rel="icon" type="image/png" href="images/icons/voglog.ico">
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <!--  Paper Dashboard core CSS    -->
    <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/themify-icons.css" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        //google.charts.setOnLoadCallback(drawChart);

        function drawChart(pickedDate) {
            var obj = new Object();
            obj.client = 'web';
            obj.tokenWeb = localStorage.getItem('tokenWeb');
            obj.day = pickedDate;

            var dataArray_co = new Array();
            var dataArray_no2 = new Array();
            var dataArray_so2 = new Array();
            var dataArray_o3 = new Array();
            var dataArray_pm25 = new Array();

            $.ajax({
                url:'http://<?php echo SERVER_IP ?>/data/getHistoricalAQ',
                dataType:'json',
                type:'POST',
                data:obj,
                success:function(result){
                    if(result['type']=="success") {
                        var airData = result.airData;
                        var i = 0;

                        while(i < 24)
                        {
                            if(airData[i]!=null) {
                                switch(airData[i].hour) {
                                    case "00" :
                                    dataArray_co[0] = airData[i].co;
                                    dataArray_no2[0] = airData[i].no2;
                                    dataArray_so2[0] = airData[i].so2;
                                    dataArray_o3[0] = airData[i].o3;
                                    dataArray_pm25[0] = airData[i].pm25;
                                    break;
                                    case "01" :
                                    dataArray_co[1] = airData[i].co;
                                    dataArray_no2[1] = airData[i].no2;
                                    dataArray_so2[1] = airData[i].so2;
                                    dataArray_o3[1] = airData[i].o3;
                                    dataArray_pm25[1] = airData[i].pm25;
                                    break;
                                    case "02" :
                                    dataArray_co[2] = airData[i].co;
                                    dataArray_no2[2] = airData[i].no2;
                                    dataArray_so2[2] = airData[i].so2;
                                    dataArray_o3[2] = airData[i].o3;
                                    dataArray_pm25[2] = airData[i].pm25;
                                    break;
                                    case "03" :
                                    dataArray_co[3] = airData[i].co;
                                    dataArray_no2[3] = airData[i].no2;
                                    dataArray_so2[3] = airData[i].so2;
                                    dataArray_o3[3] = airData[i].o3;
                                    dataArray_pm25[3] = airData[i].pm25;
                                    break;
                                    case "04" :
                                    dataArray_co[4] = airData[i].co;
                                    dataArray_no2[4] = airData[i].no2;
                                    dataArray_so2[4] = airData[i].so2;
                                    dataArray_o3[4] = airData[i].o3;
                                    dataArray_pm25[4] = airData[i].pm25;
                                    break;
                                    case "05" :
                                    dataArray_co[5] = airData[i].co;
                                    dataArray_no2[5] = airData[i].no2;
                                    dataArray_so2[5] = airData[i].so2;
                                    dataArray_o3[5] = airData[i].o3;
                                    dataArray_pm25[5] = airData[i].pm25;
                                    break;
                                    case "06" :
                                    dataArray_co[6] = airData[i].co;
                                    dataArray_no2[6] = airData[i].no2;
                                    dataArray_so2[6] = airData[i].so2;
                                    dataArray_o3[6] = airData[i].o3;
                                    dataArray_pm25[6] = airData[i].pm25;
                                    break;
                                    case "07" :
                                    dataArray_co[7] = airData[i].co;
                                    dataArray_no2[7] = airData[i].no2;
                                    dataArray_so2[7] = airData[i].so2;
                                    dataArray_o3[7] = airData[i].o3;
                                    dataArray_pm25[7] = airData[i].pm25;
                                    break;
                                    case "08" :
                                    dataArray_co[8] = airData[i].co;
                                    dataArray_no2[8] = airData[i].no2;
                                    dataArray_so2[8] = airData[i].so2;
                                    dataArray_o3[8] = airData[i].o3;
                                    dataArray_pm25[8] = airData[i].pm25;
                                    break;
                                    case "09" :
                                    dataArray_co[9] = airData[i].co;
                                    dataArray_no2[9] = airData[i].no2;
                                    dataArray_so2[9] = airData[i].so2;
                                    dataArray_o3[9] = airData[i].o3;
                                    dataArray_pm25[9] = airData[i].pm25;
                                    break;
                                    case "10" :
                                    dataArray_co[10] = airData[i].co;
                                    dataArray_no2[10] = airData[i].no2;
                                    dataArray_so2[10] = airData[i].so2;
                                    dataArray_o3[10] = airData[i].o3;
                                    dataArray_pm25[10] = airData[i].pm25;
                                    break;
                                    case "11" :
                                    dataArray_co[11] = airData[i].co;
                                    dataArray_no2[11] = airData[i].no2;
                                    dataArray_so2[11] = airData[i].so2;
                                    dataArray_o3[11] = airData[i].o3;
                                    dataArray_pm25[11] = airData[i].pm25;
                                    break;
                                    case "12" :
                                    dataArray_co[12] = airData[i].co;
                                    dataArray_no2[12] = airData[i].no2;
                                    dataArray_so2[12] = airData[i].so2;
                                    dataArray_o3[12] = airData[i].o3;
                                    dataArray_pm25[12] = airData[i].pm25;
                                    break;
                                    case "13" :
                                    dataArray_co[13] = airData[i].co;
                                    dataArray_no2[13] = airData[i].no2;
                                    dataArray_so2[13] = airData[i].so2;
                                    dataArray_o3[13] = airData[i].o3;
                                    dataArray_pm25[13] = airData[i].pm25;
                                    break;
                                    case "14" :
                                    dataArray_co[14] = airData[i].co;
                                    dataArray_no2[14] = airData[i].no2;
                                    dataArray_so2[14] = airData[i].so2;
                                    dataArray_o3[14] = airData[i].o3;
                                    dataArray_pm25[14] = airData[i].pm25;
                                    break;
                                    case "15" :
                                    dataArray_co[15] = airData[i].co;
                                    dataArray_no2[15] = airData[i].no2;
                                    dataArray_so2[15] = airData[i].so2;
                                    dataArray_o3[15] = airData[i].o3;
                                    dataArray_pm25[15] = airData[i].pm25;
                                    break;
                                    case "16" :
                                    dataArray_co[16] = airData[i].co;
                                    dataArray_no2[16] = airData[i].no2;
                                    dataArray_so2[16] = airData[i].so2;
                                    dataArray_o3[16] = airData[i].o3;
                                    dataArray_pm25[16] = airData[i].pm25;
                                    break;
                                    case "17" :
                                    dataArray_co[17] = airData[i].co;
                                    dataArray_no2[17] = airData[i].no2;
                                    dataArray_so2[17] = airData[i].so2;
                                    dataArray_o3[17] = airData[i].o3;
                                    dataArray_pm25[17] = airData[i].pm25;
                                    break;
                                    case "18" :
                                    dataArray_co[18] = airData[i].co;
                                    dataArray_no2[18] = airData[i].no2;
                                    dataArray_so2[18] = airData[i].so2;
                                    dataArray_o3[18] = airData[i].o3;
                                    dataArray_pm25[18] = airData[i].pm25;
                                    break;
                                    case "19" :
                                    dataArray_co[19] = airData[i].co;
                                    dataArray_no2[19] = airData[i].no2;
                                    dataArray_so2[19] = airData[i].so2;
                                    dataArray_o3[19] = airData[i].o3;
                                    dataArray_pm25[19] = airData[i].pm25;
                                    break;
                                    case "20" :
                                    dataArray_co[20] = airData[i].co;
                                    dataArray_no2[20] = airData[i].no2;
                                    dataArray_so2[20] = airData[i].so2;
                                    dataArray_o3[20] = airData[i].o3;
                                    dataArray_pm25[20] = airData[i].pm25;
                                    break;
                                    case "21" :
                                    dataArray_co[21] = airData[i].co;
                                    dataArray_no2[21] = airData[i].no2;
                                    dataArray_so2[21] = airData[i].so2;
                                    dataArray_o3[21] = airData[i].o3;
                                    dataArray_pm25[21] = airData[i].pm25;
                                    break;
                                    case "22" :
                                    dataArray_co[22] = airData[i].co;
                                    dataArray_no2[22] = airData[i].no2;
                                    dataArray_so2[22] = airData[i].so2;
                                    dataArray_o3[22] = airData[i].o3;
                                    dataArray_pm25[22] = airData[i].pm25;
                                    break;
                                    case "23" :
                                    dataArray_co[23] = airData[i].co;
                                    dataArray_no2[23] = airData[i].no2;
                                    dataArray_so2[23] = airData[i].so2;
                                    dataArray_o3[23] = airData[i].o3;
                                    dataArray_pm25[23] = airData[i].pm25;
                                    break;
                                }
                            }
                            else {
                                break;
                            }
                            i++;
                        }

                        var data_co = google.visualization.arrayToDataTable([
                            ['HOUR', 'CO'],
                            ['00',  Number(dataArray_co[0])],
                            ['01',  Number(dataArray_co[1])],
                            ['02',  Number(dataArray_co[2])],
                            ['03',  Number(dataArray_co[3])],
                            ['04',  Number(dataArray_co[4])],
                            ['05',  Number(dataArray_co[5])],
                            ['06',  Number(dataArray_co[6])],
                            ['07',  Number(dataArray_co[7])],
                            ['08',  Number(dataArray_co[8])],
                            ['09',  Number(dataArray_co[9])],
                            ['10',  Number(dataArray_co[10])],
                            ['11',  Number(dataArray_co[11])],
                            ['12',  Number(dataArray_co[12])],
                            ['13',  Number(dataArray_co[13])],
                            ['14',  Number(dataArray_co[14])],
                            ['15',  Number(dataArray_co[15])],
                            ['16',  Number(dataArray_co[16])],
                            ['17',  Number(dataArray_co[17])],
                            ['18',  Number(dataArray_co[18])],
                            ['19',  Number(dataArray_co[19])],
                            ['20',  Number(dataArray_co[20])],
                            ['21',  Number(dataArray_co[21])],
                            ['22',  Number(dataArray_co[22])],
                            ['23',  Number(dataArray_co[23])]
                            ]);

                        var data_no2 = google.visualization.arrayToDataTable([
                            ['HOUR', 'NO2'],
                            ['00',  Number(dataArray_no2[0])],
                            ['01',  Number(dataArray_no2[1])],
                            ['02',  Number(dataArray_no2[2])],
                            ['03',  Number(dataArray_no2[3])],
                            ['04',  Number(dataArray_no2[4])],
                            ['05',  Number(dataArray_no2[5])],
                            ['06',  Number(dataArray_no2[6])],
                            ['07',  Number(dataArray_no2[7])],
                            ['08',  Number(dataArray_no2[8])],
                            ['09',  Number(dataArray_no2[9])],
                            ['10',  Number(dataArray_no2[10])],
                            ['11',  Number(dataArray_no2[11])],
                            ['12',  Number(dataArray_no2[12])],
                            ['13',  Number(dataArray_no2[13])],
                            ['14',  Number(dataArray_no2[14])],
                            ['15',  Number(dataArray_no2[15])],
                            ['16',  Number(dataArray_no2[16])],
                            ['17',  Number(dataArray_no2[17])],
                            ['18',  Number(dataArray_no2[18])],
                            ['19',  Number(dataArray_no2[19])],
                            ['20',  Number(dataArray_no2[20])],
                            ['21',  Number(dataArray_no2[21])],
                            ['22',  Number(dataArray_no2[22])],
                            ['23',  Number(dataArray_no2[23])]
                            ]);

                        var data_so2 = google.visualization.arrayToDataTable([
                            ['HOUR', 'SO2'],
                            ['00',  Number(dataArray_so2[0])],
                            ['01',  Number(dataArray_so2[1])],
                            ['02',  Number(dataArray_so2[2])],
                            ['03',  Number(dataArray_so2[3])],
                            ['04',  Number(dataArray_so2[4])],
                            ['05',  Number(dataArray_so2[5])],
                            ['06',  Number(dataArray_so2[6])],
                            ['07',  Number(dataArray_so2[7])],
                            ['08',  Number(dataArray_so2[8])],
                            ['09',  Number(dataArray_so2[9])],
                            ['10',  Number(dataArray_so2[10])],
                            ['11',  Number(dataArray_so2[11])],
                            ['12',  Number(dataArray_so2[12])],
                            ['13',  Number(dataArray_so2[13])],
                            ['14',  Number(dataArray_so2[14])],
                            ['15',  Number(dataArray_so2[15])],
                            ['16',  Number(dataArray_so2[16])],
                            ['17',  Number(dataArray_so2[17])],
                            ['18',  Number(dataArray_so2[18])],
                            ['19',  Number(dataArray_so2[19])],
                            ['20',  Number(dataArray_so2[20])],
                            ['21',  Number(dataArray_so2[21])],
                            ['22',  Number(dataArray_so2[22])],
                            ['23',  Number(dataArray_so2[23])]
                            ]);

                        var data_o3 = google.visualization.arrayToDataTable([
                            ['HOUR', 'O3'],
                            ['00',  Number(dataArray_o3[0])],
                            ['01',  Number(dataArray_o3[1])],
                            ['02',  Number(dataArray_o3[2])],
                            ['03',  Number(dataArray_o3[3])],
                            ['04',  Number(dataArray_o3[4])],
                            ['05',  Number(dataArray_o3[5])],
                            ['06',  Number(dataArray_o3[6])],
                            ['07',  Number(dataArray_o3[7])],
                            ['08',  Number(dataArray_o3[8])],
                            ['09',  Number(dataArray_o3[9])],
                            ['10',  Number(dataArray_o3[10])],
                            ['11',  Number(dataArray_o3[11])],
                            ['12',  Number(dataArray_o3[12])],
                            ['13',  Number(dataArray_o3[13])],
                            ['14',  Number(dataArray_o3[14])],
                            ['15',  Number(dataArray_o3[15])],
                            ['16',  Number(dataArray_o3[16])],
                            ['17',  Number(dataArray_o3[17])],
                            ['18',  Number(dataArray_o3[18])],
                            ['19',  Number(dataArray_o3[19])],
                            ['20',  Number(dataArray_o3[20])],
                            ['21',  Number(dataArray_o3[21])],
                            ['22',  Number(dataArray_o3[22])],
                            ['23',  Number(dataArray_o3[23])]
                            ]);

                        var data_pm25 = google.visualization.arrayToDataTable([
                            ['HOUR', 'PM2.5'],
                            ['00',  Number(dataArray_pm25[0])],
                            ['01',  Number(dataArray_pm25[1])],
                            ['02',  Number(dataArray_pm25[2])],
                            ['03',  Number(dataArray_pm25[3])],
                            ['04',  Number(dataArray_pm25[4])],
                            ['05',  Number(dataArray_pm25[5])],
                            ['06',  Number(dataArray_pm25[6])],
                            ['07',  Number(dataArray_pm25[7])],
                            ['08',  Number(dataArray_pm25[8])],
                            ['09',  Number(dataArray_pm25[9])],
                            ['10',  Number(dataArray_pm25[10])],
                            ['11',  Number(dataArray_pm25[11])],
                            ['12',  Number(dataArray_pm25[12])],
                            ['13',  Number(dataArray_pm25[13])],
                            ['14',  Number(dataArray_pm25[14])],
                            ['15',  Number(dataArray_pm25[15])],
                            ['16',  Number(dataArray_pm25[16])],
                            ['17',  Number(dataArray_pm25[17])],
                            ['18',  Number(dataArray_pm25[18])],
                            ['19',  Number(dataArray_pm25[19])],
                            ['20',  Number(dataArray_pm25[20])],
                            ['21',  Number(dataArray_pm25[21])],
                            ['22',  Number(dataArray_pm25[22])],
                            ['23',  Number(dataArray_pm25[23])]
                            ]);

                        var options_co = {
                            title: 'CO',
                            curveType: 'none',
                            legend: { position: 'bottom' },
                            series: {
                                0: { color: '#FF0000' }
                            },
                            vAxis: {title:'ppm', viewWindow: {min: 0}},
                            hAxis: {title:'hour'}
                        };

                        var options_no2 = {
                            title: 'NO2',
                            curveType: 'none',
                            legend: { position: 'bottom' },
                            series: {
                                0: { color: '#FF9900' }
                            },
                            vAxis: {title:'ppb', viewWindow: {min: 0}},
                            hAxis: {title:'hour'}
                        };

                        var options_so2 = {
                            title: 'SO2',
                            curveType: 'none',
                            legend: { position: 'bottom' },
                            series: {
                                0: { color: '#0033FF' }
                            },
                            vAxis: {title:'ppb', viewWindow: {min: 0}},
                            hAxis: {title:'hour'}
                        };

                        var options_o3 = {
                            title: 'O3',
                            curveType: 'none',
                            legend: { position: 'bottom' },
                            series: {
                                0: { color: '#006633' }
                            },
                            vAxis: {title:'ppb', viewWindow: {min: 0}},
                            hAxis: {title:'hour'}
                        };

                        var options_pm25 = {
                            title: 'PM2.5',
                            curveType: 'none',
                            legend: { position: 'bottom' },
                            series: {
                                0: { color: '#FFCC00' }
                            },
                            vAxis: {title:'µg/m3', viewWindow: {min: 0}},
                            hAxis: {title:'hour'}
                        };

                        var chart_co = new google.visualization.LineChart(document.getElementById('line_chart_co'));
                        var chart_no2 = new google.visualization.LineChart(document.getElementById('line_chart_no2'));
                        var chart_so2 = new google.visualization.LineChart(document.getElementById('line_chart_so2'));
                        var chart_o3 = new google.visualization.LineChart(document.getElementById('line_chart_o3'));
                        var chart_pm25 = new google.visualization.LineChart(document.getElementById('line_chart_pm25'));

                        chart_co.draw(data_co, options_co);
                        chart_no2.draw(data_no2, options_no2);
                        chart_so2.draw(data_so2, options_so2);
                        chart_o3.draw(data_o3, options_o3);
                        chart_pm25.draw(data_pm25, options_pm25);
                    }
                    else {
                        alert('Nothing Data');
                    }
                }
            });
        }
    </script>
    <script type="text/javascript">
        window.onload = function realtimeAQ() {
            var obj = new Object();
            obj.client = 'web';
            obj.tokenWeb = localStorage.getItem('tokenWeb');
            obj.allUser = 'false';

        $.ajax({
                    url:'http://<?php echo SERVER_IP ?>/data/getRealtimeAQ',
                    dataType:'json',
                    type:'POST',
                    data:obj,
                    success:function(result){
                        if(result['type']=="success"){
                            var airData = result.airData;

                            var co = airData.co;
                            var no2 = airData.no2;
                            var so2 = airData.so2;
                            var o3 = airData.o3;
                            var pm25 = airData.pm25;
                            var coAqi = airData.coAqi;
                            var no2Aqi = airData.no2Aqi;
                            var so2Aqi = airData.so2Aqi;
                            var o3Aqi = airData.o3Aqi;
                            var pm25Aqi = airData.pm25Aqi;
                            var temperature = airData.temperature;
                            var date = new Date(airData.date*1000);
                            var latitude = airData.latitude;
                            var longitude = airData.longitude;

                            var year = date.getFullYear();
                            var month = date.getMonth()+1;
                            month = "0" + month;
                            var day = "0" + date.getDate();
                            var hours = "0" + date.getHours();
                            var minutes = "0" + date.getMinutes();
                            var seconds = "0" + date.getSeconds();

                            var formattedTime = year + "-" + month.substr(-2) + "-" + day.substr(-2) + " " + hours.substr(-2) + ":" + minutes.substr(-2) + ":" + seconds.substr(-2);


                            $('#co').html(Math.round(co));
                            $('#no2').html(Math.round(no2));
                            $('#so2').html(Math.round(so2));
                            $('#o3').html(Math.round(o3));
                            $('#pm25').html(Math.round(pm25));
                            $('#temperature').html(Math.round(temperature));
                            $('#air_date').html(formattedTime);
                            $('#latitude').html(latitude);
                            $('#longitude').html(longitude);

                            if(0<=coAqi && coAqi<=50) {
                                document.getElementById('div_co').classList.toggle('icon-good');
                            }
                            else if(51<=coAqi && coAqi<=100) {
                                document.getElementById('div_co').classList.toggle('icon-moderate');
                            }
                            else if(101<=coAqi && coAqi<=150) {
                                document.getElementById('div_co').classList.toggle('icon-sensitive');
                            }
                            else if(151<=coAqi && coAqi<=200) {
                                document.getElementById('div_co').classList.toggle('icon-unhealthy');
                            }
                            else if(201<=coAqi && coAqi<=300) {
                                document.getElementById('div_co').classList.toggle('icon-veryunhealthy');
                            }
                            else {
                                document.getElementById('div_co').classList.toggle('icon-hazardous');
                            }


                            if(0<=no2Aqi && no2Aqi<=50) {
                                document.getElementById('div_no2').classList.toggle('icon-good');
                            }
                            else if(51<=no2Aqi && no2Aqi<=100) {
                                document.getElementById('div_no2').classList.toggle('icon-moderate');
                            }
                            else if(101<=no2Aqi && no2Aqi<=150) {
                                document.getElementById('div_no2').classList.toggle('icon-sensitive');
                            }
                            else if(151<=no2Aqi && no2Aqi<=200) {
                                document.getElementById('div_no2').classList.toggle('icon-unhealthy');
                            }
                            else if(201<=no2Aqi && no2Aqi<=300) {
                                document.getElementById('div_no2').classList.toggle('icon-veryunhealthy');
                            }
                            else {
                                document.getElementById('div_no2').classList.toggle('icon-hazardous');
                            }


                            if(0<=so2Aqi && so2Aqi<=50) {
                                document.getElementById('div_so2').classList.toggle('icon-good');
                            }
                            else if(51<=so2Aqi && so2Aqi<=100) {
                                document.getElementById('div_so2').classList.toggle('icon-moderate');
                            }
                            else if(101<=so2Aqi && so2Aqi<=150) {
                                document.getElementById('div_so2').classList.toggle('icon-sensitive');
                            }
                            else if(151<=so2Aqi && so2Aqi<=200) {
                                document.getElementById('div_so2').classList.toggle('icon-unhealthy');
                            }
                            else if(201<=so2Aqi && so2Aqi<=300) {
                                document.getElementById('div_so2').classList.toggle('icon-veryunhealthy');
                            }
                            else {
                                document.getElementById('div_so2').classList.toggle('icon-hazardous');
                            }


                            if(0<=o3Aqi && o3Aqi<=50) {
                                document.getElementById('div_o3').classList.toggle('icon-good');
                            }
                            else if(51<=o3Aqi && o3Aqi<=100) {
                                document.getElementById('div_o3').classList.toggle('icon-moderate');
                            }
                            else if(101<=o3Aqi && o3Aqi<=150) {
                                document.getElementById('div_o3').classList.toggle('icon-sensitive');
                            }
                            else if(151<=o3Aqi && o3Aqi<=200) {
                                document.getElementById('div_o3').classList.toggle('icon-unhealthy');
                            }
                            else if(201<=o3Aqi && o3Aqi<=300) {
                                document.getElementById('div_o3').classList.toggle('icon-veryunhealthy');
                            }
                            else {
                                document.getElementById('div_o3').classList.toggle('icon-hazardous');
                            }


                            if(0<=pm25Aqi && pm25Aqi<=50) {
                                document.getElementById('div_pm25').classList.toggle('icon-good');
                            }
                            else if(51<=pm25Aqi && pm25Aqi<=100) {
                                document.getElementById('div_pm25').classList.toggle('icon-moderate');
                            }
                            else if(101<=pm25Aqi && pm25Aqi<=150) {
                                document.getElementById('div_pm25').classList.toggle('icon-sensitive');
                            }
                            else if(151<=pm25Aqi && pm25Aqi<=200) {
                                document.getElementById('div_pm25').classList.toggle('icon-unhealthy');
                            }
                            else if(201<=pm25Aqi && pm25Aqi<=300) {
                                document.getElementById('div_pm25').classList.toggle('icon-veryunhealthy');
                            }
                            else {
                                document.getElementById('div_pm25').classList.toggle('icon-hazardous');
                            }


                        }
                    }
                });
        realtimeHR();
        }

        function realtimeHR() {
            var obj = new Object();
            obj.client = 'web';
            obj.tokenWeb = localStorage.getItem('tokenWeb');
            obj.allUser = 'false';

            $.ajax({
                    url:'http://<?php echo SERVER_IP ?>/data/getRealtimeHR',
                    dataType:'json',
                    type:'POST',
                    data:obj,
                    success:function(result){
                        if(result['type']=="success"){
                            var heartData = result.heartData;

                            var date = new Date(heartData.date*1000);
                            var heartRate = heartData.heartRate;

                            var year = date.getFullYear();
                            var month = date.getMonth()+1;
                            month = "0" + month;
                            var day = "0" + date.getDate();
                            var hours = "0" + date.getHours();
                            var minutes = "0" + date.getMinutes();
                            var seconds = "0" + date.getSeconds();

                            var formattedTime = year + "-" + month.substr(-2) + "-" + day.substr(-2) + " " + hours.substr(-2) + ":" + minutes.substr(-2) + ":" + seconds.substr(-2);

                            $('#heart_date').html(formattedTime);
                            $('#heartRate').html(heartRate);
                        }
                    }
                });
        }
    </script>
</head>
<body>

    <div class="wrapper">
        <!-- Left Navigation -->
        <div class="sidebar" data-background-color="white" data-active-color="success">
            <!-- Left Top VogLog -->
            <div class="sidebar-wrapper">
                <div class="logo" style="font-size:24px;text-align:center"> 
                    <span>VogLog</span>
                </div>

                <!-- Navigation Menu -->
                <ul class="nav">
                    <!-- Realtime Data -->
                    <li class="active">
                        <a href="/dashboard">
                            <i class="ti-bar-chart-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Maps -->
                    <li>
                        <a href="/maps">
                            <i class="ti-map"></i>
                            <p>Maps</p>
                        </a>
                    </li>

                    <!-- Chart
                    <li>
                        <a href="user.html">
                            <i class="ti-user"></i>
                            <p>User Profile</p>
                        </a>
                    </li>
                    

                    <li>
                        <a href="table.html">
                            <i class="ti-view-list-alt"></i>
                            <p>Table List</p>
                        </a>
                    </li>
                    <li>
                        <a href="typography.html">
                            <i class="ti-text"></i>
                            <p>Typography</p>
                        </a>
                    </li>
                    <li>
                        <a href="icons.html">
                            <i class="ti-pencil-alt2"></i>
                            <p>Icons</p>
                        </a>
                    </li>

                    <li>
                        <a href="notifications.html">
                            <i class="ti-bell"></i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
        </div>

        <!-- Main Panel -->
        <div class="main-panel">
            <!-- Top Right Panel -->
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <!--<button type="button" class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar bar1"></span>
                            <span class="icon-bar bar2"></span>
                            <span class="icon-bar bar3"></span>
                        </button>-->
                        <a class="navbar-brand">Dashboard</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <!--<li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-panel"></i>
                                    <p>Stats</p>
                                </a>
                            </li>-->

                            <!-- My Account Dropdown -->
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="ti-settings"></i>
                                    <p class="myaccount"></p>
                                    <p>My Account</p>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:requestsignout()">Sign Out</a></li>
                                    <li><a href="/changepassword">Change Password</a></li>
                                    <li><a href="/idcancellation">Delete Account</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Content Panel -->
            <div class="content">
                <div class="container-fluid">

                    <div style="font-size:28px">Real-time Air Quality and Heart-Related Data</div><br><br>
                    <!-- Real time Air Quality and Heart-Related Data -->
                    <div class="row">
                        <!-- AQI Index -->
                        <div>
                            <span style="font-size:20px">&nbsp;&nbsp;&nbsp; ▶ AQI Index</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="images/aqi.png" width="1073" height="60">
                        </div><br>
                        <!-- CO -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div id="div_co" class="icon-big icon-info text-center">
                                                <i class="ti-cloud"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>CO</p>
                                                <span id="co">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> ppm
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- NO2 -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div id="div_no2" class="icon-big icon-info text-center">
                                                <i class="ti-cloud"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>NO2</p>
                                                <span id="no2">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> ppb
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- SO2 -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div id="div_so2" class="icon-big icon-info text-center">
                                                <i class="ti-cloud"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>SO2</p>
                                                <span id="so2">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> ppb
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- O3 -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div id="div_o3" class="icon-big icon-info text-center">
                                                <i class="ti-cloud"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>O3</p>
                                                <span id= "o3">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> ppb
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PM2.5 -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div id="div_pm25" class="icon-big icon-info text-center">
                                                <i class="ti-cloud"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>PM2.5</p>
                                                <span id = "pm25">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> µg/m3
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AQI -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-heart text-center">
                                                <i class="ti-ruler"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>Temperature</p>
                                                <span id="temperature">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> ˚F
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lat/Lng -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-success text-center">
                                                <i class="ti-location-pin"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p></p>
                                                <p>Lat: <span id="latitude">N/A</span></p>
                                                <p>Lng: <span id="longitude">N/A</span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i> 
                                            <i>Date: <span id="air_date"></span></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Heart Rate -->
                        <div class="col-lg-3 col-sm-6">
                            <div class="card">
                                <div class="content">
                                    <div class="row">
                                        <!-- ICON -->
                                        <div class="col-xs-5">
                                            <div class="icon-big icon-danger text-center">
                                                <i class="ti-heart"></i>
                                            </div>
                                        </div>

                                        <!-- Sensor Name -->
                                        <div class="col-xs-7">
                                            <div class="numbers">
                                                <p>Heart Rate</p>
                                               <span id = "heartRate">N/A</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Unit -->
                                    <div class="footer" style="text-align:right">
                                        <hr />
                                        <div class="stats">
                                            <i class="ti-control-forward"></i>
                                            <i>Date: <span id = "heart_date"></span></i>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><br><br>


                    <div style="font-size:28px">Historical Air Quality Data Charts</div><br>
                    <!-- Historical Air Quality Data -->
                    <div class="row">
                        <!-- Date Picker -->
                        <div>
                            <i class="ti-search"> </i>  <input id="datepicker" type="date" onchange="getDate()">
                        </div>

                        <!-- Get Chart Data -->
                        <script type="text/javascript">
                            function getDate() {
                                var pickedDate = $('#datepicker').val();
                                drawChart(pickedDate);
                            }
                        </script>

                        <p></p>
                        <div id="line_chart_co" style="width: 1200px; height: 500px"></div>
                        <p></p>
                        <div id="line_chart_no2" style="width: 1200px; height: 500px"></div>
                        <p></p>
                        <div id="line_chart_so2" style="width: 1200px; height: 500px"></div>
                        <p></p>
                        <div id="line_chart_o3" style="width: 1200px; height: 500px"></div>
                        <p></p>
                        <div id="line_chart_pm25" style="width: 1200px; height: 500px"></div>

                        <!-- 여기 아래 주석 부분 지워도 됩니다!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
                        <!-- <div class="col-md-12">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">Users Behavior</h4>
                                        <p class="category">24 Hours performance</p>
                                    </div>
                                    <div class="content">
                                        <div id="chartHours" class="ct-chart"></div>
                                        <div class="footer">
                                            <div class="chart-legend">
                                                <i class="fa fa-circle text-info"></i> Open
                                                <i class="fa fa-circle text-danger"></i> Click
                                                <i class="fa fa-circle text-warning"></i> Click Second Time
                                            </div>
                                            <hr>
                                            <div class="stats">
                                                <i class="ti-reload"></i> Updated 3 minutes ago
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                    </div> <!-- Historical Air Quality Data End -->

                </div> 
            </div> <!-- Content Panel End -->

        </div> <!-- Main End -->
    </div>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="assets/js/bootstrap-checkbox-radio.js"></script>

<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="assets/js/paper-dashboard.js"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>


<script type="text/javascript">
    function requestsignout(){
        if(confirm("Really?")){
            var request = new XMLHttpRequest();

            var obj = new Object();
            obj.client = "web";
            obj.tokenWeb = localStorage.getItem('tokenWeb');

            var jsonData = JSON.stringify(obj);
            console.log(jsonData);

            request.onload = function () {
               var response = this.responseText;
               console.log(response);
               var json = JSON.parse(response);

               if(json.type == "success") {
                  alert("Signout is Completed.")
                  location.href = "http://<?php echo SERVER_IP ?>";
               }
               else {
                    alert(json.value);
                    return;
                }
            };
            request.open("POST", "http://<?php echo SERVER_IP ?>/accounts/signout", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
        }
    }
    /*
    function requestidcancel(){
        if(confirm("Really?")){
            var pwd = prompt("Enter your password.");
            var request = new XMLHttpRequest();

            var obj = new Object();
            obj.client = "web";
            obj.tokenWeb = localStorage.getItem('tokenWeb');
            obj.password = pwd;

            var jsonData = JSON.stringify(obj);
            console.log(jsonData);

            request.onload = function () {
                var response = this.responseText;
                console.log(response);
                var json = JSON.parse(response);
                if(json.type == "success") {
                alert("ID cancellation is completed.")
                location.href = "http://<?php echo SERVER_IP ?>";
                } else {
                    alert(json.value);
                    return;
                }
            };
            request.open("DELETE", "http://<?php echo SERVER_IP ?>/accounts/IDcancellation", true);
            request.setRequestHeader("Content-type", "application/json");
            request.send(jsonData);
        }
    }*/
    </script>

</html>