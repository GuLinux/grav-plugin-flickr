<?php

namespace Grav\Plugin\Shortcodes;
require_once(__DIR__.'/../classes/FlickrCommons.php');
use Grav\Plugin\Flickr\FlickrCommons;
use Grav\Common\Utils;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Grav\Plugin\Flickr\FlickrAPI;
use Grav\Plugin\Flickr\FlickrAPIException;
use Grav\Plugin\Flickr\Photoset;

class FlickrPhotoShortcode extends Shortcode
{
    public function init()
    {
        $this->shortcode->getHandlers()->add('flickr-photo', function(ShortcodeInterface $sc) {
            $content = $sc->getContent();
            $id = $sc->getParameter('id', '');
            $api = new FlickrAPI();
            $params = array_merge(FlickrCommons::defaultParams(), $sc->getParameters());
            try {
                $photo = $api->photo($id );
                $output = $this->twig->processTemplate('partials/flickr-photo.html.twig', [
                    'photo' => $photo,
                    'params' => $params,
                ]);

                return $output;
            } catch(FlickrAPIException $e) {
                return $e->getMessage();
            }
        });
    }
}
