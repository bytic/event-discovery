<?php

namespace Bytic\EventDiscovery;

use Bytic\EventDiscovery\Exception\DiscoveryFailedException;
use Bytic\EventDiscovery\Exception\NotFoundException;

class EventDispatcherDiscovery
{
    public static function find()
    {
         try {
            return self::detectDispatcher();
        } catch (DiscoveryFailedException $exception) {
             return null;
        }
    }
    public static function findOrFail()
    {
        try {
            return self::detectDispatcher();
        } catch (DiscoveryFailedException $exception) {
            static::throwNotFoundException();
        }
    }

    public static function throwNotFoundException()
    {
        throw new NotFoundException(
            'No HTTPlug clients found. Make sure to install a package providing "php-http/client-implementation". Example: "php-http/guzzle6-adapter".',
            0,
        );
    }

    protected static function detectDispatcher()
    {
        if (app()->has('events')) {
            return app('events');
        }

        throw new DiscoveryFailedException();
    }
}
