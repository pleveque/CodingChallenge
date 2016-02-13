<?php


namespace Suggestions\Model;

class CityFormat
{  
    public $name;
    public $latitude;
    public $longitude;
    public $score;
    
    public function __construct($name, $latitude, $longitude, $score)
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->score = $score;
    }
}