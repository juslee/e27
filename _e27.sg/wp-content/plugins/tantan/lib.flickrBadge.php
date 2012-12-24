<?
/*
    Simple class to get data from phpFlickr
*/
class TanTanBadge {
    var $flickrTanTanAPIKey;
    var $flickrAPIKey;
    function TanTanBadge() {
        $this->flickrTanTanAPIKey = "379fb216f5cfa2ad184179bb936226e2";
    }
    function setFlickrAPI($key) {
        $this->flickrAPIKey = $key;
    }
    function getData($username, $numPhotos=18,$tags='') {
        require_once(dirname(__FILE__)."/lib.phpFlickr.php");
        
        $f = new tantan_phpFlickr($this->flickrAPIKey ? $this->flickrAPIKey : $this->flickrTanTanAPIKey);
        $nsid = $f->people_findByUsername($username);
        $photos_url = $f->urls_getUserPhotos($nsid);
        //$recent = $f->people_getPublicPhotos($nsid, NULL, $numPhotos);
        $recent = $f->photos_search(array(
            'user_id'=>$nsid,
            'tags'=>$tags,
            'per_page'=>$numPhotos,
            ));
        $photos = $recent['photo'];
        if (is_array($photos)) foreach ($photos as $k=>$p) {
            $img = $f->photos_getSizes($p['id']);
            $photos[$k]['photoSizes'] = $img;
            $photos[$k]['photoUrl'] = $photos_url.$p['id'];
        }
        return $photos;
    }
    function getDataForTags($tags, $numPhotos=18) {
        require_once(dirname(__FILE__)."/lib.phpFlickr.php");
        
        $f = new tantan_phpFlickr($this->flickrAPIKey ? $this->flickrAPIKey : $this->flickrTanTanAPIKey);
        $recent = $f->photos_search(array(
            'tags'=>$tags,
            'per_page'=>$numPhotos,
            ));
        $photos = $recent['photo'];
        $photos_url = 'http://www.flickr.com/photos/';
        if (is_array($photos)) foreach ($photos as $k=>$p) {
            $img = $f->photos_getSizes($p['id']);
            $photos[$k]['photoSizes'] = $img;
            $photos[$k]['photoUrl'] = $photos_url.$p['owner'].'/'.$p['id'].'/';
        }
        return $photos;
    }
}
?>