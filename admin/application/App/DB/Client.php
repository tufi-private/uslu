<?php
namespace App\DB;
use Bootstrap;
use App\Lib\Debug\Debugger;
class Client
{
    private static $_instance = null;
    private $lastQuery;

    /**
     * @static
     * @return Client
     */
    public static function getInstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * default
     */
    private function __construct()
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        $dbAdapter->query('SET NAMES \'utf8\'');
    }

    /**
     * @return void
     */
    public function beginTransaction()
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        $dbAdapter->getDriver()->getConnection()->beginTransaction();

    }

    /**
     * @return void
     */
    public function rollback()
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        $dbAdapter->getDriver()->getConnection()->rollback();
    }

    /**
     *
     */
    public function commit()
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        $dbAdapter->getDriver()->getConnection()->commit();
    }

    /**
     * @param $sql
     *
     * @return \Zend\Db\Adapter\Driver\Pdo\Result
     */
    public function execute($sql)
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
//        $dbAdapter->query('SET NAMES \'utf8\'');
        $this->lastQuery = $sql;
        return $dbAdapter->getDriver()->getConnection()->execute($sql);
    }

    /**
     * @param      $sql
     * @param null $params
     *
     * @return array
     */
    public function getRows($sql, $params = null)
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
//        $dbAdapter->query('SET NAMES \'utf8\'');

        /* @var $resultSet \Zend\Db\ResultSet\ResultSet*/
        $resultSet = is_null($params)
            ? $dbAdapter->query($sql, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE)
            : $dbAdapter->query($sql, $params);
        $this->lastQuery = $sql;

        return $resultSet->toArray();
    }

    /**
     * @param      $sql
     * @param null $params
     *
     * @return null
     */
    public function getOne($sql, $params=null) {
        $resultArray = $this->getRows($sql, $params);
        if(is_array($resultArray) && !empty($resultArray)) {
            return $resultArray[0];
        }
        return null;
    }
    /**
     * @param      $sql
     * @param null $params
     *
     * @return null
     */
    public function getVal($sql, $params=null) {
        $resultArray = $this->getOne($sql, $params);
        if(is_array($resultArray) && !empty($resultArray)) {
            foreach ($resultArray as $val) {
                return $val;
            }
        }
        return null;
    }

    /**
     * @param      $sql
     * @param null $params
     *
     * @return mixed
     */
    public function insertOrUpdate($sql, $params = null)
    {
        Debugger::clog($sql, __METHOD__ . '::' . __LINE__, Debugger::INFO);
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        if (is_null($params)){
            $dbAdapter->query($sql);
        } else {
            $dbAdapter->query($sql,$params);
        }
        $this->lastQuery = $sql;
        return $dbAdapter->getDriver()->getLastGeneratedValue();
    }

    /**
     * return last executed query
     * @return string
     */
    public function getLastQuery()
    {
        return $this->lastQuery;
    }

    /**
     * @return \Zend\Db\Adapter\Platform\PlatformInterface
     */
    public function getPlatform()
    {
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $registry = Bootstrap::getRegistry();
        $dbAdapter = $registry::get('DB_ADAPTER');
        return $dbAdapter->getPlatform();
    }

    public function quote($str)
    {
        $registry = Bootstrap::getRegistry();
        /* @var $dbAdapter \Zend\Db\Adapter\Adapter */
        $dbAdapter = $registry::get('DB_ADAPTER');
       return $dbAdapter->getDriver()->getConnection()->getResource()->quote($str);
    }

    public function quoteValue($value)
    {
        return '\'' . str_replace('\'', '\\' . '\'', $value) . '\'';
    }
}
