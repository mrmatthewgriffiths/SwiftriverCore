<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses;
class ServiceAPIBase {
    /**
     * Returns the given error in standard JSON format
     * @param string $error
     * @return string
     */
    protected function FormatErrorMessage($error) {
        return '[{"error":"'.str_replace('"', '\'', $error).'"}]';
    }

    /**
     * Returns the given message in standard JSON format
     * @param string $message
     * @return string
     */
    protected function FormatMessage($message) {
        return '[{"message":"'.str_replace('"', '\'', $message).'"}]';
    }


}
?>
