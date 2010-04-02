<?php
namespace Swiftriver\Core\DAL\DataContextInterfaces;
/**
 * This interfaces pulls together all the components of the
 * DAL into one IDataContext interface that can then be
 * implemented by any type of data store and passed to any
 * of the repositories.
 */
interface IDataContext extends 
    IAPIKeyDataContext,
    IChannelProcessingJobDataContext,
    IContentDataContext {

}
?>
