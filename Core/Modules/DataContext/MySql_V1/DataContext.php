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
        $type = $channel->GetType();
        $updatePeriod = $channel->GetUpdatePeriod();
        $nextrun = time() + ($updatePeriod * 60);
        $nextrun = date("Y-m-d H:i:s", $nextrun);
        $rawParameters = $channel->GetParameters();
        $parameters = "";
        foreach(array_keys($channel->GetParameters()) as $key) {
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
                 "true);";
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
            $channel->SetType($type);
            $channel->SetUpdatePeriod($updatePeriod);
            $params = array();
            foreach(explode("|", $parameters) as $parameter) {
                $pair = explode(",", $parameter);
                $key = urldecode($pair[0]);
                $value = urldecode($pair[1]);
                $params[$key] = $value;
            }
            $channel->SetParameters($params);
        }

        if(!isset($channel))
            return null;

        $nextrun = time() + ($channel->GetUpdatePeriod() * 60);
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
        $query = "SELECT * FROM channelprocessingjobs ORDER BY nextrun limit 1;";
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
            $channel->SetType($type);
            $channel->SetUpdatePeriod($updatePeriod);
            $params = array();
            foreach(explode("|", $parameters) as $parameter) {
                $pair = explode(",", $parameter);
                $key = urldecode($pair[0]);
                $value = urldecode($pair[1]);
                $params[$key] = $value;
            }
            $channel->SetParameters($params);
            $channels[] = $channel;
        }
        return $channels;
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
}
?>
