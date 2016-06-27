<?php

namespace Grav\Plugin\Shortcodes;
require_once(__DIR__.'/../classes/FlickrAPI.php');
use Grav\Common\Utils;
use Thunder\Shortcode\Shortcode\ShortcodeInterface;
use Grav\Plugin\Flickr\FlickrAPI;
use Grav\Plugin\Flickr\FlickrAPIException;
use Grav\Plugin\Flickr\Photoset;

class FlickrCollectionShortcode extends Shortcode
{
    public function init()
    {
        $this->shortcode->getHandlers()->add('flickr-collection', function(ShortcodeInterface $sc) {
            $content = $sc->getContent();
            $id = $sc->getParameter('id', '');
            $api = new FlickrAPI();
            $params = array_merge(['display-format-photo' => 's', 'display-format-photo-lightbox' => 'z'], $sc->getParameters());
            try {
                $collection = $api->collection($id );
                $output = $this->twig->processTemplate('partials/flickr-collection.html.twig', [
                    'collection' => $collection,
                    'params' => $params,
                ]);

                return $output;
            } catch(FlickrAPIException $e) {
                return $e->getMessage();
            }
        });
    }
}
 
