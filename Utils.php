<?php
    function createGetRequest($url){
        $opts = array('http' => array('method' => 'GET'));
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result,true);
<<<<<<< HEAD
        
=======
>>>>>>> origin/main
        return $result;
    }
    function createPostRequest($url,$data){
        $curl = curl_init();
        $postData = json_encode($data); // $data is an Array

<<<<<<< HEAD

=======
>>>>>>> origin/main
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

        $json = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($json,true);
<<<<<<< HEAD
=======

>>>>>>> origin/main
        return $result;
    }
    function createPutRequest($url,$data){
        $curl = curl_init();
        $postData = json_encode($data); // $data is an Array

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl,CURLOPT_PUT,true);

        $json = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($json,true);

        return $result;
    }
    function createDeleteRequest($url){
        $opts = array('http' => array('method' => 'DELETE'));
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result,true);
<<<<<<< HEAD

=======
>>>>>>> origin/main
        return $result;
    }

    function checkUser($sessionId){
<<<<<<< HEAD
        $url = 'http://localhost/blog-tp-note-php/api/index.php/Check/' . $sessionId;
        $result = createGetRequest($url);

=======
        $url = 'http://localhost/Blog/API/index.php/Check/' . $sessionId;
        $result = createGetRequest($url);
>>>>>>> origin/main
        return ($result["Statut"] === 200) ? true : false;
    }
?>