<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

class CountryController extends \yii\rest\ActiveController
{

	public $modelClass = 'api\modules\v1\models\Country';

	public function actionQuery()
	{
		# code...
		$params = $_REQUEST;
		if ( isset($params['code']) ) {
			# code...
			# 
		}
	}

}
