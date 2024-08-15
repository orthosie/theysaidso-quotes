<?php

namespace TheySaidSo;

use GuzzleHttp\Client;

class ApiBase
{
    protected $base_url = "https://quotes.rest";
    protected $api_key = null;
    protected $client = null;
    protected $debug = false;

    protected $total_limit = null;
    protected $limit_remaining = null;

    public function __construct()
    {
       $this->client = new Client(['base_uri' => $this->base_url]);
    }

    public function __call($method, $args)
    {
        return $this->call($method, $args);
    }

    public static function __callStatic($method, $args)
    {
        return (new static())->call($method, $args);
    }

    private function _withCredential($api_key)
    {
      $this->api_key = $api_key;
      return $this;
    }

    private function _debug($flag)
    {
      $this->debug = $flag;
      return $this;
    }

    private function _totalLimit()
    {
      return $this->total_limit;
    }

    private function _limitRemaining()
    {
      return $this->limit_remaining;
    }

    protected function processResponse($response)
    {
      if ($response->hasHeader('X-RateLimit-Limit')) {
	  $this->total_limit = $response->getHeader('X-RateLimit-Limit')[0];
      }

      if ($response->hasHeader('X-RateLimit-Remaining')) {
	  $this->limit_remaining = $response->getHeader('X-RateLimit-Remaining')[0];
      }
      return $response;
    }

    private function call($method, $args)
    {
        if (! method_exists($this , '_' . $method)) {
            throw new \Exception('Call undefined method ' . $method);
        }

        return $this->{'_' . $method}(...$args);
    }
}
