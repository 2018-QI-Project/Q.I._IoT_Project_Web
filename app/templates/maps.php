<!doctype html>
<html lang="en">
<head>
    <title>VogLog_Maps</title>
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

    <script type="text/javascript">
        function allUserRealtimeAQ(selectedGas) {
            var obj = new Object();
            obj.client = 'web';
            obj.tokenWeb = localStorage.getItem('tokenWeb');
            obj.allUser = 'true';

            var dataArray_co = new Array();
            var dataArray_no2 = new Array();
            var dataArray_so2 = new Array();
            var dataArray_o3 = new Array();
            var dataArray_pm25 = new Array();
            var dataArray_coAqi = new Array();
            var dataArray_no2Aqi = new Array();
            var dataArray_so2Aqi = new Array();
            var dataArray_o3Aqi = new Array();
            var dataArray_pm25Aqi = new Array();
            var dataArray_date = new Array();
            var dataArray_latitude = new Array();
            var dataArray_longitude = new Array();
            var myLatlng = new Array();
            var marker = new Array();
            var date = new Array();
            var year = new Array();
            var month = new Array();
            var day = new Array();
            var hours = new Array();
            var minutes = new Array();
            var seconds = new Array();
            var formattedTime = new Array();
            var content = new Array();
            var infowindow = new Array();

            var centerLatlng = new google.maps.LatLng(32.880573, -117.235643);

            $.ajax({
                    url:'http://<?php echo SERVER_IP ?>/data/getRealtimeAQ',
                    dataType:'json',
                    type:'POST',
                    data:obj,
                    success:function(result){
                        if(result['type']=="success"){
                            var airData = result.airData;

                            var i = 0;

                            while(i < airData.length)
                            {
                                dataArray_co[i] = airData[i].co;
                                dataArray_no2[i] = airData[i].no2;
                                dataArray_so2[i] = airData[i].so2;
                                dataArray_o3[i] = airData[i].o3;
                                dataArray_pm25[i] = airData[i].pm25;
                                dataArray_coAqi[i] = airData[i].coAqi;
                                dataArray_no2Aqi[i] = airData[i].no2Aqi;
                                dataArray_so2Aqi[i] = airData[i].so2Aqi;
                                dataArray_o3Aqi[i] = airData[i].o3Aqi;
                                dataArray_pm25Aqi[i] = airData[i].pm25Aqi;
                                dataArray_date[i] = airData[i].date;

                                myLatlng[i] = new google.maps.LatLng(airData[i].latitude, airData[i].longitude);

                                i++;
                            }

                            //$('#test').html(dataArray_longitude[1]);

                            var mapOptions = {
                              zoom: 13,
                              center: centerLatlng,
                              scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
                              styles: [{"featureType":"water","stylers":[{"saturation":43},{"lightness":-11},{"hue":"#0088ff"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"hue":"#ff0000"},{"saturation":-100},{"lightness":99}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#808080"},{"lightness":54}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ece2d9"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#ccdca1"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#767676"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#b8cb93"}]},{"featureType":"poi.park","stylers":[{"visibility":"on"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"on"}]},{"featureType":"poi.medical","stylers":[{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"simplified"}]}]
                          }

                          var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                          i=0;

                          while(i < airData.length) {
                            date[i] = new Date(dataArray_date[i]*1000);

                            year[i] = date[i].getFullYear();
                            month[i] = date[i].getMonth()+1;
                            month[i] = "0" + month[i];
                            day[i] = "0" + date[i].getDate();
                            hours[i] = "0" + date[i].getHours();
                            minutes[i] = "0" + date[i].getMinutes();
                            seconds[i] = "0" + date[i].getSeconds();

                            formattedTime[i] = year[i] + "-" + month[i].substr(-2) + "-" + day[i].substr(-2) + " " + hours[i].substr(-2) + ":" + minutes[i].substr(-2) + ":" + seconds[i].substr(-2);

                            if(selectedGas=="CO")
                            {
                                content[i] = "co: " + dataArray_co[i];

                                if(0<=dataArray_coAqi[i] && dataArray_coAqi[i]<=50) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#01E400",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(51<=dataArray_coAqi[i] && dataArray_coAqi[i]<=100) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#fec844",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(101<=dataArray_coAqi[i] && dataArray_coAqi[i]<=150) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FD7D00",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(151<=dataArray_coAqi[i] && dataArray_coAqi[i]<=200) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FE0000",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(201<=dataArray_coAqi[i] && dataArray_coAqi[i]<=300) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#98004B",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#7E0123",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                            }
                            else if(selectedGas=="NO2")
                            {
                                content[i] = "no2: " + dataArray_no2[i];

                                if(0<=dataArray_no2Aqi[i] && dataArray_no2Aqi[i]<=50) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#01E400",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(51<=dataArray_no2Aqi[i] && dataArray_no2Aqi[i]<=100) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#fec844",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(101<=dataArray_no2Aqi[i] && dataArray_no2Aqi[i]<=150) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FD7D00",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(151<=dataArray_no2Aqi[i] && dataArray_no2Aqi[i]<=200) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FE0000",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(201<=dataArray_no2Aqi[i] && dataArray_no2Aqi[i]<=300) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#98004B",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#7E0123",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                            }
                            else if(selectedGas=="SO2")
                            {
                                content[i] = "so2: " + dataArray_so2[i];

                                if(0<=dataArray_so2Aqi[i] && dataArray_so2Aqi[i]<=50) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#01E400",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(51<=dataArray_so2Aqi[i] && dataArray_so2Aqi[i]<=100) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#fec844",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(101<=dataArray_so2Aqi[i] && dataArray_so2Aqi[i]<=150) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FD7D00",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(151<=dataArray_so2Aqi[i] && dataArray_so2Aqi[i]<=200) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FE0000",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(201<=dataArray_so2Aqi[i] && dataArray_so2Aqi[i]<=300) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#98004B",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#7E0123",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                            }
                            else if(selectedGas=="O3")
                            {
                                content[i] = "o3: " + dataArray_o3[i];

                                if(0<=dataArray_o3Aqi[i] && dataArray_o3Aqi[i]<=50) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#01E400",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(51<=dataArray_o3Aqi[i] && dataArray_o3Aqi[i]<=100) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#fec844",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(101<=dataArray_o3Aqi[i] && dataArray_o3Aqi[i]<=150) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FD7D00",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(151<=dataArray_o3Aqi[i] && dataArray_o3Aqi[i]<=200) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FE0000",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(201<=dataArray_o3Aqi[i] && dataArray_o3Aqi[i]<=300) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#98004B",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#7E0123",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                            }
                            else if(selectedGas=="PM2.5")
                            {
                                content[i] = "pm2.5: " + dataArray_pm25[i];

                                if(0<=dataArray_pm25Aqi[i] && dataArray_pm25Aqi[i]<=50) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#01E400",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(51<=dataArray_pm25Aqi[i] && dataArray_pm25Aqi[i]<=100) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#fec844",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(101<=dataArray_pm25Aqi[i] && dataArray_pm25Aqi[i]<=150) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FD7D00",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(151<=dataArray_pm25Aqi[i] && dataArray_pm25Aqi[i]<=200) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#FE0000",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else if(201<=dataArray_pm25Aqi[i] && dataArray_pm25Aqi[i]<=300) {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#98004B",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                                else {
                                    marker[i] = new google.maps.Marker({
                                        position: myLatlng[i],
                                        icon: {
                                            path: google.maps.SymbolPath.CIRCLE,
                                            scale: 20,
                                            fillColor: "#7E0123",
                                            fillOpacity: 0.4,
                                            strokeWeight: 0.4
                                        },
                                        title: formattedTime[i],
                                        tag: i
                                    });
                                }
                            }
                            else
                            {
                                alert("Select Sensor Type!!!");
                                return;
                            }



                            infowindow[i] = new google.maps.InfoWindow();
                            infowindow[i].setContent(content[i]);



                            google.maps.event.addListener(marker[i], 'click', function() {
                                infowindow[this.tag].open(map, this);
                          });

                            marker[i].setMap(map);

                            i++;
                          }
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
                    <li>
                        <a href="/dashboard">
                            <i class="ti-bar-chart-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!--
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
                    -->

                    <!-- Maps -->
                    <li class="active">
                        <a href="/maps">
                            <i class="ti-map"></i>
                            <p>Maps</p>
                        </a>
                    </li>

                    <!--
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
                        <a class="navbar-brand">Maps</a>
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

                    <div style="font-size:28px">Real-time Air Quality in Map</div><br>
                    <!-- AQI Index -->
                        <div>
                            <span style="font-size:20px">&nbsp;&nbsp;&nbsp; ▶ AQI Index</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <img src="images/aqi.png" width="1073" height="60">
                        </div><br>
                    <!-- Real time Air Quality and Heart-Related Data -->
                    <div class="card card-map">
                        <div id="test"></div>
                        <!-- Map Title -->
    					<div class="header">
                            <!-- Dropbox -->
                            <h4 class="title">Choose Sensor Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select id="select_gas" onchange="getSelectedValue()">
                                <option value="-">-------</option>
                                <option value="co">CO</option>
                                <option value="no2">NO2</option>
                                <option value="so2">SO2</option>
                                <option value="o3">O3</option>
                                <option value="pm25">PM2.5</option>
                            </select>
                        </div>
                        <script type="text/javascript">
                            function getSelectedValue() {
                                var langSelect = document.getElementById("select_gas");
                                var selectedGas = langSelect.options[langSelect.selectedIndex].text;

                                allUserRealtimeAQ(selectedGas);
                            }
                        </script>

                        </h4>
                        <!-- Draw Google Map -->
    					<div class="map">
    						<div id="map"></div>
    					</div>
    				</div>
    			</div>
    		</div>
        </div> <!-- Main Panel End -->
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCOmZQvF-r8-96ohAteIZC9IqAOiNoqiyY&language=en"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="assets/js/paper-dashboard.js"></script>

	<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>

    <!--
    <script>
        $().ready(function(){
            demo.initGoogleMaps();
        });
    </script> 
    -->

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
    </script>

</html>