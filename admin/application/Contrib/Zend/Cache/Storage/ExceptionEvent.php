<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Cache
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

namespace Zend\Cache\Storage;

use ArrayObject,
    Exception;

/**
 * @category   Zend
 * @package    Zend_Cache
 * @subpackage Storage
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class ExceptionEvent extends PostEvent
{
    /**
     * The exception to be thrown
     *
     * @var Exception
     */
    protected $exception;

    /**
     * Throw the exception or use the result
     *
     * @var boolean
     */
    protected $throwException = true;

    /**
     * Constructor
     *
     * Accept a target and its parameters.
     *
     * @param  string      $name
     * @param  Adapter     $storage
     * @param  ArrayObject $params
     * @param  mixed       $result
     * @param  Exception   $exception
     * @return void
     */
    public function __construct($name, Adapter\AdapterInterface $storage, ArrayObject $params, & $result, Exception $exception)
    {
        parent::__construct($name, $storage, $params, $result);
        $this->setException($exception);
    }

    /**
     * Set the exception to be thrown
     *
     * @param  Exception $exception
     * @return ExceptionEvent
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
        return $this;
    }

    /**
     * Get the exception to be thrown
     *
     * @return Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * Throw the exception or use the result
     *
     * @param  boolean $flag
     * @return ExceptionEvent
     */
    public function setThrowException($flag)
    {
        $this->throwException = (bool) $flag;
        return $this;
    }

    /**
     * Throw the exception or use the result
     *
     * @return boolean
     */
    public function getThrowException()
    {
        return $this->throwException;
    }
}
