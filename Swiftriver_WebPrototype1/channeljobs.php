<?php include_once("header.php"); ?>

<?php $action = $_GET["action"]; ?>

<?php
if(isset($_POST)) {
    $inneraction = $_POST["inneraction"];
    switch ($inneraction) {
        case "add-new-processing-job" :
            $json = '{"type":"RSS",'.
                    '"updatePeriod":"'.$_POST["updatePeriod"].'",'.
                    '"parameters":{"feedUrl":"'.$_POST["feedUrl"].'"}}';
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/RegisterNewProcessingJob.php");
            $service->MakePOSTRequest(array("key" => "test", "data" => $json), 5);
            break;
        case "remove" :
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
            $json = $service->MakePOSTRequest(array("key" => "test"), 5);
            $channels = json_decode($json);
            $channels = $channels->channels;
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/RemoveChannelProcessingJob.php");
            $channel = json_encode($channels[$_POST["channelNumber"]]);
            $json = $service->MakePOSTRequest(array("key" => "test", "data" => $channel), 5);
            break;
        case "activate" :
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
            $json = $service->MakePOSTRequest(array("key" => "test"), 5);
            $channels = json_decode($json);
            $channels = $channels->channels;
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ActivateChannelProcessingJob.php");
            $channel = json_encode($channels[$_POST["channelNumber"]]);
            $json = $service->MakePOSTRequest(array("key" => "test", "data" => $channel), 5);
            break;
        case "deactivate" :
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
            $json = $service->MakePOSTRequest(array("key" => "test"), 5);
            $channels = json_decode($json);
            $channels = $channels->channels;
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/DeactivateChannelProcessingJob.php");
            $channel = json_encode($channels[$_POST["channelNumber"]]);
            $json = $service->MakePOSTRequest(array("key" => "test", "data" => $channel), 5);
            break;
    }
}
?>

<div id="channeljobs">
    <h1>Channel Processing Jobs</h1>
    <ul class="navigation">
        <li><a href="channeljobs.php">List Processing Jobs</a></li>
        <li><a href="channeljobs.php?action=new&type=rss">Add new Rss Channel Processing Job</a></li>
    </ul>
    <?php if(!$action) : ?>
        <?php
            $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ChannelProcessingJobServices/ListAllChannelProcessingJobs.php");
            $json = $service->MakePOSTRequest(array("key" => "test"), 5);
            $return = json_decode($json);
            $channels = $return->channels;
        ?>
        <table id="channellist">
            <thead>
                <tr>
                    <td>Feed:</td>
                    <td>Update Period:</td>
                    <td>Active:</td>
                    <td colspan="2"></td>
                </tr>
            </thead>
            <tbody>
                <?php for($i=0; $i < count($channels); $i++) : ?>
                    <tr>
                        <td><?php echo($channels[$i]->parameters->feedUrl); ?></td>
                        <td><?php echo($channels[$i]->updatePeriod); ?></td>
                        <td><?php echo($channels[$i]->active == 1 ? "true" : "false"); ?></td>
                        <td>
                            <?php if($channels[$i]->active != 1) : ?>
                                <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <input type="hidden" name="inneraction" value="activate" />
                                    <input type="hidden" name="channelNumber" value="<?php echo($i); ?>" />
                                    <input type="submit" value="activate" />
                                </form>
                            <?php else: ?>
                                <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <input type="hidden" name="inneraction" value="deactivate" />
                                    <input type="hidden" name="channelNumber" value="<?php echo($i); ?>" />
                                    <input type="submit" value="deactivate" />
                                </form>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="inneraction" value="remove" />
                                <input type="hidden" name="channelNumber" value="<?php echo($i); ?>" />
                                <input type="submit" value="remove" />
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    <?php elseif ($action == "new") : ?>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                <input type="hidden" name="inneraction" value="add-new-processing-job" />
                <table id="addchannel">
                    <tbody>
                        <tr>
                            <td>Select how oftern this channel job should run:</td>
                            <td>
                                <select name="updatePeriod">
                                    <option value="1">Every minute</option>
                                    <option value="15">Every quater of an hour</option>
                                    <option value="60">Every hour</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Enter the feed url:</td>
                            <td>
                                <input type="text" name="feedUrl" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" value="Add this channel processing job!" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
    <?php endif; ?>
</div>

<?php include_once("footer.php"); ?>