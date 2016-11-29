<?php

namespace Grav\Plugin\Flickr;
require_once(__DIR__.'/Photoset.php');
require_once(__DIR__.'/Collection.php');

use Grav\Common\Grav;
use Grav\Plugin\Flickr\Photoset;
use Grav\Plugin\Flickr\Collection;
use Grav\Common\GPM\Response;
use Grav\Common\Cache;

class FlickrAPIException extends \Exception {
    public function __construct($obj)
    {
        parent::__construct("Error during Flickr API call with code " . $obj['code'] . ": " . $obj['message'], $obj['code'], null);
    }
}

class FlickrAPI
{
    protected $key;
    protected $secret;
    protected $user_id;
    protected $grav;
    protected $config;
    protected $cache;
    protected $cache_duration;

    /**
     * set some instance variable states
     */
    public function __construct()
    {
        $this->grav = Grav::instance();
        $this->config = $this->grav['config'];
        $this->key = $this->config->get('plugins.flickr.flickr_api_key');
        $this->secret = $this->config->get('plugins.flickr.flickr_api_secret');        
        $this->user_id = $this->config->get('plugins.flickr.flickr_user_id');        
        $this->cache_duration = $this->config->get('plugins.flickr.flickr_cache_duration');        
        $this->cache = new Cache($this->grav);
    }

    public function photoset($id, $params)
    {
        $info = $this->request( ['method' => 'flickr.photosets.getInfo', 'photoset_id' => $id ])['photoset'];
        $get_photos_params = array_merge(
            [ "method" => "flickr.photosets.getPhotos", "photoset_id" => $id, 'user_id' => $info['owner'], 'extras' => 
                'license,date_upload,date_taken,owner_name,icon_server,original_format,last_update,geo,tags,machine_tags,views,media,description' ],
            $this->get_params($params, ['page', 'per_page', 'privacy_filter', 'media']));
        
        $photos = $this->request( $get_photos_params )['photoset'];
        return new Photoset($info, $photos, $this);
    }
    
    public function photo($id)
    {
        $info = $this->request( ['method' => 'flickr.photos.getInfo', 'photo_id' => $id ])['photo'];
        return new Photo($info, $this);
    }
    
    public function collection($id)
    {
        $info = $this->request( ['method' => 'flickr.collections.getTree', 'collection_id' => $id ])['collections'];
        foreach($info['collection'] as $collection) {
            if( ! strpos($collection['id'], $id) ) {
                return new Collection($collection, $this);
            }
        }
        return null; // TODO
    }
    
    private function request($params) {
        $url = 'https://api.flickr.com/services/rest/?' . http_build_query(array_merge($params, ['api_key' => $this->key, 'format' => 'php_serial', 'user_id' => $this->user_id]));
        if($this->cache_duration > 0) {
            $obj = $this->cache->fetch($url);
            if($obj) {
                return $obj;
            }
        }
        $obj = unserialize(Response::get($url));
        if($obj["stat"] != "ok") {
            throw new FlickrAPIException($obj);
        }
        if($this->cache_duration > 0) {
            $this->cache->save($url, $obj, $this->cache_duration);
        }
        return $obj;
    }
    
//     private function secret_request($params) {
//         return $this->request(array_merge($params, ['']));
//     }

    private function get_params($params, $keys) {
        $retval = [];
        foreach($keys as $key) {
            if(array_key_exists($key, $params))
                $retval[$key] = $params[$key];
        }
        return $retval;
    }
}
