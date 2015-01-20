<?php

require_once(plugin_dir_path( __FILE__ ) . "./entities/Item.php");

class WowApi {
    function __construct() {
        $this->region = "us";
        $this->realm  = "Stormrage";
    }
    
    // public functions
    public function GetCharFeed($name) {
        $charUrl = self::BuildCharUrl($name);
        
        $json = file_get_contents($charUrl."?fields=feed");
        
        return $json === FALSE ? NULL : json_decode($json);
    }
    public function GetItemLevel($itemId) {
        $results = array();
        $itemUrl = self::BuildItemUrl($itemId);
        $json = $data = $subData = NULL;
        
        if(($json = file_get_contents($itemUrl)) === FALSE) return NULL;
        $data = json_decode($json);
        
        if(isset($data->availableContexts) && $data->availableContexts != [""]) {
            // get ItemLevel for all contexts
            foreach($data->availableContexts as $context) {
                if(($json = file_get_contents($itemUrl."/$context")) === FALSE) continue;
                $subData = json_decode($json);
                
                array_push($results, new Item($itemId, $context, $subData->itemLevel)); 
            }
        } else array_push($results, new Item($itemId, NULL, $data->itemLevel));
        
        return $results;
    }
    
    // helper functions
    private function BuildItemUrl($itemId) { return "http://$this->region.battle.net/api/wow/item/$itemId"; }
    private function BuildCharUrl($name) { return "http://$this->region.battle.net/api/wow/character/$this->realm/$name"; }
    
    // members
    private $region;
    private $realm;
}
?>