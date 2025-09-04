# Trie Based Router Documentation

This doc explains the custom PHP Router implemented in `src/router.php`.This router handles routing in simple, fast and flexible way and route the request to handlers or view files.

## Overview

The router uses a trie (prefix tree) data structure to efficiently match request paths and HTTP methods. It supports static routes, dynamic params, and custom error handlers for 404 (Not Found) and 405 (Not Allowed) responses.

## Classes

### RouterNode
Represents a node in the route trie.
- `children`: Array of child nodes for static path segments.
- `param`: Child node for dynamic parameters (e.g., `/user/$id`).
- `paramName`: Name of the dynamic parameter.
- `handlers`: Array of handlers for HTTP methods ("GET", "POST", etc.).

### Router
Main router class for registering routes and dispatching requests.
- `root`: Root node of the route trie.
- `basePath`: Base path for the app.
- `viewDir`: View files dir.
- `notFoundHandler`: Handler for 404 errors.
- `methodNotAllowedHandler`: Handler for 405 errors.

## Usage

### Initialization
```php
$router = new Router([
  "basePath" => "/app", // optional
  "viewDir" => __DIR__ . "/views"
]);
```

### Registering Routes
Use the following methods to register routes:
- `get($path, $handler)`
- `post($path, $handler)`
- `put($path, $handler)`
- `delete($path, $handler)`
- `any($path, $handler)`

**Example:**
```php
$router->get("/", "home"); // executes views/home.php
$router->post("/login", function($params) { /* ... */ });
$router->get("/user/$id", function($id) { /* ... */ });
```

### Dynamic Parameters
`$` prefix for dynamic segments:
```php
$router->get("/profile/$username", function($username) {
  // Handle profile for $username
});
```

### Dispatching Requests
`dispatch()` to handle the current request:
```php
$router->dispatch($_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"]);
or
$router->dispatch();
```
Can be pass custom URI and method:
```php
$router->dispatch("/login", "POST");
```

## Time and Space Complexity Analysis

### Route Insertion (`addRoute`)
- **Time Complexity:** O(m)
  - Here `m` is the number of segments in the route path (e.g., `/user/$id` has 2 segments).
  - Each segment is processed once as the trie is traversed or extended.
- **Space Complexity:** O(n * k)
  - Where `n` is the number of unique routes, and `k` is the average number of segments per route.
  - Each route creates new nodes only for unique segments, so space usage is efficient for shared prefixes.

### Request Dispatch (`dispatch`)
- **Time Complexity:** O(m)
  - Where `m` is the number of segments in the request path.
  - The router traverses the trie from root to leaf through static and dynamic segments
- **Space Complexity:** O(m)
  - For storing parameters in the request (usually a small number).

### Efficiency
- **Trie Structure:**
  - Shared prefixes between routes reduce memory and speed up the searching.
  - Both insertion and lookup are linear in the number of path segments, not the total number of routes.
- **Dynamic Parameters:**
  - Handled efficiently by storing a single param node per segment.

### Comparison
- **Linear Search Router:** O(n) time for lookup (`n` is the number of routes).
- **Trie Router (-this-):** O(m) time for lookup (`m` is the number of segments in the path), which is much faster for large numbers of routes.

### Summary Table
| Operation         | Time Complexity | Space Complexity |
|-------------------|----------------|-----------------|
| Route Insertion   | O(m)           | O(n * k)        |
| Request Dispatch  | O(m)           | O(m)            |

- `m`: Number of segments in the path
- `n`: Number of routes
- `k`: Average segments per route
---