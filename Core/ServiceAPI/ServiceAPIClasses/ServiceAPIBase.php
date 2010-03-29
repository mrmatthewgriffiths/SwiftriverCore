<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses;
class ServiceAPIBase {
    /**
     * Returns the given error in standard JSON format
     * @param string $error
     * @return string
     */
    protected function FormatErrorMessage($error) {
        return '{"error":"'.str_replace('"', '\'', $error).'"}';
    }

    /**
     * Returns the given message in standard JSON format
     * @param string $message
     * @return string
     */
    protected function FormatMessage($message) {
        return '{"message":"'.str_replace('"', '\'', $message).'"}';
    }

    /**
     * Checks to see if the API key provided matches the configured
     * API Keys for this Core install
     * @param string $key
     * @return bool
     */
    public function CheckKey($key) {
        $keyRepository = new \Swiftriver\Core\DAL\Repositories\APIKeyRepository();
        return $keyRepository->IsRegisterdCoreAPIKey($key);
    }
}
?>
