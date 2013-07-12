<?php

class front_portfolioController extends Base_Controller {

	public function indexAction() {

		$this->view->title = 'Portfolio - Floris Thijs - Visual Effects Artist';
		$this->view->styles = '<link rel="stylesheet" href="/css/portfolio.css" />';
		$this->view->scripts = '<link rel="stylesheet" type="text/css" href="/assets/shadowbox/shadowbox.css">
	<script type="text/javascript" src="/assets/shadowbox/shadowbox.js"></script>';

		return $this;

	}

}