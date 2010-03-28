<?php
namespace Swiftriver\Core\DAL\DataContextInterfaces;
interface IChannelProcessingJobDataContext {

    /**
     * Adds a new channel processing job to the data store
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function AddNewChannelProgessingJob($channel);

    /**
     * Given a date time, this function returns the next due
     * channel processing job.
     *
     * @param DateTime $time
     * @return \Swiftriver\Core\ObjectModel\Channel
     */
    public static function SelectNextDueChannelProcessingJob($time);

    /**
     * Given a Channel processing job, this method upadtes the data store
     * to reflect that the last run was a sucess.
     *
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function MarkChannelProcessingJobAsComplete($channel);

    /**
     * Given a Channel processing job, this method marks it as active
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function ActivateChannelProcessingJob($channel);

    /**
     * Given a Channel processing job, this method marks it as deactive
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function DeactivateChannelProcessingJob($channel);


    /**
     * Given a Channel processing job, this method deletes it from the data store
     * @param \Swiftriver\Core\ObjectModel\Channel $channel
     */
    public static function RemoveChannelProcessingJob($channel);
}
?>
