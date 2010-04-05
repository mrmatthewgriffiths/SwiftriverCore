<?php
namespace Swiftriver\Core\DAL\Repositories;
class ContentRepository {
    /**
     * The fully qualified type of the IContentDataContext implemting
     * data context for this repository
     * @var \Swiftriver\Core\DAL\DataContextInterfaces\IDataContext
     */
    private $dataContext;

    /**
     * The constructor for this repository
     * Accepts the fully qulaified type of the IContentDataContext implemting
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
     * Given a set of content items, this method will persist
     * them to the data store, if they already exists then this
     * method should update the values in the data store.
     *
     * @param \Swiftriver\Core\ObjectModel\Content[] $content
     */
    public function SaveContent($content) {
        $dc = new $this->dataContext();
        $dc::SaveContent($content);
    }

    /**
     * Given an array of content is's, this function will
     * fetch the content objects from the data store.
     *
     * @param string[] $ids
     * @return \Swiftriver\Core\ObjectModel\Content[]
     */
    public static function GetContent($ids) {
        $dc = new $this->dataContext();
        $dc::GetContent($content);
    }

    /**
     * Given an array of content items, this method removes them
     * from the data store.
     * @param \Swiftriver\Core\ObjectModel\Content[] $content
     */
    public static function DeleteContent($content) {
        $dc = new $this->dataContext();
        $dc::DeleteContent($content);
    }
}
?>
