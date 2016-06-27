<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;


class FlickrPlugin extends Plugin
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onShortcodeHandlers' => ['onShortcodeHandlers', 0],
//            'onTwigExtensions' => ['onTwigExtensions', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }
    
        public function onPluginsInitialized()
    {
        $this->config = $this->grav['config'];
        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0],
        ]);
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

//    public function onTwigExtensions()
//    {
//        require_once(__DIR__ . '/twig/ShortcodeUITwigExtension.php');
//        $this->grav['twig']->twig->addExtension(new FlickrTwigExtension());
//    }

    /**
     * Initialize configuration
     */
    public function onShortcodeHandlers()
    {
        $this->grav['shortcode']->registerAllShortcodes(__DIR__.'/shortcodes');
    }
    
    public function onPageInitialized()
    {
        $this->grav['assets']->addCss('plugin://flickr/css/flickr.css');
    }

}
