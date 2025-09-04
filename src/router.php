<?php

/*Single Route Node*/
class RouterNode
{
  public $children = []; // child segment
  public $param = null; // dynamic param
  public $paramName = null;
  public $handlers = []; // request handlers ("GET",..., "ANY");
}

/**
 * Main Router Class
 */
class Router
{
  private $root;
  private $basePath;
  private $viewDir;

  private $notFoundHandler = null;
  private $notAllowedHandler = null;

  public function __construct(array $options = [])
  {
    $this->root = new RouterNode();
    $this->basePath = $options["basePath"];
    $this->viewDir = $options["viewDir"];
  }

  // for http methods
  public function get($path, $handler)
  {
    $this->addRoute("GET", $path, $handler);
  }

  public function post($path, $handler)
  {
    $this->addRoute("POST", $path, $handler);
  }

  public function put($path, $handler)
  {
    $this->addRoute("PUT", $path, $handler);
  }

  public function delete($path, $handler)
  {
    $this->addRoute("DELETE", $path, $handler);
  }

  public function any($path, $handler)
  {
    $this->addRoute("ANY", $path, $handler);
  }

  // extra methods
  public function setNotFound($handler)
  {
    $this->notFoundHandler = $handler;
  }
  public function setMethodNotAllowed($handler)
  {
    $this->notAllowedHandler = $handler;
  }

  // Insert route into trie in O(m)
  // addRoute("GET", "/login", ()=>{})
  private function addRoute($method, $path, $handler)
  {
    $method = strtoupper($method);
    $segments = $this->splitPath($path);
    $node = $this->root;

    foreach ($segments as $seg) {
      if ($seg === '') {
        continue;
      }

      if ($seg[0] === '$') {
        if ($node->param === null) {
          $node->param = new RouterNode();
          $node->param->paramName = substr($seg, 1);
        }
        $node = $node->param;
      } else {
        if (!isset($node->children[$seg])) {
          $node->children[$seg] = new RouterNode();
        }
        $node =  $node->children[$seg];
      }
    }
    $node->handlers[$method] = $handler;
  }

  // match req and exec handler in O(m)
  public function dispatch($uri = null, $method = null)
  {
    // print_r("URI from route dispatch -> " . $uri . "<br>");
    $uri = $uri ?? ($_SERVER["REQUEST_URI"] ?? "/");
    $method = strtoupper($method ?? ($_SERVER["REQUEST_METHOD"] ?? "GET"));

    $path = parse_url($uri, PHP_URL_PATH) ?? "/";
    // print_r("Path from route dispatch --> " . $path . "<br>");

    $base = $this->basePath;
    if ($base === null) {
      $base = rtrim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"] ?? "")), "/");
    }
    // print_r("Base from route dispatch --> " . $base . "<br>");

    if ($base !== "" && $base !== "/" && strpos($path, $base) === 0) {
      $path = substr($path, strlen($base));
    }
    // print_r("Strip path from route dispatch --> " . $path . "<br>");

    $path = "/" . trim($path, "/");
    if ($path === "//") $path = "/";
    // print_r("Clean path --> " . $path . "<br>");

    $segments = $this->splitPath($path);
    // print_r("Segments --> ");
    // foreach ($segments as $s) {
    //   print_r($s . ", ");
    // }
    // print_r("<br>");

    $node = $this->root;
    $params = [];

    foreach ($segments as $seg) {
      if ($seg === "") continue;
      if (isset($node->children[$seg])) {
        $node = $node->children[$seg];
      } elseif ($node->param !== null) { // dynamic param
        $params[$node->param->paramName] = $seg;
        $node = $node->param;
      } else {
        return $this->handleNotFound();
      }
    }

    $handler = $node->handlers[$method] ?? ($node->handlers["ANY"] ?? null);
    if ($handler === null) {
      if (!empty($node->handlers)) {
        return $this->handleMethodNotAllowed(array_keys($node->handlers));
      }
      return $this->handleNotFound();
    }

    if (is_callable($handler)) return call_user_func_array($handler, $params);

    // print_r("fullPath -> " . $handler . "<br>");

    if (is_string($handler)) {
      $fileName = $handler . ".php";
      $fullPath = $this->viewDir . "/" . $fileName;
      if (is_file($fullPath)) return require $fullPath;
      http_response_code(500);
      echo "View file Not Found: " . htmlspecialchars($fullPath) . "<br>";
    }
    http_response_code(500);
    echo "Invalid route <br>";
    return;
  }

  // Not Found Error
  private function handleNotFound()
  {
    if ($this->notFoundHandler) {
      if (is_callable($this->notFoundHandler)) {
        return call_user_func($this->notFoundHandler);
      }
      if (is_string($this->notFoundHandler)) {
        $fileName = $this->notFoundHandler . ".php";
        $fullPath = $this->viewDir . "/" . $fileName;
        if (is_file($fullPath)) return require $fullPath;
      }
    }
    http_response_code(404);
    return;
  }

  // Not Allowed Error
  private function handleMethodNotAllowed($allowed)
  {
    http_response_code(405);
    header("Allow: " . implode(", ", $allowed));
    if ($this->notAllowedHandler && is_callable($this->notAllowedHandler)) {
      return call_user_func($this->notAllowedHandler, $allowed);
    }
    echo "MEthod Now ALlowed";
    return;
  }

  private function splitPath($path)
  {
    $p = trim($path, "/");
    if ($p === '') return [];
    return explode("/", $p);
  }
}
