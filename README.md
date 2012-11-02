# Hal/Hal package

This package is used to create hal json. It's quick and dirty and the only
reason it exists is for my own education. Feel free to use it.

# Usage

    <?php

    use Hal\Link;
    use Hal\Resource;

    // This is required, you need to give the location of where the user is at
    $resource = new Resource(new Link('/location', 'self'));

    // Define a new resource
    $productResource        = new Resource(new Link('/product/123', 'self'), 'products');
    $productResource->title = 'Test Product';

    // Add the resource to your main resource
    $resource->addResource($productResource);

    // You can add more links too
    $resource->addLink(new Link('/location/next', 'next'));
    $resource->addLink(new Link('/location/previous', 'previous'));

    // Now you can dump the json
    echo $resource->asJson();
