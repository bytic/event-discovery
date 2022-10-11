<?php

namespace Bytic\EventDiscovery\Exception;

/**
 * Thrown when a discovery does not find any matches.
 */
class NotFoundException extends \RuntimeException implements Exception
{
}