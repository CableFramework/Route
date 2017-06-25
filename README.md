## Route
Route library for cable framework

```php

use Cable\Routing\Route;


$route = new Route('/post/:id', array('id' => "\d+"));

// same as $route->setUri('/post/:id')
                  ->setRequirements(array('id' => "\d+"));
   
// set scheme, by default supports both http and https
$route->setScheme(array('http', 'https'));

// set host,  for examle sub.test.com will matched and
// :sub_domain parameter will passed into HandledRoute
$route->setHost(':subdomain_parameter.test.com');


// set 
```

## Request

 Cable Route uses symfony Request class for handle uri and pathinfo
 
 
```php

$request = \Symfony\Component\HttpFoundation\Request::create('/post/5', 'GET');

```

## Simple Usage


```php

$collection = new \Cable\Routing\RouteCollection();

$route = new \Cable\Routing\Route('/post/:id');
$route->setMethods(array('GET'))
    ->setScheme(array('http'))
    ->setRequirements(array(
        'id' => '\d+'
    ));
$collection->addRoute($route);

$matcher = new \Cable\Routing\Matcher\RegexMatcher();

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

```




## Static Matcher

You can't use dynamic host and path info parameters with static matcher


Matches only static url's

```php 

$matcher = new \Cable\Routing\Matcher\StaticMatcher();

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

```

## Nested Matcher

You can use multiple matchers in one matcher


````php
use Cable\Routing\Matcher\StaticMatcher;
use Cable\Routing\Matcher\RegexMatcher;
use Cable\Routing\Matcher\NestedMatcher;

$matcher =  new NestedMatcher(
       new StaticMatcher(),
       new RegexMatcher()
);

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

````