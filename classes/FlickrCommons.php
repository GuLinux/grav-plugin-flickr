<?php
namespace Grav\Plugin\Flickr;
require_once(__DIR__.'/FlickrAPI.php');

class FlickrCommons {
    static function defaultParams() {
      return [
        'display-format-photo' => 's',
        'display-format-photo-lightbox' => 'z',
        'photoset-title-tag' => 'h4',
        'photoset-description-tag' => 'h5',
        'collection-title-tag' => 'h3',
        'collection-description-tag' => 'h5'
      ];
    }
}
