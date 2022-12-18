<?php

namespace Tests\Search;

use MercuryHolidays\Search\Searcher;
use PHPUnit\Framework\TestCase;

class SearcherTest extends TestCase
{
    /**
     * @var Searcher
     */
    private $searcher;
    /**
     * @array
     */
    private $testData;

    protected  function setUp():void
    {
        $this->testData = array(
            array('Hotel A', False, 1, 1, 25.80),
            array('Hotel A', False, 1, 2, 25.80),
            array('Hotel A', True, 1, 3, 25.80),
            array('Hotel A', True, 1, 4, 25.80),
            array('Hotel A', False, 1, 5, 25.80),
            array('Hotel A', False, 2, 6, 30.10),
            array('Hotel A', True, 2, 7, 35.00),


            array('Hotel B', True, 1, 1, 45.80),
            array('Hotel B', False, 1, 2, 45.80),
            array('Hotel B', True, 1, 3, 45.80),
            array('Hotel B', True, 1, 4, 45.80),
            array('Hotel B', False, 1, 5, 45.80),
            array('Hotel B', False, 2, 6, 49.00),
            array('Hotel B', False, 2, 7, 49.00)
        );
        $this->searcher = new Searcher();
    }


    protected  function tearDown():void
    {
        $this->searcher = null;
    }

    public function testCanAddPropertyToMemory()
    {
        $propertyToAdd = array(
            array('Hotel A', False, 1, 1, 25.80),
            array('Hotel B', False, 1, 2, 25.80),
            array('Hotel A', True, 1, 3, 25.80)
        );
        
        $searcher =  $this->searcher;
        $searcher->add($propertyToAdd);
        $newProperties = $searcher->allProperties();
        $this->assertIsArray($newProperties, 'Search must return type array');
        $this->assertEquals($newProperties[0]['name'], 'Hotel A');
        $this->assertEquals($newProperties[1]['name'], 'Hotel B');
    }

    // You can remove this test when it is not needed.
    // public function testSearchDoesReturnEmptyArray(): void
    // {
    //     $searcher = new Searcher();

    //     $this->expectDeprecationMessage('Method not implemented');

    //     $searcher->search(0, 0, 0);
    // }

    public function testSearchReturnResult()
    {
        $searcher =  $this->searcher;
        $result= $searcher->search(0, 0, 0);
        $this->assertIsArray($result, 'Search must return type array');
    }

    /**
     * Check if we return only available rooms
     */
    public function testAvailableRoomsMethod()
    {
        $searcher =  $this->searcher;
        $propertyToAdd = $this->testData;
        $searcher->add($propertyToAdd);
        $results= $searcher->search(1, 20, 100);

        foreach($results as $result){
            $this->assertEquals($result['available'], True);
        }
    }

    /**
     * Check if we return only rooms in budget
     */

    public function testBudgetRooms()
    {
        $searcher =  $this->searcher;
        $propertyToAdd = $this->testData;
        $searcher->add($propertyToAdd);
        $results= $searcher->search(1, 25, 40);

        foreach($results as $result){
            $this->assertGreaterThanOrEqual(25, $result['room_price']);
            $this->assertLessThanOrEqual(40, $result['room_price']);
        }

    }

    /**
     * Check if we return only adjacent rooms when room needed more than 1
     */
    public function testAdjacentRooms()
    {
        $searcher =  $this->searcher;
        $propertyToAdd = $this->testData;
        $searcher->add($propertyToAdd);
        $results= $searcher->search(2, 20, 30);
        
        $this->assertEquals($results[1]['room_number'], $results[0]['room_number']+1);
    }
}
