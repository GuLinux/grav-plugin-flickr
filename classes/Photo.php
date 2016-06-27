<?php

namespace Grav\Plugin\Flickr;

use Grav\Common\Grav;

class Photo
{
    private $info;
    
    public function __construct($info)
    {
        $this->info = $info;
    }
    
    public function id() {
        return $this->info['id'];
    }

    public function title() {
        return $this->content($this->info['title']);
    }
    
    public function datetaken() {
        return $this->content($this->info['datetaken']);
    }
    
    public function url($format) {
        if($format == 'o' && $this->info['originalsecret']) {
            return 'https://farm' . $this->info['farm'] . '.staticflickr.com/' . $this->info['server'] . '/' . $this->info['id'] . '_' . $this->info['originalsecret'] . '_o.' . $this->info['originalformat'];
        }
        if(in_array($format, ['s', 'q', 't', 'm', 'n', 'z', 'c', 'b', 'h', 'k'])) {
            return 'https://farm' . $this->info['farm'] . '.staticflickr.com/' . $this->info['server'] . '/' . $this->info['id'] . '_' . $this->info['secret'] . '_' . $format . '.jpg';
        }
        return 'https://farm' . $this->info['farm'] . '.staticflickr.com/' . $this->info['server'] . '/' . $this->info['id'] . '_' . $this->info['secret'] . '.jpg';
    }
    
    public function flickrPage() {
        return 'https://www.flickr.com/photos/' . $this->info['ownername'] . '/' . $this->info['id'];
    }
    
    public function description() {
        return $this->content($this->info['description']);
    }
    
    private function content($val) {
        return is_array($val) ? $val['_content'] : $val;
    }
}
 
