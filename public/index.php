<?php

use Shop\Controller\ProductController;

if (!is_file(dirname(__DIR__).'/vendor/autoload.php'))
{
    throw new LogicException('Runtime file is missing.');
}

require_once dirname(__DIR__).'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (! isset($_REQUEST['id']) || !is_numeric($_REQUEST['id']))
{
    echo('ID in the request is required. Please call with ID param, e.g. localhost/product?id=1');
    exit;
}

try
{
    $productController = new ProductController();
    $productDetail = $productController->detail((int)$_REQUEST['id']);
    header('Content-Type: application/json; charset=utf-8');
    echo $productDetail;
    exit;
}
catch (Throwable $throwable)
{
    die($throwable->getMessage());
}
