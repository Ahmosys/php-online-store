<?php

class VariablesGlobales
{
    public static $theCategories;
    public static $theProducts;
    public static $theResearchProducts;
    public static $theLabelsCatergory;
    public static $topProduct;
    public static $topProducts;
    public static $lastProduct;
    public static $lastProducts;
    public static $theTables;
    public static $theDatabaseName = "Tables_in_" . MysqlConfig::BASE;
    public static $theFields;
    public static $theOccurrences;
    public static $theUser;
    
    public static $theUserNewsletter = array();
    
    public static $theErrors = array(); 
    public static $theSuccesses = array();
    
    public static $theProductsBasket = array();
    public static $theFieldsPrimaryKey = array();
    
    public static $theFavoriteProductsUser = array();
    public static $theOrderUser = array();
    public static $theOrderContent = array();
}

?>
