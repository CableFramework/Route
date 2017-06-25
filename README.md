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
$matcher = new \Cable\Routing\Matcher();

$handled = (new \Cable\Routing\Routing($request, $collection, $matcher))->handle();

```
