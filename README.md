# Route
Route library for cable framework


# Simple Usage


```php

$collection = new \Cable\Routing\RouteCollection();

$route = new \Cable\Routing\Route('/post/:id');
$route->setMethods(array('GET'))
    ->setScheme(array('http'))
    ->setRequirements(array(
        'id' => '\d+'
    ));
$collection->addRoute($route);


$request = \Symfony\Component\HttpFoundation\Request::create('/post/5', 'GET');
$matcher = new \Cable\Routing\Matcher\RegexMatcher();

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

```


## Request

 Cable Route uses symfony Request class for handle uri and pathinfo
 
 
```php

$request = \Symfony\Component\HttpFoundation\Request::create('/post/5', 'GET');

```

## Static Matcher

Matches only static url's

```php 
 $route = new \Cable\Routing\Route('/post/5');
 $route->setMethods(array('GET'));
 
 $collection->addRoute($route);

$matcher = new \Cable\Routing\Matcher\StaticMatcher();

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

```
