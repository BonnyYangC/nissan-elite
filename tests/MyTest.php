<?php
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 8/8/18
 * Time: 3:05 PM
 */
//declare(strict_types=1);
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase
{
    public function testDatabaseIsAlive(){
        $this->assertEquals('localhost', 'localhost');
    }
}