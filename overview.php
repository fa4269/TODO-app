<?php

//Class overview is used to track the total number of tasks contained in all 4 task objects

class overview {
    private $totalTasks;

    public function count($obj1, $obj2, $obj3, $obj4){
        $this->totalTasks = $obj1->taskCount + $obj2->taskCount + $obj3->taskCount + $obj4->taskCount;

    }
    public function getCount(){
        return $this->totalTasks;
    }
}

?>
