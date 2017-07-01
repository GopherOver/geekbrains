<?php

require_once ('../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

class ProductModelTest extends TestCase
{
    use TestCaseTrait;

    // only instantiate pdo once for test clean-up/fixture load
    static private $pdo = null;

    // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
    private $conn = null;


    final public function getConnection()
    {
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO( "mysql:dbname=l5.gb;host=localhost;charset=utf8", "root", "1" );
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, "l5.gb");
        }

        return $this->conn;
    }

    /**
     * Returns the test dataset.
     * @return \PHPUnit\DbUnit\DataSet\IDataSet
     */
    protected function getDataSet()
    {
        // TODO: Implement getDataSet() method.
        return $this->createFlatXMLDataSet(dirname(__FILE__).'/product.xml');
    }

    public function testGetProducts ()
    {
        $sql = "SELECT * FROM `product`";
        $statement = $this->getConnection()->getConnection()->query($sql);
        $result = $statement->fetchAll();
        $this->assertArrayHasKey('name', $result[0]);
        $this->assertArrayHasKey('price', $result[0]);
        $this->assertArrayHasKey('id', $result[0]);
    }

    /**
     * @dataProvider providerGetProductByID
     */
    public function testGetProductByID($id = 1)
    {
        $sql = "SELECT * FROM `product` WHERE `id` = " . $id;
        $statement = $this->getConnection()->getConnection()->query($sql);
        $result = $statement->fetch();
        $this->assertArrayHasKey('name', $result);
    }

    public function providerGetProductByID()
    {
        return [
            [1],
            [2],
          //  [3], // заведомо ложный ID
        ];
    }
}
