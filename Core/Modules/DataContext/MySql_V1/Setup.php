<?php
namespace Swiftriver\Core\Modules\DataContext\MySql_V1;
class Setup {
    /**
     * @var MySQLAPIKeyDataContextConfigurationHandler
     */
    public static $Configuration;

    public function __construct() {
        //TODO: Logging

        self::$Configuration = new DataContextConfigurationHandler(dirname(__FILE__)."/Configuration.xml");

        $url = (string)Setup::$Configuration->DataBaseUrl;
        $username = (string)Setup::$Configuration->UserName;
        $password = (string)Setup::$Configuration->Password;
        //Open a connection to the DB server
        $mysql = mysql_connect($url, $username, $password);

        //Select the databse
        $database = (string)Setup::$Configuration->Database;
        $bool = mysql_select_db($database, $mysql);
        $error = mysql_error($mysql);
        
        //Create the API keys table
        $query = "CREATE TABLE IF NOT EXISTS coreapikeys (apikey VARCHAR( 50 ) NOT NULL);";
        $bool = mysql_query($query, $mysql);
        $error = mysql_error($mysql);

        //Create the channelprocessingjobs table
        $query = "CREATE TABLE IF NOT EXISTS channelprocessingjobs (
                    id LONGTEXT NOT NULL ,
                    type VARCHAR( 50 ) NOT NULL ,
                    updateperiod INT NOT NULL ,
                    lastrun DATE NULL ,
                    lastsucess DATE NULL ,
                    timesrun INT NOT NULL,
                    active BIT NOT NULL
                    )";
        $bool = mysql_query($query, $mysql);
        $error = mysql_error($mysql);
        mysql_close($mysql);
    }
}
$setup = new Setup();
?>
