<?php
    
namespace Suggestions\Model;
use Zend\Db\TableGateway\TableGateway;
    
    
    
class CityTable 
{

    protected $tableGateway;
        
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
	      
    /* Récupérer tout le contenu de la table */
    public function fetchAll() 
    {       
        $resulSet = $this->tableGateway->select();
        return $resulSet;
    }
        
    /*Requête pour selectionner seulement le nom de la ville*/
    public function searchCities($city)
    {
        $villes = $this->tableGateway->select(function ($select) use ($city) {
            
            $select->where->like('name', $city.'%');
                
            });
         
           return $villes;
    }   
        
    /*Requête pour selectionner le nom de la ville et la latitude*/
    public function searchCitiesLat($city, $lat)
    {
        $villes = $this->tableGateway->select(function ($select) use ($city, $lat) {
            $select->where->like('name', $city.'%');
                
            });  
        return $villes;    
    }
        
    /*Requête pour selectionner le nom de la ville et la longitude*/
    public function searchCitiesLong($city, $long)
    {
        $villes = $this->tableGateway->select(function ($select) use ($city, $long) {
            $select->where->like('name', $city.'%');
                
            });  
        return $villes;  
    }
        
    /*Requête pour selectionner le nom de la ville, la latitude et longitude*/
    public function searchCitiesLatLong($city, $lat, $long)
    {
        $villes = $this->tableGateway->select(function ($select) use ($city, $lat, $long) {
            $select->where->like('name', $city.'%');
                
            });  
        return $villes;   
    }
}