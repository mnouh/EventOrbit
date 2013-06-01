<?php

require_once ('OAuth.php');
include_once('dbcon.php');
$filter = array('restaurants');
//$filter = array('champagne_bars', 'divebars', 'gaybars', 'hookah_bars', 'lounges', 'pubs', 'sportsbars', 'wine_bars', 'comedyclubs', 'danceclubs', 'jazzandblues', 'karaoke', 'musicvenues', 'poolhalls', 'adultentertainment');
//$unsigned_url = "http://api.yelp.com/v2/business/the-waterboy-sacramento";
for ($y = 0; $y < sizeof($filter); $y++) {
    for ($x = 0; $x < 1000; $x+=20) {
        echo $x . '<br><br><br>';
        $unsigned_url = "http://api.yelp.com/v2/search?category_filter=$filter[$y]&location=Binghamton&limit=20&offset=$x";

// For examaple, search for 'tacos' in 'sf'
//$unsigned_url = "http://api.yelp.com/v2/search?term=tacos&location=sf";



        $consumer_key = "O0QgNl_xgHKqVuOHefJsBg";
        $consumer_secret = "VgkJuINDtsQeYTwVQDPpX3wSTxk";
        $token = "6akLUA9horfuVGAsDsfne4bDDoQ7toLi";
        $token_secret = "cuXiGBmvEkOzlFTbFmgfkNRACRg";
/*
  
          $consumer_key = "55_ZGLRxNaxdHhomaDQ3fg";
          $consumer_secret = "PLycOdrpROeFg-bzhMjgZsCaD7A";
          $token = "88gnb9cHWGb6YHEoyv7dTLCKpUocm7eo";
          $token_secret = "BITs36nrAG6SF77K95nn6Edcxlk";

/*        
$consumer_key = "nyernj_NjJdaoSLVStoCVQ";
$consumer_secret = "i3anQEj0CdX5qMuFRG8Rpb40weM";
$token = "FxochRVZJKcAlBsg4KtwOl-qi1nLKR4Q";
$token_secret = "a_xneJqqRD2CcNyFcIFhEnDJU6M";
*/
// Token object built using the OAuth library
        $token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
        $consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
        $signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
        $oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
        $oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
        $signed_url = $oauthrequest->to_url();

// Send Yelp API Call
        $ch = curl_init($signed_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch); // Yelp response
        curl_close($ch);

// Handle Yelp response data
// Handle Yelp response data
        $obj = json_decode($data, true);

// Print it for debugging
        print_r($obj);

//echo var_dump($obj);

        if (isset($obj['businesses'])) {
            foreach ($obj['businesses'] as $entry) {
                $business_address = array();
                $phone = '';
                $display_phone = '';
                $state_code = '';
                $postal_code = '';
                $country_code = '';
                $city = '';
                $location_category = '';
                $location_category_name = '';
                $neighborhoods = '';
                $bizurl = $entry['name'];


                $pos = strpos($bizurl, '&');

                if ($pos === false) {
                    $bizurl = preg_replace('/\'/', '', $bizurl);
                    $bizurl = str_replace(" ", "-", $bizurl);
                } else {
                    $bizurl = preg_replace('/\'/', '', $bizurl);
                    $bizurl = preg_replace('/\&/', '-', $bizurl);
                    $bizurl = str_replace(" ", "", $bizurl);
                }


                $bizurl = $bizurl.'-'.$entry['location']['state_code'];
                //$bizurl = str_replace(" ","-",$bizurl);
                $bizurl = mysql_real_escape_string($bizurl);

                for ($i = 0; $i < 4; $i++) {

                    $business_address[$i] = NULL;
                }
                $finished_address = '';
                echo '<br><br>Name: ' . $entry['name'] . '<br>';
                $business_name = mysql_escape_string($entry['name']);

                if (isset($entry['phone'])) {
                    $phone = $entry['phone'];
                    $phone = mysql_escape_string($phone);

                    echo $phone . '<br>';
                }

                if (isset($entry['display_phone'])) {
                    $display_phone = $entry['display_phone'];
                    $display_phone = mysql_escape_string($display_phone);

                    echo $display_phone . '<br>';
                }



                $j = 0;
                foreach ($entry['location']['display_address'] as $address) {
                    echo $address . '<br>';
                    $business_address[$j] = mysql_escape_string($address);
                    $finished_address = $finished_address . ' ' . $address;
                    $j++;
                }

                foreach ($entry['categories'] as $category) {

                    $location_category = $location_category . $category['1'] . ',';
                    $location_category_name = $location_category_name . $category['0'] . ',';
                }

                $location_category = substr($location_category, 0, -1);
                $location_category_name = substr($location_category_name, 0, -1);

                $location_category = mysql_escape_string($location_category);
                $location_category_name = mysql_escape_string($location_category_name);


                if (isset($entry['location']['neighborhoods'])) {
                    foreach ($entry['location']['neighborhoods'] as $neighborhood) {

                        $neighborhoods = $neighborhoods . $neighborhood . ',';
                    }

                    $neighborhoods = substr($neighborhoods, 0, -1);
                    $neighborhoods = mysql_escape_string($neighborhoods);
                }




                $finished_address = mysql_escape_string($finished_address);

                echo 'Latitude: ' . $entry['location']['coordinate']['latitude'] . '<br>';
                echo 'Longitude: ' . $entry['location']['coordinate']['longitude'] . '<br>';

                $lat = $entry['location']['coordinate']['latitude'];
                $lng = $entry['location']['coordinate']['longitude'];

                if (isset($entry['location']['state_code'])) {
                    $state_code = $entry['location']['state_code'];
                    $state_code = mysql_escape_string($state_code);

                    echo $state_code . '<br>';
                }
                if (isset($entry['location']['postal_code'])) {
                    $postal_code = $entry['location']['postal_code'];
                    $postal_code = mysql_escape_string($postal_code);

                    echo $postal_code . '<br>';
                }
                if (isset($entry['location']['country_code'])) {
                    $country_code = $entry['location']['country_code'];
                    $country_code = mysql_escape_string($country_code);

                    echo $country_code . '<br>';
                }

                if (isset($entry['location']['city'])) {
                    $city = $entry['location']['city'];
                    $city = mysql_escape_string($city);

                    echo $city . '<br>';
                }

                echo '-----------------------<br>';


                $lat = mysql_escape_string($lat);
                $lng = mysql_escape_string($lng);

                echo $lat . '<br>';
                echo $lng . '<br>';

                $select_query = "SELECT * FROM tbl_markers WHERE `address0` = '" . $business_address[0] . "' AND lat=$lat AND lng=$lng";
                $exe = mysql_query($select_query, $status) or die($select_query . "<br/><br/>" . mysql_error());
                $num_rows = mysql_num_rows($exe);
                while ($row = mysql_fetch_array($exe)) {


                    echo "<br>HERE IS ROW ID: " . $row['id'];
                }






                echo '--------------------------------<br>';
                echo 'THE NUMBER OF ROWS FOUND ' . $num_rows . ' THE ROW[0] IS ' . $row[0] . '<br>';



                if ($num_rows > 0) {

                    echo '<b>Entry Already Exists ' . $business_name . '</b><br>';
                } else {

                    $query = "INSERT INTO tbl_markers (name, categories, categories_name, address, address0, address1, address2, address3, lat, lng, phone, display_phone, postal_code, country_code, state_code, city, neighborhoods, bizurl) VALUES ('$business_name', '$location_category', '$location_category_name', '$finished_address', '$business_address[0]', '$business_address[1]', '$business_address[2]', '$business_address[3]', '$lat', '$lng', '$phone', '$display_phone','$postal_code','$country_code','$state_code','$city', '$neighborhoods', '$bizurl')";
                    $result = mysql_query($query);

                    if (!$result) {

                        die('There was an error inserting into the data' . mysql_error());
                    }
                }
            }

//echo $response->span;
//$results  = print_r($response, true);
// Print it for debugging
        }
    }
}
?>
