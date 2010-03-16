<?php
namespace Swiftriver\SiCDS\SiCDSInterface;

$configurationStepName = "SiCDS";

//Work out if we should be processing data or showing the UI
if(isset($_POST["action"])) {

    //Validation and error handeling
    $errors = array();
    $serviceUri = $_POST["serviceUri"];
    if(!isset($serviceUri) || trim($serviceUri) < " ")
        $errors["serviceUri"] = "You must specify the Uri of the SiCDS";
    elseif (strpos(" ".$serviceUri, "http://") == false)
        $errors["serviceUri"] = "The service URI you entered does not start with 'HTTP://' and it should";

    //if no errors then try the file write
    if(count($errors) == 0) {
        $fileName = dirname(__FILE__)."/Setup.php";
        $rawFile = @file($fileName);
        $rawLines = array();

        foreach($rawFile as $line_number => $line)
            $rawLines[] = rtrim($line, "\r\n").\PHP_EOL;

        $newFile = fopen($fileName, "w");

        foreach($rawLines as $rawLine) {
            if(strpos($rawLine, "serviceUri = "))
                fwrite($newFile, "\$serviceUri = '".$serviceUri."'".\PHP_EOL);
            else
                fwrite($newFile, $rawLine);
        }

        fclose($newFile);

        //Mark as finished to the main installer can continue
        $finished = true;
    }
}
//if first time or on error, say we are not finished
$finished = false;
?>
<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="POST">
    <?php if(count($errors) > 0): ?>
    <div class="form-error">
        <p>
            You have made a few mistakes while completing the form, please
            review the errors below and fix them before you go on.
        </p>
        <ul>
            <?php foreach($errors as $error): ?>
            <li><?php echo($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <input type="hidden" name="action" value="configure" />
    <p class="form-heading">
        This configuration step is all about setting up the Swiftriver
        Content Duplication Service (SiCDS).
    </p>
    <p class="form-description">
        In the boxes below, enter the information that is required to
        configure the SiCDS.
    </p>
    <div class="form-row <?php if(isset($errors["serviceUri"])) echo('form-row-inerror'); ?>">
        <label for="serviceUri">Enter the URI of the SiCDS Service:</label>
        <input type="text" name="serviceUri" />
        <?php if(isset($errors["serviceUri"])):?>
            <p class="form-row-error"><?php echo($errors["serviceUri"]);?></p>
        <?php endif; ?>
    </div>
    <div class="form-row">
        <input type="submit" value="Submit" />
    </div>
</form>
