<?php
namespace Swiftriver\IntegrationTests;
include_once(dirname(__FILE__)."/../ServiceWrapper.php");

if(isset($_POST)) {
    $action = $_POST["action"];
    switch ($action) {
        case "add-new-processing-job" :
            $json = '{"type":"'.$_POST["type"].'",'.
                    '"updatePeriod":"'.$_POST["updatePeriod"].'",'.
                    '"parameters":['.
                        '{"key":"'.$_POST["parameter_1_key"].'","value":"'.$_POST["paramter_1_value"].'"},'.
                        '{"key":"'.$_POST["parameter_2_key"].'","value":"'.$_POST["paramter_2_value"].'"}'.
                    ']}';
            echo "<div class='return'>".$json."<br/></div>";
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/RegisterNewProcessingJob.php");
            echo "<div class='return'>".$service->MakePOSTRequest(array("key" => "test", "data" => $json), 5)."<br/></div>";
            break;
        case "remove" :
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
            $json = $service->MakePOSTRequest(array("key" => "test"), 5);
            $channels = json_decode($json);
            $channels = $channels->{"channels"};
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/RemoveChannelProcessingJob.php");
            $channel = json_encode($channels[$_POST["channelNumber"]]);
            $json = $service->MakePOSTRequest(array("key" => "test", "data" => $channel), 5);
            echo "<div class='return'>".$json."</div>";
            break;
    }
}

$service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
$json = $service->MakePOSTRequest(array("key" => "test"), 5);
echo "<div class='return'>".$json."</div>";
$channels = json_decode($json);
$channels = $channels->{"channels"};
?>
<html>
    <head>
        <title>Channel Processing Job Interface Tests</title>
        <style type="text/css">
            div.return { background-color:#F33; padding:20px; border:3px #A00 solid;}
            body { background-color:black; color:white; }
            body div.page { width:80%; margin-left:auto; margin-right:auto; margin-top:20px; }
            body div.page div.container { border:3px solid #333; margin-bottom:10px;}
            body div.page div.container h2 { padding:10px; margin:0 0 20px 0; background-color:#333; }
            body div.page div.container table.channel-processing-jobs { padding:10px; }
            body div.page div.container table.channel-processing-jobs td { padding:10px; background-color:#333;}
            body div.page div.container table.channel-processing-jobs thead td { font-size:1.3em; font-weight:bold; background-color:blue;}
            body div.page div.container table.channel-processing-jobs td div.no-results { padding:10px;}
        </style>
    </head>
    <body>
        <div class="page">
            <div class="container">
                <h2>Currently Configured Channel Processing Jobs</h2>
                <table class="channel-processing-jobs">
                    <thead>
                        <tr>
                            <td>Type</td>
                            <td>Update Period</td>
                            <td>Parameters</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($channels) && is_array($channels) && count($channels) > 0) : ?>
                            <?php for($i=0; $i<count($channels); $i++) : ?>
                                <?php $parameters = $channels[$i]->parameters ?>
                                <tr>
                                    <td><?php echo($channels[$i]->type); ?></td>
                                    <td><?php echo($channels[$i]->updatePeriod); ?></td>
                                    <td>
                                        <table class="parameters">
                                            <?php foreach($channels[$i]->parameters as $parameter) : ?>
                                            <tr>
                                                <td class="key"><?php echo($parameter->key); ?>:</td>
                                                <td class="value"><?php echo($parameter->value); ?>:</td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </td>
                                    <td>
                                        <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                                            <input type="hidden" name="action" value="remove" />
                                            <input type="hidden" name="channelNumber" value="<?php echo($i); ?>" />
                                            <input type="submit" value="remove" />
                                        </form>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4">
                                <div class="no-results">
                                    <p>There are currently no channel processing jobs in the data store.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <h2>Add a new processing Job</h2>
                <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                    <input type="hidden" name="action" value="add-new-processing-job" />
                    <div class="form-row">
                        <label for="type">Select the type of the Channel:</label>
                        <select name="type">
                            <option value="RSS">RSS</option>
                            <option value="Test">Test</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="updatePeriod">Select the amount of minutes between updates:</label>
                        <select name="updatePeriod">
                            <option value="5">5 minutes</option>
                            <option value="15">15 minutes</option>
                            <option value="30">30 minutes</option>
                            <option value="60">1 hour</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="parameter_1">Enter the key and value for parameter 1:</label>
                        <input type="text" class="small" name="parameter_1_key" value="key1"/>
                        <input type="text" name="paramter_1_value" value="valu1e"/>
                    </div>
                    <div class="form-row">
                        <label for="parameter_2">Enter the key and value for parameter 2:</label>
                        <input type="text" class="small" name="parameter_2_key" value="key2"/>
                        <input type="text" name="paramter_2_value" value="value2"/>
                    </div>
                    <div class="form-row">
                        <input type="submit" value="Add this channel processing job!" />
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
