<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class ActivateChannelProcessingJob extends ChannelProcessingJobBase {
    /**
     * Activates the channel processing job
     *
     * @param string $json
     * @return string $json
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

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

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        //Construct a new repository
        $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [START: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        //Get the channel from the repo
        $channel = $repository->GetChannelProcessingJobById($id);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [END: Getting the channel from the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [START: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        //set the active flag to true
        $channel->active = true;

        //save the channel back to the repo
        $repository->SaveChannelProgessingJob($channel);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [END: Marking channel processing job as inactive and saving to the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ActivateChannelProcessingJob::RunService [Method finished]", \PEAR_LOG_INFO);

        //return an OK messagae
        return parent::FormatMessage("OK");
    }
}
?>