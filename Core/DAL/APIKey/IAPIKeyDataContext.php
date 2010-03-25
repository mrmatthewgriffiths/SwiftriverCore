<?php
namespace Swiftriver\Core\DAL\APIKey;
interface IAPIKeyDataContext {
    /**
     * Checks that the given API Key is registed for this
     * Core install
     * @param string $key
     * @return bool
     */
    public static function IsRegisterdCoreAPIKey($key);
}
?>
