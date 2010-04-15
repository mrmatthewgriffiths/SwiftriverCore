<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ChannelProcessingJobClasses;
class ListAllChannelProcessingJobs extends ChannelProcessingJobBase {
    /**
     * List all Channel Processing Jobs in the Data Store
     *
     * @param string $json
     * @return string $json
     */
    public function RunService() {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [START: Constructing Repository]", \PEAR_LOG_DEBUG);

        try {
            //Construct a new repository
            $repository = new \Swiftriver\Core\DAL\Repositories\ChannelProcessingJobRepository();
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [END: Constructing Repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [START: Listing all processing jobs]", \PEAR_LOG_DEBUG);

        try {
            //Get all the channel processing jobs
            $channels = $repository->ListAllChannelProcessingJobs();
        }
        catch (Exception $e) {
            //get the exception message 
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [END: Listing all processing jobs]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [START: Parsing channel processing jobs to JSON]", \PEAR_LOG_DEBUG);

        try {
            //Parse the JSON input
            $json = parent::ParseChannelsToJSON($channels);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [END: Parsing channel processing jobs to JSON]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::ListAllChannelProcessingJobs::RunService [Method finished]", \PEAR_LOG_INFO);

        //return the channels as JSON
        return $json;
    }
}
?>
