<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class RemoveChannelProcessingJob extends ChannelProcessingJobBase {
    /**
     * Removes a channel processing job from the DAL
     * 
     * @param string $json
     * @return string 
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        //try to parse the id from the JSON
        try {
            //get the ID from the JSON
            $id = parent::ParseJSONToChannelId($json);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        try {
            //Construct a new repository
            $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        try {
            //Get the channel from the repo
            $channel = $repository->GetChannelProcessingJobById($id);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [START: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        try {
            //Delete the channel from the data store
            $repository->RemoveChannelProcessingJob($channel);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [END: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::RemoveChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>
