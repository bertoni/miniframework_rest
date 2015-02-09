<?php
/**
 * File that brings the class of database connection
 *
 * PHP Version 5.3
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
namespace helper;
/**
 * Class of database connection
 *
 * @category Class
 * @package  Lib\helper
 * @author   Arnaldo Bertoni <arnaldo4321@hotmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.linkedin.com/pub/arnaldo-bertoni-junior/58/7aa/213
 */
class ConnectionDB
{
    /**
     * Defines the transaction use
     *
     * @var    boolean
     * @access private
     */
    private $_transaction = false;
    /**
     * Counter of active transactions
     *
     * @var    integer
     * @access private
     */
    private $_active_transactions = 0;
    /**
     * PDO object of database connection
     *
     * @var    PDO
     * @access private
     */
    private $_pdo;

    /**
     * Function that constructs the connection
     *
     * @param string $conn   {Connection string}
     * @param string $user   {Connection user}
     * @param string $pass   {Connection pass}
     * @param array  $option {Connection options}
     *
     * @return void
     * @access public
     */
    public function __construct($conn, $user, $pass, array $option = null) 
    {
        try {
            $this->_pdo = new \PDO($conn, $user, $pass, $option);
        } catch (PDOException $e) {
            echo 'Error!: ' . $e->getMessage() . '<br/>';
        }
    }

    /**
     * Function that prepares a query to be executed
     *
     * @param string $query {Query in SQL format}
     *
     * @return PDOStatement
     * @access public
     */
    public function prepareQuery($query)
    {
        return $this->_pdo->prepare($query);
    }

    /**
     * Function that begins a transaction
     *
     * @return void
     * @access public
     */
    public function beginTransaction()
    {
        $this->_active_transactions++;
        if (!$this->_transaction) {
            $this->_pdo->beginTransaction();
            $this->_transaction = true;
        }
    }

    /**
     * Function that checks if exists a active transaction
     *
     * @return boolean
     * @access public
     */
    public function inTransaction()
    {
        return $this->_transaction;
    }

    /**
     * Function that commit the connection
     *
     * @return void
     * @access public
     */
    public function commit()
    {
        if ($this->_active_transactions == 1) {
            $this->_pdo->commit();
            $this->_transaction = false;
        }
        $this->_active_transactions--;
    }

    /**
     * Function that returns the data in the connection
     *
     * @return void
     * @access public
     */
    public function rollBack()
    {
        if ($this->_active_transactions == 1) {
            $this->_pdo->rollBack();
            $this->_transaction = false;
        }
        $this->_active_transactions--;
    }

    /**
     * Function that recovers the last id created in the database
     *
     * @return integer
     * @access public
     */
    public function getLastId()
    {
        return $this->_pdo->lastInsertId();
    }

}