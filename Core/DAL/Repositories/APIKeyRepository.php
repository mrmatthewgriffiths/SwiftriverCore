<?php
namespace Swiftriver\Core\DAL\Repositories;
class APIKeyRepository {

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
     * Checks that the provided Key is registed against this install
     * of the Core
     * Returns true on sucess
     *
     * @param string $key
     * @return bool
     */
    public function IsRegisterdCoreAPIKey($key) {
        $dc = $this->dataContext;
        return $dc::IsRegisterdCoreAPIKey($key);
    }

    /**
     * Adds a new API key to the list of registered API Keys
     * Returns true on sucess
     *
     * @param string $key
     * @return bool
     */
    public function AddRegisteredAPIKey($key) {
        $dc = $this->dataContext;
        return $dc::AddRegisteredCoreAPIKey($key);
    }

    /**
     * Removes a registered API key
     * Returns true on sucess
     *
     * @param string $key
     * @return bool
     */
    public function RemoveRegisteredAPIKey($key){
        $dc = $this->dataContext;
        return $dc::RemoveRegisteredCoreAPIKey($key);
    }
}
?>
