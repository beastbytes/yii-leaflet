<?php
/**
 * @copyright Copyright © 2022 BeastBytes - All rights reserved
 * @license BSD 3-Clause
 */

declare(strict_types=1);

namespace BeastBytes\Widgets\Leaflet;

/**
 * @author Chris Yates
 */
trait EventsTrait
{
    /**
     * @var array Events
     * An event is in the format $name => $handler
     * $handler is either: string - the event handler; the method is 'on'
     *                     array - ['once' => bool, 'handler' => string]; if 'once' is set and true, the 'once'
     * method is used, else the method is 'on'
     */
    private array $events = [];

    /**
     * Returns a new instance with the events added
     *
     * @param array<string, array|string> $events Events for the object
     * @return \BeastBytes\Widgets\Leaflet\EventsTrait|\BeastBytes\Widgets\Leaflet\Component|\BeastBytes\Widgets\Leaflet\Map
     */
    public function events(array $events): self
    {
        $new = clone $this;
        foreach ($events as $name => $handler) {
            $new->events[$name] = $handler;
        }
        return $new;
    }

    /**
     * @internal
     */
    public function events2Js(): string
    {
        $js = '';

        foreach ($this->events as $name => $handler) {
            if (is_array($handler)) {
                $method = (isset($handler['once']) && $handler['once'] ? 'once' : 'on');
                $handler = $handler['handler'];
            } else {
                $method = 'on';
            }

            $js .= ".$method(\"$name\",$handler)";
        }

        return $js;
    }
}