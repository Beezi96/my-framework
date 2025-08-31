<?php

namespace App\Controllers;

class HomeController
{
  public function test()
  {
    return 'Test page';
  }

  public function contact()
  {
    return 'Contact page';
  }

  public function hello(string $name)
  {
    return 'Hello, ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
  }

}