<?php

class AdminController extends BaseAdminController
{
	public function actionIndex()
	{
        echo $this->isAdmin();

		//$this->render('index');
	}
}