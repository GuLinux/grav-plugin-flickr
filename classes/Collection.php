<?php

namespace Grav\Plugin\Flickr;
require_once(__DIR__.'/Photoset.php');
use Grav\Plugin\Flickr\Photoset;

use Grav\Common\Grav;

class Collection
{
    private $info;
    private $collections;
    private $sets;
    
    public function __construct($tree, $api)
    {
        $this->info = $tree;
        $this->collections = [];
        $this->sets = [];
        dump($tree);
        if(is_array($tree['collection'])) {
            foreach($tree['collection'] as $collection) {
                $this->collections[] = new Collection($collection, $api);
            }
        }
        if(is_array($tree['set'])) {
            foreach($tree['set'] as $set) {
                $this->sets[] = $api->photoset($set['id'], []);
            }
        }
        dump($this->collections);
        dump($this->sets);
    }

    
    public function title() {
        return $this->info["title"];
    }
    public function description() {
        return $this->info["description"];
    }
    
    public function collections() {
        return $this->collections;
    }
    
    public function sets() {
        return $this->sets;
    }
}
