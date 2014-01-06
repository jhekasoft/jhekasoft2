<?php

class SystemController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionAbout()
	{
		$this->render('about');
	}
}