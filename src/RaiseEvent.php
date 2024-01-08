<?php

namespace Bytic\EventDiscovery;

use Psr\EventDispatcher\EventDispatcherInterface;

class RaiseEvent
{

    protected ?EventDispatcherInterface $dispatcher = null;

    /**
     * @param EventDispatcherInterface|null $dispatcher
     */
    public function __construct(?EventDispatcherInterface $dispatcher = null)
    {
        $this->dispatcher = $dispatcher ?? EventDispatcherDiscovery::find();
    }

    /**
     * @param $event
     * @param ...$params
     * @return void
     */
    public static function dispatch($event, ...$params): void
    {
        self::instance()->tryToDispatchEvent(
            self::instantiateEvent($event, $params),
            false
        );
    }

    public static function dispatchOrFail($event, ...$params): void
    {
        self::instance()->tryToDispatchEvent(
            self::instantiateEvent($event, $params),
            true
        );
    }

    /**
     * @param $event
     * @param $params
     * @return mixed
     */
    protected static function instantiateEvent($event, $params)
    {
        return is_object($event) ? $event : new $event(...$params);
    }

    /**
     * @param $event
     * @return void
     */
    protected function tryToDispatchEvent($event, $throwException = true): void
    {
        if ($this->dispatcher === null) {
            if ($throwException) {
                EventDispatcherDiscovery::throwNotFoundException();
            } else {
                return;

            }
        }
        $this->dispatcher->dispatch($event);
    }

    /**
     * Singleton
     *
     * @return self
     */
    public static function instance()
    {
        static $instance;
        if (!($instance instanceof self)) {
            $instance = new self();
        }
        return $instance;
    }
}