<?php
    function createQueryUpdates($id,$methodData){
        
        $keys = array_keys($methodData);
        $j = 0;
        foreach($keys as $categorie){
            if(is_array($methodData[$categorie])){
                unset($keys[$j]);
                $keys = array_values($keys);
            }
            $j++;
        }
        $result = '';
        $i = 0;
        foreach($keys as $categorie){
            if ($i != count($keys) -1){
            $result = $result . $categorie . '="' . $methodData[$categorie] . '",';
            }
            else{
                $result = $result . $categorie . '="' . $methodData[$categorie] . '"';
            }
            $i++;
        }
        return $result; 
    }
?>