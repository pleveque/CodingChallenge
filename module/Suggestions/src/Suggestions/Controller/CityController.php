<?php
    
    
namespace Suggestions\Controller;
    
use Suggestions\Model\City;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
    
class CityController extends AbstractActionController
{
    protected $citiesTable;
        
    /*Fonction permettant de récupérer les recherches et les afficher dans la vue*/
    public function JSonVillesAction()
    { 
        /*Paramètres à passer dans l'url pour la recherche des villes*/
        $city = $this->getRequest()->getQuery()['q'];
        $lat = $this->getRequest()->getQuery()['lat'];
        $long = $this->getRequest()->getQuery()['long'];  
            
        // Éxécuter des recherches différentes en fonction des paramètres entrés
        if (!empty($lat) && !empty($long)){
            $villes = $this->getCitiesTable()->searchCitiesLatLong($city, $lat, $long);
        } else if (!empty($lat) && empty($long)){
            $villes = $this->getCitiesTable()->searchCitiesLat($city, $lat);
        } else if (!empty($long) && empty($lat)){
            $villes = $this->getCitiesTable()->searchCitiesLong($city, $long);
        } else {
            $villes = $this->getCitiesTable()->searchCities($city, $lat);
        }
            
        /*Récupération des villes sous format JSON*/
        $villes = City::formaterDonneesArrayVilles($villes, $lat, $long);
            
        /* Si la requête de selection des villes est vide on retourne une erreur 404*/  
         if(empty($villes)){
             return $this->getResponse()->setStatusCode(404);
         }
         else/*sinon on retourne les villes en JSON*/
         { 
            return new JsonModel(array(
            'suggestions' => $villes,
            ));
         }
    }
        
    public function villesAction()
    {
    }
        
    public function getCitiesTable()
    {
       if ( !$this->citiesTable )
        {
            $sm = $this->getServiceLocator();
            $this->citiesTable = $sm->get('Suggestions\Model\CityTable');
        }        
        return $this->citiesTable;
    }
}