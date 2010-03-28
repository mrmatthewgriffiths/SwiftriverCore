<?php
namespace Swiftriver\Core;
class MockDataContext implements DAL\DataContextInterfaces\IDataContext {

    public static function AddRegisteredCoreAPIKey($key) {
        return true;
    }
    public static function IsRegisterdCoreAPIKey($key) {
        return true;
    }
    public static function RemoveRegisteredCoreAPIKey($key) {
        return true;
    }
    public static function AddNewChannelProgessingJob($channel) {
    }
    public static function MarkChannelProcessingJobAsComplete($channel) {
    }
    public static function SelectNextDueChannelProcessingJob($time) {
    }
     public static function ActivateChannelProcessingJob($channel) {
    }
    public static function DeactivateChannelProcessingJob($channel) {
    }
    public static function RemoveChannelProcessingJob($channel) {
    }
}
?>
