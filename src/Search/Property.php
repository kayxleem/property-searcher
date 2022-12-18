<?php

namespace MercuryHolidays\Search;

class Property
{
    /**
     * @var array
     */
    public array $properties;

    /**
     * Property constructor.
     */
    public function __construct()
    {
        $this->properties = [];
    }


    /**
     * creates the roomObject
     * @param $roomDetails
     * @return void
     */
    public function createRow($roomDetails): void
    {

        $roomObject = [
            'name' => $roomDetails[0],
            'available' => $roomDetails[1],
            'floor' => $roomDetails[2],
            'room_number' => $roomDetails[3],
            'room_price' => $roomDetails[4]
        ];

        $this->addtoHotelRoom($roomObject);
    }

    /**
     * Adds rooms to property
     * @param $roomObject
     * @return void
     */
    public function addtoHotelRoom($roomObject): void
    {
        array_push($this->properties, $roomObject);
    }

    /**
     * Adds rooms to property
     * @param $room
     * @return bool
     */
    public function isRoomAvailable(array $room)
    {
        if(empty($room)){
            return false;
        }
        if($room['available']==True){
            return true;
        }else{
            return false;
        }
        return false;
    }

    /**
     * Check if room is in budget
     * @param $room
     * @param float $min
     * @param float $max
     * @return bool
     */
    public function isRoomInBudget(array $room,$min, $max)
    {
        if(empty($room)){
            return false;
        }
        if($room['room_price'] >= $min && $room['room_price'] <= $max){
            return true;
        }else{
            return false;
        }
        return false;
    }
}
