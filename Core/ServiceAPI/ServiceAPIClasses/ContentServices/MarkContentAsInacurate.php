<?php
namespace Swiftriver\Core\ServiceAPI\ServiceAPIClasses\ContentServices;
class MarkContentAsInacurate extends ContentServicesBase {
    /**
     *
     */
    public function RunService($json) {
        //Setup the logger
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [Method invoked]", \PEAR_LOG_INFO);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        try {
            //call the parser to get the ID
            $id = parent::ParseJSONToContentID($json);
            $markerId = parent::ParseJSONToMarkerID($json);
            $reason = parent::ParseJSONToInacurateReason($json);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");

        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Parsing the JSON input]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Constructing the repository]", \PEAR_LOG_DEBUG);

        try {
            //Get the content repository
            $repository = new \Swiftriver\Core\DAL\Repositories\ContentRepository();
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Constructing the repository]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Getting the subject content]", \PEAR_LOG_DEBUG);

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
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Getting the subject content]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Setting the state to acurate]", \PEAR_LOG_DEBUG);

        //Use the state controller to change the state of the the content to acurate
        $content = \Swiftriver\Core\StateTransition\StateController::MarkContentAcurate($content);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Setting the state to acurate]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Increment source score]", \PEAR_LOG_DEBUG);

        //get the source from the content
        $source = $content->source;

        //increment the score of the source
        $source->score == $source->score - 1;

        //set the scource back to the content
        $content->source = $source;

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Increment source score]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Saving the content and source]", \PEAR_LOG_DEBUG);

        try {
            //save the content to the repo
            $repository->SaveContent($content);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Saving the content and source]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [START: Recording the transaction]", \PEAR_LOG_DEBUG);

        try {
            //get the trust log repo
            $trustLogRepo = new \Swiftriver\Core\DAL\Repositories\TrustLogRepository();

            //get the source id
            $sourceId = $content->source->id;

            //record the new entry
            $trustLogRepo->RecordSourceScoreChange($sourceId, $markerId, -1);
        }
        catch (Exception $e) {
            //get the exception message
            $message = $e->getMessage();
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [An exception was thrown]", \PEAR_LOG_DEBUG);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [$message]", \PEAR_LOG_ERR);
            $logger->log("Core::ServiceAPI::ChannelProcessingJobClasses::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);
            return parent::FormatErrorMessage("An exception was thrown: $message");
        }

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [END: Recording the transaction]", \PEAR_LOG_DEBUG);

        $logger->log("Core::ServiceAPI::ContentServices::MarkContentAsInacurate::RunService [Method finished]", \PEAR_LOG_INFO);

    }
}
?>
