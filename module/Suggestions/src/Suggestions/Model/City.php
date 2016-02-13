<?php

namespace Suggestions\Model;

class City
{
    
    public $id;
    public $country;
    public $latitude;
    public $longitude;
    public $name;
    public $stateprov;
    
    private $tableauCorrespondancePays;
 
    public function exchangeArray($data)
    {
	$this->id = (!empty($data['id'])) ? $data['id'] : null;
	$this->country = (!empty($data['country'])) ? $data['country'] : null;
        $this->latitude = (!empty($data['lat'])) ? $data['lat'] : null;
        $this->longitude = (!empty($data['long'])) ? $data['long'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->stateprov = (!empty($data['stateprov'])) ? $data['stateprov'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    /*
     * @param String $lat, String $long
     * @return la valeur du score
     * Fonction qui calcule les scores de chaque ville 
     *par apport à la distance entrée par l'utilisateur et la latitude de la ville recherchée
     */
    public static function calculerScore($ville, $lat, $long)
    {
        if($lat == $ville->latitude){  
            return 1;
        } else if(((doubleval($ville->latitude) - doubleval($lat) > 0) && ((doubleval($ville->latitude) - doubleval($lat)) < 10)) || 
               ((doubleval($ville->latitude) - doubleval($lat) < 0) && ((doubleval($ville->latitude) - doubleval($lat)) > -10))){
              return 0.9;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 10) && (doubleval($ville->latitude) - doubleval($lat) < 20)
                || ((doubleval($ville->latitude) - doubleval($lat) < -10) && ((doubleval($ville->latitude) - doubleval($lat)) > -20))){
            return 0.8;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 20) && (doubleval($ville->latitude) - doubleval($lat) < 30)
                || ((doubleval($ville->latitude) - doubleval($lat) < -20) && ((doubleval($ville->latitude) - doubleval($lat)) > -30))){
            return 0.7;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 30) && (doubleval($ville->latitude) - doubleval($lat) < 40)
               || ((doubleval($ville->latitude) - doubleval($lat) < -30) && ((doubleval($ville->latitude) - doubleval($lat)) > -40))){
            return 0.6;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 40) && (doubleval($ville->latitude) - doubleval($lat) < 50)
               || ((doubleval($ville->latitude) - doubleval($lat) < -40) && ((doubleval($ville->latitude) - doubleval($lat)) > -50))){
            return 0.5;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 50) && (doubleval($ville->latitude) - doubleval($lat) < 60)
                || ((doubleval($ville->latitude) - doubleval($lat) < -50) && ((doubleval($ville->latitude) - doubleval($lat)) > -60))){
            return 0.4;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 60) && (doubleval($ville->latitude) - doubleval($lat) < 70)
               || ((doubleval($ville->latitude) - doubleval($lat) < -60) && ((doubleval($ville->latitude) - doubleval($lat)) > -70))){
            return 0.3;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 70) && (doubleval($ville->latitude) - doubleval($lat) < 80)
               || ((doubleval($ville->latitude) - doubleval($lat) < -70) && ((doubleval($ville->latitude) - doubleval($lat)) > -80))){
            return 0.2;
        }
        else if((doubleval($ville->latitude) - doubleval($lat) > 80) && (doubleval($ville->latitude) - doubleval($lat) < 90)
                || ((doubleval($ville->latitude) - doubleval($lat) < -80) && ((doubleval($ville->latitude) - doubleval($lat)) > -90))){
            return 0.1;
        } else {
            return 0;
        }
    }
    
    /*
     * @param array $array, String $lat, String $long
     * @return array des villes sous format JSON
     */
    public static function formaterDonneesArrayVilles($array, $lat, $long){
        /*
         *  Appel à un service externe pour obtenir un tableau de correspondance entre noms symboliques et noms complet. 
         * Récupère les données et les transforme en format JSON et les met dans un tableau
         */
        $tableauCorrespondancePays = \ 
                json_decode(file_get_contents("http://country.io/names.json"), true);
        
        
        $liste = array();
        /*Pour chaque ville on récupère les données nécessaires et on les ajoutes dans une variable*/
        foreach ($array as $ville){
            
            
            $score =  City::calculerScore($ville, $lat, $long);
            $country = $tableauCorrespondancePays[$ville->country];
            $name = $ville->name . ', ' . $ville->stateprov . ', ' . $country; 
            $ville = new CityFormat($name, $ville->latitude, $ville->longitude, $score);
            /*On stocke tout ça dans une array*/
            array_push($liste, $ville);
           }
        return $liste;
    }
}
?>
