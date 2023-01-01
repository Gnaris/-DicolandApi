<?php

use Slim\Routing\RouteCollectorProxy as Group;
use App\Controller\UserController;

$app->group("/api/user", function(Group $group){
    $group->group("", function(Group $group2){
        $group2->get("[/{id:.*}]", UserController::class . ':getUsers');
        $group2->delete("[/{id:.*}]", UserController::class . ':deleteUsers');
        $group2->put("/{id}", UserController::class . ':updateUser');
    })->add(new App\Middleware\AuthentificationRequired());

    $group->post("/register", UserController::class . ':register')->add(new App\Middleware\Register());
    $group->post("/login", UserController::class . ':login')->add(new App\Middleware\Login());
});



?>