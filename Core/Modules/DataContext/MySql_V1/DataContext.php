<?php
namespace Swiftriver\Core\Modules\DataContext\MySql_V1;
class DataContext implements \Swiftriver\Core\DAL\DataContextInterfaces\IDataContext {
    /**
     * Checks that the given API Key is registed for this
     * Core install
     *
     * Inhereted from IAPIKeyDataContext
     *
     * @param string $key
     * @return bool
     */
    public static function IsRegisterdCoreAPIKey($key) {
        if(!isset($key) || $key == "")
            return null;
        $query = "SELECT COUNT(*) FROM coreapikeys WHERE apikey = '".$key."';";
        $result = self::RunQuery($query);
        if(!isset($result) || $result == false)
            return null;
        $count = mysql_result($result, 0);
        return $count > 0;
    }

    /**
     * Given a new APIKey, this method adds it to the
     * data store or registered API keys.
     * @param string $key
     * @return bool
     */
    public static function AddRegisteredCoreAPIKey($key) {
        if(!isset($key) || $key == "")
            return false;
        if(self::IsRegisterdCoreAPIKey($key))
            return true;
        $query = "INSERT INTO coreapikeys VALUES('".$key."');";
        $result = self::RunQuery($query);
        return $result;
    }

    /**
     * Given an APIKey, this method will remove it from the
     * data store of registered API Keys
     * Returns true on sucess
     *
     * @param string key
     * @return bool
     */
    public static function RemoveRegisteredCoreAPIKey($key) {
        if(!isset($key) || $key == "")
            return true;
        if(!self::IsRegisterdCoreAPIKey($key))
            return true;
        $query = "DELETE FROM coreapikeys WHERE apikey = '".$key."';";
        $result = self::RunQuery($query);
        return $result;
    }

    /**
     * Adds a new channel processing job to the data store
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function AddNewChannelProgessingJob($channel) {
        if(!isset($channel))
            return;
        $id = ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId());
        $query = "SELECT COUNT(*) FROM channelprocessingjobs WHERE id = '".$id."';";
        $result = self::RunQuery($query);
        $result = mysql_result($result, 0);
        if($result > 0)
            return;
        $type = $channel->type;
        $updatePeriod = $channel->updatePeriod;
        $nextrun = time() + ($updatePeriod * 60);
        $nextrun = date("Y-m-d H:i:s", $nextrun);
        $rawParameters = $channel->parameters;
        $parameters = "";
        foreach(array_keys($channel->parameters) as $key) {
            $encodedKey = urlencode($key);
            $encodedValue = urlencode($rawParameters[$key]);
            $parameters .= $encodedKey.",".$encodedValue."|";
        }
        $parameters = rtrim($parameters, "|");

        $query = "INSERT INTO channelprocessingjobs VALUES(".
                 "'".$id."',".
                 "'".$type."',".
                 "'".$parameters."',".
                 $updatePeriod.",".
                 "'".$nextrun."',".
                 "null,".
                 "null,".
                 "0,".
                 "1);";
        $result = self::RunQuery($query);
    }

    /**
     * Given a date time, this function returns the next due
     * channel processing job.
     *
     * @param DateTime $time
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public static function SelectNextDueChannelProcessingJob($time){
        if(!isset($time))
            $time = time();
        $query = "SELECT * FROM channelprocessingjobs WHERE active = 1 ORDER BY nextrun limit 1;";
        $result = self::RunQuery($query);
        if(!$result) {
            return null;
        }
        $channel = new \Swiftriver\Core\ObjectModel\Channel();
        $timesrun = null;
        while($row = mysql_fetch_array($result, \MYSQL_ASSOC)) {
            $type = $row["type"];
            $parameters = $row["parameters"];
            $updatePeriod = $row["updateperiod"];
            $nextrun = strtotime($row["nextrun"]);
            $lastrun = strtotime($row["lastrun"]);
            $lastsucess = strtotime($row["lastsucess"]);
            $timesrun = $row["timesrun"];
            $active = $row["active"];
            $channel->type = $type;
            $channel->updatePeriod = $updatePeriod;
            $channel->active = !isset($active) || $active != "0";
            if(isset($lastsucess) && $lastsucess != 0) {
                $channel->lastSucess = $lastsucess;
            }
            $params = array();
            foreach(explode("|", $parameters) as $parameter) {
                $pair = explode(",", $parameter);
                $key = urldecode($pair[0]);
                $value = urldecode($pair[1]);
                $params[$key] = $value;
            }
            $channel->parameters = $params;
        }

        if(!isset($channel->type) || !isset($channel->parameters))
            return null;

        $nextrun = time() + ($channel->updatePeriod * 60);
        $nextrun = date("Y-m-d H:i:s", $nextrun);
        $query = "UPDATE channelprocessingjobs SET ".
                 "nextrun = '".$nextrun."', ".
                 "timesrun = ".($timesrun+1).", ".
                 "lastrun = '".date("Y-m-d H:i:s", time())."' ".
                 "WHERE id = '".ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId())."';";
        $result = self::RunQuery($query);

        return $channel;
    }

    /**
     * Given a Channel processing job, this method upadtes the data store
     * to reflect that the last run was a sucess.
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function MarkChannelProcessingJobAsComplete($channel) {
        if(!isset($channel))
            return;

        $query = "UPDATE channelprocessingjobs SET ".
                 "lastsucess = '".date("Y-m-d H:i:s", time())."' ".
                 "WHERE id = '".ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId())."';";
        $result = self::RunQuery($query);
    }

    /**
     * Given a Channel processing job, this method marks it as active
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function ActivateChannelProcessingJob($channel) {
        if(!isset($channel))
            return;

        $query = "UPDATE channelprocessingjobs SET ".
                 "active = 1 ".
                 "WHERE id = '".ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId())."';";
        $result = self::RunQuery($query);
    }

    /**
     * Given a Channel processing job, this method marks it as deactive
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function DeactivateChannelProcessingJob($channel) {
        if(!isset($channel))
            return;

        $query = "UPDATE channelprocessingjobs SET ".
                 "active = 0 ".
                 "WHERE id = '".ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId())."';";
        $result = self::RunQuery($query);
    }

    /**
     * Given a Channel processing job, this method deletes it from the data store
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function RemoveChannelProcessingJob($channel) {
        if(!isset($channel))
            return;

        $query = "DELETE FROM channelprocessingjobs ".
                 "WHERE id = '".ereg_replace("[^A-Za-z0-9 _]", "", $channel->GetId())."';";
        $result = self::RunQuery($query);
    }

    /**
     * Lists all the current Channel Processing Jobs in the core
     * @return \Swiftriver\Core\ObjectModel\Channel[]
     */
    public static function ListAllChannelProcessingJobs() {
        $query = "SELECT * FROM channelprocessingjobs ORDER BY nextrun;";
        $result = self::RunQuery($query);
        if(!$result) {
            return null;
        }
        $channels = array();
        while($row = mysql_fetch_array($result, \MYSQL_ASSOC)) {
            $type = $row["type"];
            $parameters = $row["parameters"];
            $updatePeriod = $row["updateperiod"];
            $nextrun = strtotime($row["nextrun"]);
            $lastrun = strtotime($row["lastrun"]);
            $lastsucess = strtotime($row["lastsucess"]);
            $timesrun = $row["timesrun"];
            $active = $row["active"];
            $channel = new \Swiftriver\Core\ObjectModel\Channel();
            $channel->type = $type;
            $channel->updatePeriod = $updatePeriod;
            $channel->active = !isset($active) || $active != 0;
            $channel->lastSucess = $lastsucess;
            $params = array();
            foreach(explode("|", $parameters) as $parameter) {
                $pair = explode(",", $parameter);
                $key = urldecode($pair[0]);
                $value = urldecode($pair[1]);
                $params[$key] = $value;
            }
            $channel->parameters = $params;
            $channels[] = $channel;
        }
        return $channels;
    }

    /**
     * Given a set of content items, this method will persist
     * them to the data store, if they already exists then this
     * method should update the values in the data store.
     *
     * @param \Swiftriver\Core\ObjectModel\Content[] $content
     */
    public static function SaveContent($content){
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::Modules::SiSPS::Parsers::RSSParser::GetAndParse [Method invoked]", \PEAR_LOG_DEBUG);

        //initiate the redbean dal contoller
        $rb = RedBeanController::RedBean();

        //loop throught each item of content
        foreach($content as $item) {
            $i = reset(RedBeanController::Finder()->where("content", "textId = :id", array(":id" => $item->id)));

            if(!$i || $i == null) {
                //Create a new data store object
                $i = $rb->dispense("content");
            }

            //Add any properties we wish to be un encoded to the data store object
            $i = DataContext::AddPropertiesToDataSoreItem(
                    $i,
                    $item,
                    array(
                        "textId" => "id",
                        "state" => "state",
                        "date" => "date",
                    ));

            //Add the encoded content item to the data store object
            $i->json = json_encode($item);

            //Save the data store object
            $rb->store($i);

            //get the source from the content
            $source = $item->source;

            //get the source from the db
            $s = reset(RedBeanController::Finder()->where("source", "textId = :id", array(":id" => $source->id)));

            //If the source does not exists, create it.
            if(!$s || $s == null) {
                //create the new data store object for the source
                $s = $rb->dispense("source");
            }

            $s = DataContext::AddPropertiesToDataSoreItem(
                    $s,
                    $source,
                    array(
                        "textId" => "id",
                    ));

            //add the encoded source object to the data sotre object
            $s->json = json_encode($source);

            //save the source
            $rb->store($s);

            //create the association between content and source
            RedBeanController::Associate($i, $s);

            /*
            $i = $rb->dispense("contentitems");

            //copy over the properties
            $i->textId = $item->id;
            //this is a bit silly but if the value is 0 then the redbean
            //initilises the column as something other than int, this way
            //i can ensure int type and just knock off 10 on the way out !?!?
            $i->state = $item->state + 10;
            $i->title = $item->title;
            $i->link = $item->link;
            $i->date = $item->date;

            //comit the content to the DB
            $rb->store($i);

            //Then add the new text
            foreach($item->text as $text) {
                //initiare the db table
                $t = $rb->dispense("content_text");

                //extratc the text
                $t->text = $text;

                //store the text
                $rb->store($t);

                //Assocate the text with the content
                RedBeanController::Associate($t, $i);
            }

            //then add all new tags
            foreach($item->tags as $tag) {
                //initiate the tags db table
                $t = $rb->dispense("content_tags");

                //get the tag properties
                $t->type = $tag->type;
                $t->text = $tag->text;

                //store the tag
                $rb->store($t);

                //Associate the tag with the content
                RedBeanController::Associate($t, $i);
            }

            //loop through the DFICollections
            foreach($item->difs as $collection) {
                //initiate the dif collection db table
                $c = $rb->dispense("dif_collections");

                //Get the properties
                $c->name = $collection->name;
                
                //store the collection
                $rb->store($c);

                //Associate the collection with the contet
                RedBeanController::Associate($c, $i);

                //Loop through the difs
                foreach($collection->difs as $dif) {
                    //initiate the dif db table
                    $d = $rb->dispense("difs");

                    //Get the properties
                    $d->type = $dif->type;
                    $d->value = $dif->value;

                    //store the dif
                    $rb->store($d);

                    //associate the dif with the collection
                    RedBeanController::Associate($d, $c);
                }
            }

            //Finally create and associate the source content
            //Get the source
            $source = $item->source;

            //load the potential from the db
            $potentialSources = RedBeanController::Finder()->where("source", "textId = :id limit 1", array(":id" => $source->id));

            //if the source exists use it or create it
            if(isset($potentialSources) && is_array($potentialSources) && count($potentialSources) == 1) {
                $sourceId = reset($potentialSources);
                $s = $rb->load("source", $sourceId);
            } else {
                $s = $rb->dispense("source");
            }

            //set the source properties
            $s->textId = $source->id;
            $s->score = $source->score;

            //Save the source
            $rb->store($s);

            //Associate the source and content
            RedBeanController::Associate($i, $s);
            */
        }
    }

    /**
     * Given an array of content is's, this function will
     * fetch the content objects from the data store.
     *
     * @param string[] $ids
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public static function GetContent($ids, $orderby = null) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [Method invoked]", \PEAR_LOG_DEBUG);

        //if no $orderby is sent
        if(!$orderby || $orderby == null) {
            $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [No Order By clause set, setting to 'date desc']", \PEAR_LOG_DEBUG);
            //Set it to the default - date DESC
            $orderby = "date desc";
        }

        //set up the return array
        $content = array();

        //If the $ids array is blank or empty, return the empty array
        if(!isset($ids) || !is_array($ids) || count($ids) < 1) {
            $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [No IDs sent to method]", \PEAR_LOG_DEBUG);
            $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [Method finsiehd]", \PEAR_LOG_DEBUG);
            return $content;
        }

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [START: Building the RedBean Query]", \PEAR_LOG_DEBUG);

        //set up the array to hold the ids
        $queryIds = array();

        //start to build the sql
        $query = "textId in (";

        /*//for each content item, add to the query and the ids array
        for($i=0; $i<count($ids); $i++) {
            $query .= ":id$i,";
            $queryIds[":id$i"] = $ids[$i];
        }*/

        $counter = 0;
        foreach($ids as $id) {
            $query .= ":id$counter,";
            $queryIds[":id$counter"] = $id;
            $counter++;
        }

        //tidy up the query
        $query = rtrim($query, ",").") order by ".$orderby;

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [END: Building the RedBean Query]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [START: Running RedBean Query]", \PEAR_LOG_DEBUG);

        //Get the finder
        $finder = RedBeanController::Finder();

        //Find the content
        $dbContent = $finder->where("content", $query, $queryIds);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [FINISHED: Running RedBean Query]", \PEAR_LOG_DEBUG);

        //set up the return array
        $content = array();

        //set up the red bean
        $rb = RedBeanController::RedBean();

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [START: Constructing Content and Source items]", \PEAR_LOG_DEBUG);

        //loop through the db content
        foreach($dbContent as $key => $dbItem) {
            //get the associated source
            $s = reset($rb->batch("source", RedBeanController::GetRelatedBeans($dbItem, "source")));

            //Create the source from the db json
            $source = \Swiftriver\Core\ObjectModel\ObjectFactories\SourceFactory::CreateSourceFromJSON($s->json);

            //get the json for the content
            $json = $dbItem->json;

            //create the content
            $item = \Swiftriver\Core\ObjectModel\ObjectFactories\ContentFactory::CreateContent($source, $json);

            //add it to the array
            $content[] = $item;
        }

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [END: Constructing Content and Source items]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetContent [Method finished]", \PEAR_LOG_DEBUG);

        //return the content
        return $content;
    }

    /**
     * Given an array of content items, this method removes them
     * from the data store.
     * @param \Swiftriver\Core\ObjectModel\Content[] $content
     */
    public static function DeleteContent($content) {
        //Get the database name


        //initiate the redbean dal contoller
        $rb = RedBeanController::RedBean();

        //set up the array to hold the ids
        $ids = array();
        
        //start to build the sql
        $query = "delete from content where textId in (";
        
        //for each content item, add to the query and the ids array
        for($i=0; $i<count($content); $i++) {
            $query .= ":id$i,";
            $ids[":id$i"] = $content[$i]->id;
        }
        
        //tidy up the query
        $query = rtrim($query, ",").")";
        
        //Get the RB database adapter
        $db = RedBeanController::DataBaseAdapter();
        
        //execute the sql
        $db->exec($query, $ids);
        
        /*
        //loop throught each item of content
        foreach($content as $item) {
            $potentials = RedBeanController::Finder()->where("content", "textid = :id limit 1", array(":id" => $item->id));
            if(!isset($potentials) || !is_array($potentials) || count($potentials) == 0) {
                continue;
            }

            //get the content
            $i = reset($potentials);

            //First remove all existing text
            $textToRemove = $rb->batch("content_text", RedBeanController::GetRelatedBeans($i, "content_text"));
            if(isset($textToRemove) && is_array($textToRemove) && count($textToRemove) > 0) {
                foreach($textToRemove as $ttr) {
                    $rb->trash($ttr);
                }
            }

            //first remove the existing tags
            $tagsToRemove = $rb->batch("content_tags", RedBeanController::GetRelatedBeans($i, "content_tags"));
            if(isset($tagsToRemove) && is_array($tagsToRemove) && count($tagsToRemove) > 0) {
                foreach($tagsToRemove as $ttr) {
                    $rb->trash($ttr);
                }
            }

            //remove all existing difcollection and their difs
            $difCollectionsToRemove = $rb->batch("dif_collections", RedBeanController::GetRelatedBeans($i, "dif_collections"));
            if(isset($difCollectionsToRemove) && is_array($difCollectionsToRemove) && count($difCollectionsToRemove) > 0) {
                foreach($difCollectionsToRemove as $dctr) {
                    $difstoremove = $rb->batch("difs", RedBeanController::GetRelatedBeans($dctr, "difs"));
                    if(isset($difstoremove) && is_array($difstoremove) && count($difstoremove) > 0) {
                        foreach($difstoremove as $diftoremove) {
                            $rb->trash($diftoremove);
                        }
                    }
                    $rb->trash($dctr);
                }
            }

            //Remove the content
            $rb->trash($i);
         
        }
        */
    }

    /**
     * Given a state, pagesize, page start index and possibly
     * an order by calse, this method will return a page of content.
     *
     * @param int $state
     * @param int $pagesize
     * @param int $pagestart
     * @param string $orderby
     * @return array("totalCount" => int, "contentItems" => Content[])
     */
    public static function GetPagedContentByState($state, $pagesize, $pagestart, $orderby = null) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [Method invoked]", \PEAR_LOG_DEBUG);

        //if no $orderby is sent
        if(!$orderby || $orderby == null) {
            $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [No Order By clause set, setting to 'date desc']", \PEAR_LOG_DEBUG);
            //Set it to the default - date DESC
            $orderby = "date desc";
        }

        //initilise the red bean controller
        $rb = RedBeanController::RedBean();

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [START: Get total record count for state: $state]", \PEAR_LOG_DEBUG);

        //get the total count to return
        $totalCount = RedBeanController::DataBaseAdapter()->getCell(
                "select count(id) from content where state = :state",
                array(":state" => $state));

        //set the return as an int
        $totalCount = (int) $totalCount;

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [Total record count = $totalCount]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [END: Get total record count for state: $state]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [START: Get the id's of the content that should be returned]", \PEAR_LOG_DEBUG);

        //set the SQL
        $sql = "select textId from content where state = $state order by $orderby limit $pagestart , $pagesize";

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [Getting ID's with query: $sql]", \PEAR_LOG_DEBUG);

        //Get the page of IDs
        $ids = RedBeanController::DataBaseAdapter()->getCol($sql);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [END: Get the id's of the content that should be returned]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [START: Getting the content for the ids]", \PEAR_LOG_DEBUG);

        //Get the content items
        $content = self::GetContent($ids, $orderby);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [END: Getting the content for the ids]", \PEAR_LOG_DEBUG);

        $logger->log("Core::Modules::DataContext::MySQL_V1::DataContext::GetPagedContentByState [Method finished]", \PEAR_LOG_DEBUG);

        return array ("totalCount" => $totalCount, "contentItems" => $content);
    }

    public static function RunQuery($query) {
        //TODO: Logging
        $url = (string)Setup::$Configuration->DataBaseUrl;
        $username = (string)Setup::$Configuration->UserName;
        $password = (string)Setup::$Configuration->Password;

        //Open a connection to the DB server
        $mysql = mysql_connect($url, $username, $password);

        //Select the databse
        $database = (string)Setup::$Configuration->Database;

        $return = mysql_select_db($database, $mysql);
        $error = mysql_error($mysql);

        $return = mysql_query($query, $mysql);
        $error = mysql_error($mysql);

        mysql_close($mysql);

        return $return;
    }

    private static function AddPropertiesToDataSoreItem($dataStoreItem, $sourceItem, $propertiesArray) {
        foreach($propertiesArray as $key => $value) {
            $dataStoreItem->$key = $sourceItem->$value;
        }
        return $dataStoreItem;
    }
}
?>
