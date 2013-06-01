<?php
/**
 * Author mnouh 
 */
class GMaps
{
    const MAPS_HOST = 'maps.googleapis.com';
    /**
     * Latitude 
     * 
     * @var double
     */
    private $_latitude;
    /**
     * Longitude 
     *
     * @var double
     */
    private $_longitude;
    /**
     * Address 
     *
     * @var string
     */
    private $_address;
    /**
     * Country name 
     *
     * @var string
     */
    private $_countryName;
    /**
     * Country name code
     *
     * @var string
     */
    private $_countryNameCode;
    /**
     * Administrative area name
     *
     * @var string
     */
    private $_administrativeAreaName;
    
    private $_city;
    
    private $_state;
    /**
     * Postal Code
     *
     * @var string
     */
    private $_postalCode;
    /**
     * Google Maps Key
     *
     * @var string
     */
    private $_key;
    /**
     * Base Url
     *
     * @var string
     */
    private $_baseUrl;
    /**
     * Construct
     *
     * @param string $key
     */
    function __construct ($key='')
    {
        $this->_key= $key;
        $this->_baseUrl= "http://" . self::MAPS_HOST . "/maps/api/geocode/xml?sensor=false&key=" . $this->_key;
    }
    /**
     * getInfoLocation
     *
     * @param string $address
     * @param string $city
     * @param string $state
     * @return boolean
     */
    public function getInfoLocation ($address) {
        if (!empty($address)) {
            return $this->_connect($address);
        }
        return false;    
    }
    /**
     * connect to Google Maps
     *
     * @param string $param
     * @return boolean
     */
    private function _connect($param) {
        $request_url = $this->_baseUrl . "&address=" . urlencode($param);
        $xml = simplexml_load_file($request_url);  
        
        if (! empty($xml->result)) {
            $point= $xml->result->geometry;
            if (! empty($point)) {
                $this->_latitude = $point->location->lat;
                $this->_longitude = $point->location->lng;    
            }
            
            $this->_address= $xml->result->formatted_address;
            /*
            $this->_countryName= $xml->result->address_component->AddressDetails->Country->CountryName;
            $this->_countryNameCode= $xml->Response->Placemark->AddressDetails->Country->CountryNameCode;
            $this->_administrativeAreaName= $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName;
            $this->_city = $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea->DependentLocality->DependentLocalityName;     
            $administrativeArea= $xml->Response->Placemark->AddressDetails->Country->AdministrativeArea;
            if (!empty($administrativeArea->SubAdministrativeArea)) {
                $this->_postalCode= $administrativeArea->SubAdministrativeArea->Locality->PostalCode->PostalCodeNumber;
            } elseif (!empty($administrativeArea->Locality)) {
                $this->_postalCode= $administrativeArea->Locality->PostalCode->PostalCodeNumber;
            }*/
            return true;
        } else {
            return false;
        }
    }
    /**
     * get the Postal Code
     *
     * @return string
     */
    public function getPostalCode () {
        return $this->_postalCode;
    }
	/**
     * get the Address
     *
     * @return string
     */
    public function getAddress () {
        return $this->_address;
    }
	/**
     * get the Country name
     *
     * @return string
     */
    public function getCountryName () {
        return $this->_countryName;
    }
	/**
     * get the Country name code
     *
     * @return string
     */
    public function getCountryNameCode () {
        return $this->_countryNameCode;
    }
	/**
     * get the Administrative area name
     *
     * @return string
     */
    public function getAdministrativeAreaName () {
        return $this->_administrativeAreaName;
    }
    /**
     * get the Latitude coordinate
     *
     * @return double
     */
    public function getLatitude () {
        return $this->_latitude;
    }
    
    public function getCity()
    {
        
        return $this->_city;
    }
    /**
     * get the Longitude coordinate
     *
     * @return double
     */
    public function getLongitude () {
        return $this->_longitude;
    }
}