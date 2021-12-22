# Waffler

<hr>

### How to install?

```shell
$ composer require waffler/waffler
```

* This package requires PHP 8 or above.

### How to test?

```shell
$ composer phpunit
```

## Quick start

For our example, lets imagine that we want to consume an ordinary API: `https://foo-bar.baz/api`

Our objectives are:

- Perform the login to retrieve the authorization token.
- Retrieve all posts from the database.

#### Step 1: Create the basic interface for your client.

```php
<?php // FooClient.php

namespace App\Clients;

interface FooClient
{
    /**
     * Retrieve authorization token.
     * 
     * @param array $credentials Just pass the login and password.
     * @return array             The json response.
     */
    public function login(array $credentials): array;
    
    /**
     * Retrieve all posts.
     * 
     * @param string $authToken The authorization token.
     * @param array $query      Some optional query string Filters.
     * @return array            The list of posts.
     */
    public function getPosts(string $authToken, array $query = []): array: 
}
```

#### Step 2: Annotate the methods with Waffler Attributes.

The magic is almost done. Now we need to annotate the methods and parameters to "teach" Waffler how to make the
requests. There are dozens of Attributes, but for this example we just need 5 of them.

Import the Attributes from the `Waffler\Attributes` namespace.

```php
<?php // FooClient.php

namespace App\Clients;

use Waffler\Attributes\Verbs\Get;
use Waffler\Attributes\Auth\Bearer;
use Waffler\Attributes\Request\Json;
use Waffler\Attributes\Request\Post;
use Waffler\Attributes\Request\Query;

interface FooClient
{
    /**
     * Retrieve authorization token.
     * 
     * @param array $credentials Just pass the login and password.
     * @return array             The json response.
     */
    #[Post('/auth/login')]
    public function login(#[Json] array $credentials): array;
    
    /**
     * Retrieve all posts.
     * 
     * @param string $authToken The authorization token.
     * @param array $query      Some optional query string Filters.
     * @return array            The list of posts.
     */
    #[Get('/posts')]
    public function getPosts(#[Bearer] string $authToken, #[Query] array $query = []): array: 
}
```

#### Step 3: Generate the implementation for your interface and use it.

Import the class `Waffler\Client\Factory` and call the static method `make` passing the
*fully qualified name* of the interface we just created as first argument and an associative array of GuzzleHttp client
options as second argument.

```php
<?php

namespace App;

use Waffler\Client\Factory;
use App\Clients\FooClient;

// Instantiate the client passing the interface as first argument.
$fooClient = Factory::make(FooClient::class, ['base_uri' => '<api-base-uri>']);

// Retrieve the credentials
$credentials = $this->fooClient->login([
    'email' => 'email@test.com',
    'password' => '<secret>'
]);

// Retrieve the posts.
$posts = $this->fooClient->getPosts($credentials['token'], ['created_at' => '2020-01-01'])
```

## Usage examples
See the [Examples folder](./examples).

## Attributes docs
** Work in progress **