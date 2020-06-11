<?php 
namespace app\models;
use Yii;

class UbahGaji extends \yii\base\Model 
{
	public $gaji_lama;
	public $gaji_baru;

	public function rules()
	{
		return [
			[['gaji_lama', 'gaji_baru'], 'required'],
		];
	}

	public function attributeLabels()
    {
        return [
            'gaji_lama' => 'Gaji Lama',
            'gaji_baru' => 'Gaji Baru',
            
        ];
    }
}