<?php

class overview {
    private $totalTasks;

    function count($obj1, $obj2, $obj3, $obj4){
        $this->totalTasks = $obj1->taskCount + $obj2->taskCount + $obj3->taskCount + $obj4->taskCount;

    }
    function getCount(){
        return $this->totalTasks;
    }
}

?>
