<?php

namespace supercool\readtime;

use supercool\readtime\twigextensions\ReadtimeTwigExtension;

use Craft;
use craft\base\Plugin as BasePlugin;
use craft\services\Plugins;
use craft\events\PluginEvent;

use yii\base\Event;

class Plugin extends BasePlugin
{
	public static $plugin;

	public function init()
    {
    	parent::init();
        self::$plugin = $this;

        // Register twig extension
        Craft::$app->view->twig->addExtension(new ReadtimeTwigExtension());

        // Do something after we're installed
        Event::on(
            Plugins::className(),
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

    }

}