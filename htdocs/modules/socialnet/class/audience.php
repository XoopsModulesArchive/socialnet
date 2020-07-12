<?php 
if (!class_exists('IdgObjectHandler')) {
    include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_idgobject.php";
}
class SocialnetAudience extends XoopsObject {
    function SocialnetAudience() {
        $this->initVar('audienceid', XOBJ_DTYPE_INT);
        $this->initVar('audience', XOBJ_DTYPE_TXTBOX);
    }
}

class socialnetAudienceHandler extends IdgObjectHandler {
    function socialnetAudienceHandler(&$db) {
        $this->IdgObjectHandler($db, 'socialnet_newsaudience', 'SocialnetAudience', 'audienceid');
    }
    
    function delete(&$aud, $newaudid) {
        if ($aud->getVar('audienceid') == 1) {
            return false;
        }
        $sql = "UPDATE ".$this->db->prefix('socialnet_article')." SET audienceid = ".intval($newaudid)." WHERE audienceid = ".intval($aud->getVar('audienceid'));
        if (!$this->db->query($sql)) {
            return false;
        }
        return parent::delete($aud);
    }
    
    function getAllAudiences() {
        return $this->getObjects(null, true);
    }
    
    function getStoryCountByAudience($audience) {
        $sql = "SELECT COUNT(*) FROM ".$this->db->prefix("socialnet_article")." WHERE audienceid=".$audience->getVar('audienceid');
        if ($result = $this->db->query($sql)) {
            list($count) = $this->db->fetchRow($result);
            return $count;
        }
        return false;
    }
}

?>