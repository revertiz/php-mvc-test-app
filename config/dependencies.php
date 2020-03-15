<?php
use Kodas\Core\Container;
use Kodas\Model\Client;
use Kodas\Model\Specialist;
use Kodas\Model\TimeManager;

$container = new Container();

$container->set(
    TimeManager::class,
    function() {
        return new TimeManager();
    }
    )
    ->set(
        Client::class,
        function(Container $container) {
            return new Client(TimeManager::class);
        }

    )
    ->set(
        Specialist::class,
        function(Container $container) {
            return new Specialist(TimeManager::class);
        }
    );
