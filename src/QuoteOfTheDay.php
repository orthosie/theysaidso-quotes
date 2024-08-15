<?php

namespace TheySaidSo;

use TheySaidSo\Models\QuoteOfTheyDay;

class QuoteOfTheDay extends ApiBase
{
   private $date = null;
   private $quotes = [];
   private $categories = null;
   private $endpoint = "/qod";

   private $category = null;
   private $language = "en";
   private $id = null;

   public function __construct()
   {
      return parent::__construct();
   }

   protected function _categories()
   {
      if ( $this->categories !== null )
            return $this->categories;

      if ( $this->api_key === null)
          throw new \Exception('Please set the API Key first with (withCredential method)');

     $response = $this->client->request(
                           'GET',
                           '/qod/categories',
                           [
                              'debug' => $this->debug,
                              'query' => [
				  'language' => $this->language,
				  'detailed' => 0,
				  //'api_key' => $this->api_key
                               ],
			       'headers' => 
			       [
				   'Authorization' => "Bearer " . $this->api_key
			       ]
                           ]
                      );

      $this->processResponse($response);
      if ( $response->getStatusCode() == 200 )
      {
          $this->categories = json_decode($response->getBody()->getContents(),true)['contents']['categories'];
      }
      return $this->categories;
   }

   protected function _category($category)
   {
     $this->category = $category;
     return $this; 
   }

   protected function _language($language)
   {
     $this->language = $language;
     return $this; 
   }

   protected function _id($id)
   {
     $this->id = $id;
     return $this; 
   }

   protected function _get()
   {

     if ( $this->api_key === null)
          throw new \Exception('Please set the API Key first with (withCredential method)');

     $query = [];
     if ( $this->category !== null )
          $query['category'] = $this->category;
     if ( $this->language !== null )
          $query['language'] = $this->language;
     if ( $this->id !== null )
          $query['id'] = $this->id;

     $response = $this->client->request(
                           'GET',
                           $this->endpoint,
                           [ 
                               'debug' => $this->debug,
                               'query' => $query,
			       'headers' => 
			       [
			         'Authorization' => "Bearer " . $this->api_key
			       ]
			   ]
                      );

      $this->processResponse($response);
      if ( $response->getStatusCode() == 200 )
      {
          return json_decode($response->getBody()->getContents(),true)['contents']['quotes'];
      }
      return null;
   }
}
