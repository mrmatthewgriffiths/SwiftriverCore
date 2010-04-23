<?php include_once("header.php"); ?>

<div id="content">
    <?php
        $service = new ServiceWrapper("http://local.swiftcore.com/ServiceAPI/ContentServices/GetPagedContentByState.php");
        $params = json_encode(array("state" => "new_content", "pagestart" => 0, "pagesize" => 20));
        $json = $service->MakePOSTRequest(array("key" => "aaabbbcccddd", "data" => $params), 5);
        $return = json_decode($json);
    ?>
    <?php foreach($return->contentitems as $content) : ?>
        <div class="item">
            <div class="source">
                <h5>The Source</h5>
                <p class="id">ID: <?php echo $content->source->id; ?></p>
                <p class="score">Current Rating: <?php echo($content->source->score ? $content->source->score : "not yet rated"); ?></p>
            </div>
            <p class="id">ID: <?php echo $content->id ?></p>
            <p class="state">State: <?php echo $content->state ?></p>
            <p class="date">Date: <?php echo date("c", $content->date); ?></p>
            <p class="link">Link: <a href="<?php echo $content->link ?>" target="_blank"><?php echo $content->link ?></a></p>
            <div class="text">
                <?php foreach($content->text as $lang) : ?>
                    <div class="languagetext">
                        <h5>Text in <?php var_dump($lang->languageCode); ?></h5>
                        <p class="title">Title: <?php echo($lang->title); ?></p>
                        <?php foreach($lang->text as $text) : ?>
                            <p class="text"><?php echo($text); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <ul class="tags">
                <h5>Tags:</h5>
                <?php foreach($content->tags as $tag): ?>
                    <li><b><?php echo $tag->type; ?></b>: <?php echo $tag->text; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once("footer.php"); ?>