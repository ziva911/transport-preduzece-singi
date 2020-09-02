<?php

class Stajaliste{
    private $name;
    private $hours;	
	private $minutes;
	private $order;
	private $distance;
	
	public function __construct($name, $hours , $minutes, $distance){
		$this->order = NULL;
		$this->name = $name;
        ($hours>9)?$this->hours=$hours:$this->hours="0".(int)$hours;
        ($minutes>9)?$this->minutes=$minutes:$this->minutes="0".(int)$minutes;
		
		$this->distance = $distance;
	}

	public function __get($attrName){
		return $this->$attrName;
	}
	public function __set($attrName, $value){
		$this->$attrName = $value;
	}

	public function __toString(){
        return $this->order.','.$this->name.','.$this->hours.','.$this->minutes.','.$this->distance;
    }
	public function __toJson(){
        return '["'.$this->order.'","'.$this->name.'","'.$this->hours.'","'.$this->minutes.'","'.$this->distance.'"]';
    }

	public function ispis(){
		return 'Stajaliste broj:'.$this->order.'. Ime Stajalista: '.$this->name.'. Polazak sa ovog stajalista je u: '.$this->hours.':'.$this->minutes.'.';
	}
}

