<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class DeactivateChannelProcessingJob extends ChannelProcessingJobBase {
    /**
     * Deactivates the channel processing job
     *
     * @param string $json
     * @return string $json
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);
        
        //try to parse the id from the JSON
        try {
            //get the ID from the JSON
            $id = parent::ParseJSONToChannelId($json);
        }
        catch (InvalidArgumentException $e) {
            //if there was an error in the JSON
            //get the message
            $message = $e->getMessage();
            //return it to the client
            return parent::FormatErrorMessage("There were errors in you JSON. Please review the API documentation and try again. Inner message: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        //Get the channel from the repo
        $channel = $repository->GetChannelProcessingJobById($id);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [START: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        //set the active flag to false
        $channel->active = false;
        
        //save the channel back to the repo
        $repository->SaveChannelProgessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [END: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::DeactivateChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>