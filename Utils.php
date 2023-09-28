<?php
    function createQueryUpdates($id,$methodData){
        $keys = array_keys($methodData);
        $result = '';
        $i = 0;
        foreach($keys as $categorie){
            if ($i != count($methodData) -1){
            $result = $result . $categorie . '="' . $methodData[$categorie] . '",';
            }
            else{
                $result = $result . $categorie . '="' . $methodData[$categorie] . '"';
            }
        }
        return $result;
    }
?>