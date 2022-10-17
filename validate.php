<?php 
    function movie_validate($title, $year, $genre, $price) {
        $retVal = "";

        $retVal .= validate_title($title);
        $retVal .= validate_name($genre);
        $retVal .= validate_not_null($year);
        $retVal .= validate_not_null($price);
    
        return $retVal;
    }

    function actor_validate($name) {
        $retVal = "";

        $retVal .= validate_name($name);

        return $retVal;
    }

    function movie_title_validate($title) {
        $retVal = "";

        $retVal .= validate_title($title);

        return $retVal;
    }

    function validate_title($field) {
        if($field == "") {
            return "Field cannot be null\n";
        } else if(preg_match("/[^a-zA-Z0-9-_: ]/",$field) == true) {
            return "Invalid characters found\n";
        } 
        return "";
    }

    function validate_not_null($field) {
        if($field == "" || $field == 0) {
            return "Field cannot be null\n";
        }
        return "";
    }

    function validate_name($field) {
        if($field == "") {
            return "Field cannot be null\n";
        } else if(preg_match("/[^a-zA-Z ]/",$field) == true) {
            return "Invalid characters found\n";
        } 
        return "";
    }
?>