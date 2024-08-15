<?php

namespace TheySaidSo;

class Quotes extends ApiBase
{
  private $path = null;

  private $language = null;
  private $limit = null;

  private $category = null;
  private $author = null;
  private $min_length = null;
  private $max_length = null;
  private $query = null;
  private $sfw = null;
  private $private = null;
  private $id = null;

  protected function _random()
  {
     $this->path = '/quote/random';
     return $this;
  }

  protected function _search($query)
  {
     $this->path = '/quote/search';
     $this->query= $query;
     return $this;
  }

  protected function _id(string $id)
  {
     $this->path = '/quote';
     $this->id = $id;
     return $this;
  }

  protected function _author(string $author)
  {
     $this->author = $author;
     return $this;
  }

  protected function _language(string $lang)
  {
     $this->language = $lang;
     return $this;
  }

  protected function _minLength(int $len)
  {
     $this->min_length = $len;
     return $this;
  }

  protected function _maxLength(int $len)
  {
     $this->max_length = $len;
     return $this;
  }

  protected function _limit(int $limit)
  {
     $this->limit = $limit;
     return $this;
  }

  protected function _category(string $category)
  {
     $this->category = $category;
     return $this; 
  }

  /*protected function _query($query)
  {
     $this->query = $query;
     return $this; 
  }*/

  protected function _private(bool $flag)
  {
     $this->private = $flag;
     return $this; 
  }

  protected function _sfw(bool $sfw)
  {
     $this->sfw = $sfw;
     return $this; 
  }

 protected function _get()
 {

     if ( $this->api_key === null)
          throw new \Exception('Please set the API Key first with (withCredential method)');
     if ( $this->path === null)
          throw new \Exception('Please specify an operation first random/search etc');

     $query = [];
     if ( $this->language !== null )
          $query['language'] = $this->language;
     if ( $this->limit !== null )
          $query['limit'] = $this->limit;
     if ( $this->id !== null )
          $query['id'] = $this->id;

     if ( $this->path === '/quote/search' )
     {
       if ( ! empty($this->query) )
	    $query['query'] = $this->query;
       else
          throw new \Exception('Please set the search query before calling search API');

       if ( $this->category !== null )
	    $query['category'] = $this->category;
       if ( $this->author !== null )
	    $query['author'] = $this->author;
       if ( $this->min_length !== null )
	    $query['minlength'] = $this->min_length;
       if ( $this->max_length !== null )
	    $query['maxlength'] = $this->max_length;
       if ( $this->sfw !== null )
	    $query['sfw'] = $this->sfw;
       if ( $this->private !== null )
	    $query['private'] = $this->private;
     }
     $response = $this->client->request(
                           'GET',
                           $this->path,
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
