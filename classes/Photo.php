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
    
    public function url_original() {
        return $this->info['url_o'];
    }
    public function url_sq() {
        return $this->info['url_sq'];
    }
    public function url_t() {
        return $this->info['url_t'];
    }
    public function url_m() {
        return $this->info['url_m'];
    }
    public function url_s() {
        return $this->info['url_s'];
    }

    public function title() {
        return $this->info['title'];
    }
    
    public function datetaken() {
        return $this->info['datetaken'];
    }
}
 
