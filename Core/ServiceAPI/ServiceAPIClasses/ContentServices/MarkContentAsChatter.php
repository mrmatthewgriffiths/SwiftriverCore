<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ContentServices;
class MarkContentAsChatter extends ContentServicesBase {
    /**
     *
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        try {
            //call the parser to get the ID
            $id = parent::ParseJSONToContentID($json);
            $markerId = parent::ParseJSONToMarkerID($json);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");

        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [START: Constructing the repository]", \PEAR_LOG_DEBUG);

        try {
            //Get the content repository
            $repository = new \Swiftriver\Core\DAL\Repositories\ContentRepository();
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [END: Constructing the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [START: Getting the subject content]", \PEAR_LOG_DEBUG);

        try {
            //get the content array for the repo
            $contentArray = $repository->GetContent(array($id));

            //try and get the first item
            $content = reset($contentArray);

            //check that its not null
            if(!isset($content) || $content == null) {
                throw new Exception("No content was returned for the ID: $id");
            }
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [END: Getting the subject content]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [START: Setting the state to acurate]", \PEAR_LOG_DEBUG);

        //Use the state controller to change the state of the the content to acurate
        $content = \Swiftriver\Core\StateTransition\StateController::MarkContentChatter($content);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [END: Setting the state to acurate]", \PEAR_LOG_DEBUG);

        //Note that with chatter, we do not make any adjustment to the source

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [START: Saving the content and source]", \PEAR_LOG_DEBUG);

        try {
            //save the content to the repo
            $repository->SaveContent($content);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsChatter::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [END: Saving the content and source]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsChatter::RunService [Method finished]", \PEAR_LOG_INFO);
    }
}
?>
