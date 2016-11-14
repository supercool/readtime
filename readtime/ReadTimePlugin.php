<?php

namespace Craft;

/**
 * ActivityLogger by Supercool
 *
 * @package   ActivityLogger
 * @author    Naveed Ziarab
 * @copyright Copyright (c) 2016, Supercool Ltd
 * @link      http://www.supercooldesign.co.uk
 */

class ReadTimePlugin extends BasePlugin
{

	/**
	 * Returns the plugin's name
	 * 
	 * @return string
	 */
	public function getName()
	{
		return Craft::t('Read Time');
	}

	/**
	 * Plugin's version number
	 * 
	 * @return string
	 */
	public function getVersion()
	{
		return "1.0.0";
	}

	/**
	 * Plugin's schema version
	 *
	 * @return string 
	 */
	public function getSchemaVersion()
	{
		return "1.0.0";
	}

	/**
	 * Plugin's developer name
	 * 	
	 * @return string 
	 */
	public function getDeveloper()
	{
		return "Supercool Ltd";
	}

	/**
	 * Plugin's developer's url
	 * 
	 * @return string 
	 */
	public function getDeveloperUrl()
	{
		return "http://supercooldesign.co.uk";
	}

	/**
	 * Register our twig extension
	 *
	 * @return Object
	 */
	public function addTwigExtension()  
	{
	    Craft::import('plugins.readtime.twigextensions.ReadTimeTwigExtension');

	    return new ReadTimeTwigExtension();
	}

}