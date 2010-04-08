<?php
namespace Swiftriver\Core\DAL\Repositories;
class ChannelProcessingJobRepository {

    /**
     * The fully qualified type of the IAPIKeyDataContext implemting
     * data context for this repository
     * @var \Swiftriver\Core\DAL\DataContextInterfaces\IDataContext
     */
    private $dataContext;

    /**
     * The constructor for this repository
     * Accepts the fully qulaified type of the IAPIKeyDataContext implemting
     * data context for this repository
     *
     * @param string $dataContext
     */
    public function __construct($dataContext = null) {
        if(!isset($dataContext))
            $dataContext = \Swiftriver\Core\Setup::DALConfiguration()->DataContextType;
        $classType = (string) $dataContext;
        $this->dataContext = new $classType();
    }

    /**
     * Adds a new channel processing job to the data store
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function AddNewChannelProgessingJob($channel) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::AddNewChannelProgessingJob [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $dc::AddNewChannelProgessingJob($channel);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::AddNewChannelProgessingJob [Method Finished]", \PEAR_LOG_DEBUG);
    }

    /**
     * Given a Channel processing job, this method deletes it from the data store
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function RemoveChannelProcessingJob($channel) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::RemoveChannelProcessingJob [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $dc::RemoveChannelProcessingJob($channel);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::RemoveChannelProcessingJob [Method finished]", \PEAR_LOG_DEBUG);
    }

    /**
     * Given a Channel processing job, this method marks it as active
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function ActivateChannelProcessingJob($channel) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::ActivateChannelProcessingJob [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $dc::ActivateChannelProcessingJob($channel);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::ActivateChannelProcessingJob [Method finished]", \PEAR_LOG_DEBUG);
    }

    /**
     * Given a Channel processing job, this method marks it as deactive
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function DeactivateChannelProcessingJob($channel) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::DeactivateChannelProcessingJob [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $dc::DeactivateChannelProcessingJob($channel);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::DeactivateChannelProcessingJob [Method finished]", \PEAR_LOG_DEBUG);
    }

    /**
     * Given a date time, this function returns the next due
     * channel processing job.
     *
     * @param DateTime $time
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public function SelectNextDueChannelProcessingJob($time) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::SelectNextDueChannelProcessingJob [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $channel = $dc::SelectNextDueChannelProcessingJob($time);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::SelectNextDueChannelProcessingJob [Method finished]", \PEAR_LOG_DEBUG);
        return $channel;
    }

    /**
     * Given a Channel processing job, this method upadtes the data store
     * to reflect that the last run was a sucess.
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public function MarkChannelProcessingJobAsComplete($channel) {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::MarkChannelProcessingJobAsComplete [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $dc::MarkChannelProcessingJobAsComplete($channel);
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::MarkChannelProcessingJobAsComplete [Method finished]", \PEAR_LOG_DEBUG);
    }

    /**
     * Lists all the current Channel Processing Jobs in the core
     * @return \Swiftriver\Core\ObjectModel\Channel[]
     */
    public function ListAllChannelProcessingJobs() {
        $logger = \Swiftriver\Core\Setup::GetLogger();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::ListAllChannelProcessingJobs [Method invoked]", \PEAR_LOG_DEBUG);
        $dc = $this->dataContext;
        $channels = $dc::ListAllChannelProcessingJobs();
        $logger->log("Core::DAL::Repositories::ChannelProcessingJobRepository::ListAllChannelProcessingJobs [Method finished]", \PEAR_LOG_DEBUG);
        return $channels;
    }
}
?>
