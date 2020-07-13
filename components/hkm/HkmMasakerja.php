<?php 

namespace app\components\hkm;

use app\models\Employee;


class HkmMasakerja {
    

    function __construct($n, $emp_id)
    {
        $this->n = $n;
        $this->emp_id = $emp_id;
    }

    public function getMasakerja(){
        $masakerja = Employee::find()->where(['emp_id'])->one();


    }

    public static function getDiffNow($date_param){
        $date_now = date_create(date('Y-m-d'));
        $date_target = date_create($date_param);
        $diff = date_diff($date_now, $date_target);       
        $tahun_kerja = $diff->format('%R%y');  
        
        if ($tahun_kerja>=0){
            if ($tahun_kerja %2 ==0) {//odd
                $n_masakerja = $tahun_kerja;
            }else {
                if ($tahun_kerja >2){
                    $n_masakerja = $tahun_kerja-1;
                }else {
                    $n_masakerja =0;
                }
            }
        }
        return $n_masakerja * 1000;
        /*
        The following characters are recognized in the format parameter string. Each format character must be prefixed by a percent sign (%).
        format character	Description	Example values
        %	Literal %	%
        Y	Years, numeric, at least 2 digits with leading 0	01, 03
        y	Years, numeric	1, 3
        M	Months, numeric, at least 2 digits with leading 0	01, 03, 12
        m	Months, numeric	1, 3, 12
        D	Days, numeric, at least 2 digits with leading 0	01, 03, 31
        d	Days, numeric	1, 3, 31
        a	Total number of days as a result of a DateTime::diff() or (unknown) otherwise	4, 18, 8123
        H	Hours, numeric, at least 2 digits with leading 0	01, 03, 23
        h	Hours, numeric	1, 3, 23
        I	Minutes, numeric, at least 2 digits with leading 0	01, 03, 59
        i	Minutes, numeric	1, 3, 59
        S	Seconds, numeric, at least 2 digits with leading 0	01, 03, 57
        s	Seconds, numeric	1, 3, 57
        F	Microseconds, numeric, at least 6 digits with leading 0	007701, 052738, 428291
        f	Microseconds, numeric	7701, 52738, 428291
        R	Sign "-" when negative, "+" when positive	-, +
        r	Sign "-" when negative, empty when positive	-,
        */

    } 
}

