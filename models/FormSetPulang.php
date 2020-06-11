<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class FormSetPulang extends Model
{
   
    
    public $date_set;
    public $jam_pulang;
   

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['date_set', 'jam_pulang'], 'required'],
            // rememberMe must be a boolean value
            ['date_set', 'date'],
          
        ];
    }
}