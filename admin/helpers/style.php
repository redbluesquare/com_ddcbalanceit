<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class DdcbalanceitHelpersStyle
{
	public static function load()
	{
		$document = JFactory::getDocument();

		//stylesheets
		//$document->addStylesheet(JURI::base().'components/com_ddcbalanceit/assets/css/style.css');
		$document->addStyleSheet('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css');

		//javascripts
		$document->addScript(JURI::base().'components/com_ddcbalanceit/assets/js/angular.js');

	}
}