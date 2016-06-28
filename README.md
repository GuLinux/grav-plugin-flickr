Grav Flickr Plugin
==================

This plugin allows you to fetch flickr photos, photosets and collections, and display them in page.

The current template make use of `featherlight`, with the `gallery` option enabled, to open your images in a slideshow.
If you wish to change this behaviour, please modify templates in the `templates/partial` directory.

Flickr data is provided via shortcodes, the `shortcode-core` plugin is therefore another dependency.

Quick usage
-----------

First you must configure your Flickr account, getting an API key and secret.
You should register to the [Flickr App Garden](https://www.flickr.com/services).
You will also need to find out your user id from your Flickr username, some services like [IdGettr](http://idgettr.com/) can get this for you.
Configure the flickr plugin (`flickr.yaml` in `user/config/plugins/`, or even better using Grav Admin),  with these values:

    flickr_api_key: "<your api key>"
    flickr_api_secret: "<your api secret>"
    flickr_user_id: "<your user id>"

To test the plugin you need to find the id of the Flickr daya you want to display.
Currently the plugin supports single photos, photosets (albums) and collections.
The id can usually be found on the url of the resource you are currently browsing.

### Single Photo

    [flickr-photo id=27313730662]

### Photoset

    [flickr-photoset id=72157669449388725]

### Collections

    [flickr-collection id=139636693-72157668802262691]
    

Advanced Options
----------------

Each shortcode accepts additional values beside the `id` parameter.
This is a list for each shortcode.

 * flickr-photo:
   * `display-format-photo`: single letter, defining the image size to be displayed. Look [Flickr URL reference](https://www.flickr.com/services/api/misc.urls.html) for all possible values.
   * `display-format-photo-lightbox`: same values as the previous parameter, but used to define image size in the lightbox popup.
 * flickr-photoset:
   * `photoset-title-tag`: HTML tag to use for the photoset title.
   * `photoset-description-tag`: HTML tag to use for the photoset description.
   * All the parameters for **flickr-photo** are also accepted, to properly display child photos.
 * flickr-collection
   * `hide-empty-collections`: if set to `true`, skips title and description for collections without sets. Default `false`
   * `collection-title-tag`: HTML tag to use for the collection title.
   * `collection-description-tag`: HTML tag to use for the collection description.
   * All the parameters for **flickr-photo** and **flickr-photoset** are also supported to properly display child photos and photosets.
   
