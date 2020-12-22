<?php

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @var null Model
     */
    public $model = null;

    /**
     * Whenever controller is created, open a database connection too and load "the model".
     */
    function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
          $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone = '+02:00'");

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    /**
     * Loads the "model".
     * @return object model
     */
    public function loadModel()
    {
        if (isset($_SESSION['role'])) {
            switch ($_SESSION['role']) {
                case 'admin':
                    require APP . 'model/admin.php';
                    break;
                case 'manager':
                    require APP . 'model/manager.php';
                    break;
                case 'supervisor':
                    require APP . 'model/supervisor.php';
                    break;
                case 'customer':
                    require APP . 'model/customer.php';
                    break;
                case 'crmmanager':
                    require APP . 'model/crmmanager.php';
                    break;
                case 'teamleader':
                    require APP . 'model/teamleader.php';
                    break;
                case 'support':
                      require APP . 'model/support.php';
                      break;
                case 'operator':
                    require APP . 'model/operator.php';
                    break;
                default:
                    require APP . 'model/model.php';
                    break;
            }
        }else{
            require APP . 'model/model.php';
        }


        // create new "model" (and pass the database connection)
        $this->model = new Model($this->db);
    }
}
