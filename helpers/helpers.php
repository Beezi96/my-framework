<?php

use Core\Application;
use Core\Request;

function app(): Application
{
  return Application::$app;
}

function request(): Request
{
  return app()->request;
}