<?php

class Search{

    private $query;

    public function __construct(){

    }

    public function searchQ($query, $category=null){
        include_once('dbh.php');

        $categoryDigit = null;
        switch ($category) {
            case "Vehicles":
                $categoryDigit = '00';
                break;
            case "Cleaning appliences":
                $categoryDigit = '01';
                break;
            case "Electrical/Electronic":
                $categoryDigit = '02';
                break;
            case "Catering":
                $categoryDigit = '03';
                break;
            case "Building and construction":
                $categoryDigit = '04';
                break;
            case "Other":
                $categoryDigit = '99';
                break;
            default:
                $categoryDigit = '100';
        }


        $query = htmlspecialchars($query);
        // changes characters used in html to their equivalents, for example: < to &gt;

        //$query = mysqli_real_escape_string($query);
        // makes sure nobody uses SQL injection
        if($categoryDigit==='100'){
            $sqlQuery = "SELECT * FROM ads WHERE (`title` LIKE '%" . $query . "%') OR (`description` LIKE '%" . $query . "%')";
        }else{
            $sqlQuery = "SELECT * FROM ads WHERE ((`title` LIKE '%" . $query . "%') OR (`description` LIKE '%" . $query . "%')) AND (category='$categoryDigit')";
        }
        

        //$sqlQuery = "SELECT * FROM ads WHERE category= 01";
        
        return $sqlQuery;

    }

    public function renderHTML($sqlQuery){
        $dbh = new dbh();
        $db_login = $dbh->connect();
        $raw_results = mysqli_query($db_login, $sqlQuery) or die(mysql_error());
        $htmlString = '';
        if (mysqli_num_rows($raw_results) > 0) { // if one or more rows are returned do following

            while ($results = mysqli_fetch_array($raw_results)) {
                $htmlString .= "<div class=\"card my-5\" style=\"width: 80%; height: auto;\">";
                $htmlString .= "<img src='ads/".$results['image']."'class ='card-img-top img-responsive' alt = 'Responsive image' style ='width : auto ; height:400px;'>";
                $htmlString .= "  <div class=\"card-body\">";
                $htmlString .= "      <h5 class=\"card-title\">" . $results['title'] . "</h5>";
                $htmlString .= "      <p class=\"card-text\">" . $results['description'] . "</p>";
                //$htmlString .= "      <a href='' class='btn btn-primary'>View</a>";
                $htmlString .= "  </div>";
                $htmlString .= "</div>";

            }
        } else { 
            $htmlString .= "No results found";
        }

        return $htmlString;

    }
    
}