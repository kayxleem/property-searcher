<?php

namespace MercuryHolidays\Search;

class Searcher extends Property
{
    public $testData;

    /**
     * Adds collect Inputs
     * @param array $properties
     * @return void
     */
    public function add(array $properties): void
    {
        foreach($properties as $property){
            $this->createRow($property);
        }
        // TODO: Implement me
    }

    /**
     * Performs Search
     * @param array $roomsRequired
     * @param int $minimum
     * @param int $maximum
     * @return array
     */

    public function search(int $roomsRequired, $minimum, $maximum): array
    {
        $availableRooms= [];
        $budgetRooms = [];
        $rooms= $this->properties;
        $result= [];
        foreach($rooms as $room){
            if($this->isRoomAvailable($room) == true){
                array_push($availableRooms,$room);
            }
        }

        foreach ($availableRooms as $availableRoom){
            if($this->isRoomInBudget($availableRoom, $minimum, $maximum) == true){
                array_push($budgetRooms,$availableRoom);
            }
        }

        if($roomsRequired == 1){
            $result= $budgetRooms;
        }elseif($roomsRequired !=0 && $roomsRequired > 1){
            $result= $this->getAdjacentRooms($budgetRooms,$roomsRequired);
        }else{
            return $result;
        }
        return $result;
        //throw new \Exception('Method not implemented');
    }
    

    /**
     * Retunns All properties
     * @return array
     */
    public function allProperties(): array
    {
        return $this->properties;
    }

    /**
     * filter inputs to adjacent Properties
     * @param array $rooms
     * @param int $roomsRequired
     * @return array
     */
    private function getAdjacentRooms(array $rooms,$roomsRequired): array
    {
        $nextroomNumber=0;
        $lastroomFloor=0;
        $numberOfRooms=0;
        $adjacentRooms= [];

        foreach($rooms as $room){
            if(empty($adjacentRooms)){
                array_push($adjacentRooms,$room);
                $nextroomNumber=$room['room_number']+1;
                $lastroomFloor=$room['floor'];
                $numberOfRooms++;
            }elseif($lastroomFloor==$room['floor'] && $nextroomNumber == $room['room_number'] && $numberOfRooms !=$roomsRequired){
                array_push($adjacentRooms,$room);
            }
        }

        return $adjacentRooms;
    }

    
}
