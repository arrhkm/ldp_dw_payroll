<?php 
namespace app\components;

use yii\base\Component;

class Leave extends Component{
    public $start;
    public $end;


    function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getDurationJam(){
        $tgl1 = date_create($this->start);
        $tgl2 = date_create($this->end);
        $tgl_diff = date_diff($tgl1, $tgl2);
        return $tgl_diff->h;
    }
}
