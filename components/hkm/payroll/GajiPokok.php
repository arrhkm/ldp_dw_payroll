<?php

namespace app\components\hkm\payroll;

use DateInterval;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\TimeZone;

class GajiPokok {
    /*Upah Pekerja/Buruh harian lepas ditetapkan secara bulanan yang dibayarkan berdasarkan jumlah hari 
    kehadiran dengan perhitungan upah sehari:
    bagi Perusahaan dengan sistem waktu kerja 6 (enam) hari dalam seminggu, upah bulanan dibagi 25;
    bagi Perusahaan dengan sistem waktu kerja 5 (lima) hari dalam seminggu, upah bulanan dibagi 21.
    Dasar hukumnya adalah Peraturan Menteri Ketenagakerjaan Nomor 15 Tahun 2018 tentang Upah Minimum.

    GajiPengali Lembur = (Gaji_perjam *25(constanta work of Month))/173;
    */

    public $basic_day;
    public $office_ev;
    public $person_start;
    public $person_stop;
    public $office_start;
    public $date_now;
    public $end_office;
    public $is_dayoff;
    public $ket;
    public $doh;
    public $insentif;

    public function __construct($basic, $person_start, $person_stop, 
        $start_office, $is_dayoff, $office_ev, $date_now, $ket, $doh, $insentif)
    {
        $this->basic_day = $basic;
        
        $this->person_start = $person_start;
        $this->person_stop = $person_stop;
        $this->office_start = $start_office;
        $this->office_ev = $office_ev;
        $this->date_now = $date_now;
        $this->is_dayoff = $is_dayoff;
        $this->ket = $ket;
        $this->doh = $doh;
        $this->insentif = $insentif;

        //$this->end_office = date('Y-m-d H:i:s', strtotime("+".$office_ev."hours", strtotime($date_now." ".$start_hour)));

        
    }

    public function getBasicHour(){
        $gp_jam = $this->basic_day/$this->office_ev;
        return $gp_jam;

    }

    public function getSalaryBasic(){
        $hasil = $this->getDurationEvectifeHour() * ($this->basic_day/($this->office_ev));
        return $hasil;
    }

    public function getOfficeStart(){
        $str_office_in = $this->date_now." ".$this->office_start;
        return $str_office_in;
    }

    public function getOfficeStop(){
        $str_office_in = $this->date_now." ".$this->office_start;
        $obj_office_out = New DateTime($str_office_in);
        if ($this->office_ev >=7){
            $diffev = $this->office_ev+1;
            $diffInterval = 'PT'.$diffev.'H';
        }else {
            $diffev = $this->office_ev;
            $diffInterval = 'PT'.$diffev.'H';
        }
        $obj_office_out->add(New DateInterval($diffInterval));
        return $obj_office_out->format("Y-m-d H:i:s");
    }

    public function earlyIn(){
        if ($this->ket=="off"){
            return false;
        }
        $obj_office_start = New DateTime($this->getOfficeStart());
        $obj_person_in = New DateTime($this->person_start);
        $diff_start = $obj_person_in->diff($obj_office_start);
    
        $early_in  = $diff_start->format('%R1');
        $early = $early_in >0 ?True:False;
        return $early;
    }

    public function  lateOut(){
        if ($this->ket=="off"){
            return false;
        }
        $obj_office_stop = New DateTime($this->getOfficeStop());
        $obj_person_out = New DateTime($this->person_stop);
        $diff_out = $obj_office_stop->diff($obj_person_out);

        $late_out  = $diff_out->format('%R1');
        $lateout = $late_out >0 ?True:False;
        return $lateout;
    }

    public function getDurationEvectifeHour(){

        if ($this->ket == "off"){
            $person_ev = 0;
        }else {
            if (empty($this->person_start) || empty($this->person_stop)){
                $person_ev = 0;
            }else {

                //Jika telat 
                $obj_person_in = New DateTime($this->person_start);
                $obj_person_out = New DateTime($this->person_stop);
              
                $obj_office_start = New DateTime($this->getOfficeStart());
                $obj_office_stop = New DateTime($this->getOfficeStop());

               
                if($this->earlyIn() && $this->lateOut()){ //if ($early_in  && late_out){
                
                    //ev = $ev_office
                    $person_ev = $this->office_ev;
                }
                elseif(!$this->earlyIn() && !$this->lateOut()) {//else if (!$early_in && !late_out)
                    //ev = diff($person_in,person_out );
                    $diff_ev = $obj_person_in->diff($obj_person_out);
                    $person_ev = $diff_ev->format('%H');
                    if($this->office_ev >=7){
                        $person_ev = $person_ev -1;//-1 jam istirahat
                    }
                    
                }
                elseif($this->earlyIn() && !$this->lateOut()) {//else if ($early_in && !late_out)
                    //ev= dif(office_in,$person_out);     
                    $diff_ev = $obj_office_start->diff($obj_person_out);
                    $person_ev = $diff_ev->format('%H');
                    if($this->office_ev >=7){
                        $person_ev = $person_ev -1;//-1 jam istirahat
                    }
                    
                    
                }
                else {//else pasti datang telat dan pulang tepat waktu
                    //ev = diff(person_out, offic_out)
                    $diff_ev = $obj_person_in->diff($obj_office_stop);
                    $person_ev = $diff_ev->format('%H');

                    if($this->office_ev >=7){
                        $person_ev = $person_ev -1;//-1 jam istirahat
                    }

                    
                }     

            }
        }
        return $person_ev;
    }

    public function getOvertime(){
        if($this->ket=="off" || empty($this->person_stop || $this->getDurationEvectifeHour()<$this->office_ev)){
            return 0;
        }

        $obj_office_stop = new DateTime($this->getOfficeStop());
        $obj_person_out = New DateTime($this->person_stop);
        $diff_ot = $obj_office_stop->diff($obj_person_out);
        $ot = $diff_ot->format('%h');
        return $ot;

    }

    public function getSalaryOverTime(){
        $const_hari = 25;
        $v_gajilembur = ($this->basic_day * $const_hari)/173;
        

       
		if ($this->is_dayoff OR $this->ket=="libur") {
			//$ot=$this->getOvertime();
			//$gaji_ot=2*($this->gaji/7)*$this->getOvertime();
			if ($this->getOvertime()==8){
				//$gaji_ot=3*($this->gaji/7)*$this->getOvertime();
				$gj1=2*($v_gajilembur)*($this->getOvertime()-1);
				$gj2=3*($v_gajilembur)*1;
				$gaji_ot=$gj1+$gj2;
			}
			//elseif ($ot>=9) {
			elseif ($this->getOvertime() >=9) {
				$gaji_ot=4*($this->gaji/7)*$this->getOvertime();
				$gj1=2*($v_gajilembur)*7;
				$gj2=3*($v_gajilembur)*1;
				$gj3=4*($v_gajilembur)*($this->getOvertime()-8);
				$gaji_ot=$gj1+$gj2+$gj3;
				//$gaji_ot=100;
			}
			else {
				$gaji_ot=2*($v_gajilembur)*$this->getOvertime();
			}
			
        }elseif($this->ket=="alpha"){
            $gaji_ot = 0;
        }
         else {
			if ($this->getOvertime()<=9 AND $this->getOvertime()>0){
				$part1=1.5*($v_gajilembur);
				$part2=2*($this->getOvertime() -1)*($v_gajilembur);
				$gaji_ot=$part1+$part2;
			}
			elseif ($this->getOvertime()>9){
				$part1=1.5*($v_gajilembur);
				$part2=2*8*($v_gajilembur);
				$part3=3*($this->getOvertime()-9)*($v_gajilembur);
				$gaji_ot=$part1+$part2+$part3;
			}else {
				$gaji_ot=0;
			}
		}		
		return round($gaji_ot);
		//return $this->getOvertime();
	
    }

    public function getTmasakerja(){
        if ($this->ket=='on'){
            return MasaKerja::getMasakerja($this->doh);
        }else{
            return 0;
        }
    }

    public function getTelat(){
        if ($this->ket=="off" || empty($this->person_start) || empty($this->person_stop)){
            $telat = "00:00:00";
        }else {
            $obj_p_s = New DateTime($this->person_start);
            $obj_o_s = New DateTime("{$this->date_now}  {$this->office_start}"); 

            $diff_start = $obj_p_s->diff($obj_o_s);
        
            $late  = $diff_start->format('%R1');
            $late_in = $late < 0 ?True:False;
            if ($late_in) {
                //$late_h = $diff_start->format('%H');
                //$late_m = $diff_start->format('%m');
                $telat =  $diff_start->format('%H:%I:%S');
            }else{
                $telat = '00:00:00';
            }
        }
        
        return  $telat;
    }

    public function getPotonganTelat(){
        $potongan = 0;
        $x = $this->getTelat();
        $y = explode(":", $x);
        if ($y[0]==0){
            if ($y[1]>5 && $y[1]<=25){
                //Potongan 1 jam ;
                $potongan = $this->getBasicHour();
            }elseif($y[1]>=26){
                //potongan 2 * jam ;
                $potongan = $this->getBasicHour()*2;
            }
        }elseif($y[0]==1){
            //potongan 2 jam;
            $potongan = $this->getBasicHour()*2;
        }elseif($y[0]>=2){
            $potongan = $this->getBasicHour()*$y[0];
        }else {
            $potongan = 0;
        }
        
       return $potongan;
    }
    public function getSalaryDay(){
        $x = ($this->getSalaryBasic()+$this->getSalaryOverTime()+$this->getTmasakerja()+$this->getInsentif())-$this->getPotonganTelat();
        return $x;
    }

    public function getInsentif(){
        if ($this->ket == 'alpha'){
            return 0;
        }else{
            return $this->insentif;
        }
        
    }

    
    
}