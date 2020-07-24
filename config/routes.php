<?php

declare(strict_types = 1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController::index');
Router::addRoute(['GET', 'POST', 'HEAD'], '/miniprogram', 'App\Controller\IndexController::miniprogram');
Router::addRoute(['GET', 'POST', 'HEAD'], '/log', 'App\Controller\IndexController::log');
/* ------------------- Rpc服务调用 -----------------------------*/
Router::addGroup('/rpc/', function ()
{
    Router::get('session', 'App\Controller\RpcController@session');
    Router::get('phone', 'App\Controller\RpcController@phone');
    Router::get('getFewQrCode', 'App\Controller\RpcController@getFewQrCode');
    Router::get('getUnlimitQrCode', 'App\Controller\RpcController@getUnlimitQrCode');
    Router::get('getQrCode', 'App\Controller\RpcController@getQrCode');
}, [
    //Middleware
]);
