<?php
namespace Swiftriver\Core\DAL\APIKey;
class APIKeyRepository {

    /**
     * The fully qualified type of the IAPIKeyDataContext implemting
     * data context for this repository
     * @var string
     */
    private $dataContext;

    /**
     * The constructor for this repository
     * Accepts the fully qulaified type of the IAPIKeyDataContext implemting
     * data context for this repository
     *
     * @param string $dataContext
     */
    public function __construct($dataContext) {
        $this->dataContext = $dataContext;
    }

    /**
     * Checks that the provided Key is registed against this install
     * of the Core
     *
     * @param string $key
     */
    public function IsRegisterdCoreAPIKey($key) {
        $dc = new $this->dataContext();
        return $dc::IsRegisterdCoreAPIKey($key);
    }
}
?>
