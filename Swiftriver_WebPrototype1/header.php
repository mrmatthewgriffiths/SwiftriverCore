<?php
//Include the service wrapper
include_once("ServiceWrapper.php");

//Use the service wrapper to make an async call to get an parser any new content
$service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/RunNextProcessingJob.php");
//$service->MakeAsyncPostRequest(array("key" => "test"));

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
        <title>Swiftriver - Web Prototype 1</title>
        <style type="text/css">
            body { background-color: #FDFFBC; }
            body a { text-decoration: none; color: black; }
            body a:hover { text-decoration: underline; }
            body div#page { width:800px; margin-right: auto; margin-left: auto;}
            body div#page ul.navigation { background-color: #BCC4FF; padding:10px; margin:0; }
            body div#page ul.navigation li { display: inline; padding:10px;}
            body div#page div#channeljobs { width: 95%; margin-right: auto; margin-left: auto; }
            body div#page div#channeljobs table#channellist { width: 90%; margin-left:auto; margin-right:auto; }
            body div#page div#channeljobs table#channellist thead { background-color: #222; color: #fff; font-weight: bold; }
            body div#page div#content { width: 95%; margin-right: auto; margin-left: auto; }
            body div#page div#content div.item { border: 1px solid black;}
            /* body div#page div#content div.item p.id { display: none; }*/
            body div#page div#content div.item p.title { font-weight: bold; font-size: 1.3em; }
            body div#page div#content div.item ul.tags li { display: inline-block; padding:5px; background-color: #BCC4FF; margin:0;}
            body div#page div#content div.item div.source { background-color: #BCC4FF; border: 1px solid black;  width: 95%; margin-right: auto; margin-left: auto; margin-top:5px; }
            body div#page div#content div.item div.source p.id { display: block;}
        </style>
    </head>
    <body>
        <div id="page">
            <div id="header">
                <ul class="navigation">
                    <li><a href="/index.php">Home</a></li>
                    <li><a href="/channeljobs.php">Channel Processing Jobs</a></li>
                    <li><a href="/content.php">Content</a></li>
                </ul>
            </div>