# theysaidso-quotes

A fluent php client library for They Said So quotes API. You can get the API key here. [https://theysaidso.com/api]

## Installation

```
composer require orthosie/theysaidso-quotes
```

## Get Quote of the day

```
use TheySaidSo\QuoteOfTheDay;
$qod = QuoteOfTheDay::withCredential('<apikey>')->category('inspire')->get();

print "Quote of the day\n";
print $qod[0]['quote'] ." - " .  $qod[0]['author'] . "\n";
```

## Get Random Quote

Get a random quote 
```
use TheySaidSo\Quotes;

$quotes = Quotes::withCredential(<api-key>)->random()->limit(1)->get();
print "A quote by " .  $quotes[0]['author'] . "\n";
print $quotes[0]['quote'] ."\n";
```

## Search Quotes

Search for a quote from Steve Jobs that says something about design
```
use TheySaidSo\Quotes;

$quotes = Quotes::withCredential(<api-key>)->search('design')->author('Steve Jobs')->get();
print "A quote by " .  $quotes[0]['author'] . " on design\n";
print $quotes[0]['quote'] ."\n";
```
