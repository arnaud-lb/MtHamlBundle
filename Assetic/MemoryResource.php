<?php

namespace MtHamlBundle\Assetic;

use Assetic\Factory\Resource\ResourceInterface;

/**
 * A resource is something formulae can be loaded from.
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class MemoryResource implements ResourceInterface
{
    private $uniqueString;
    private $content;
    private $freshFunction;

    /**
     * Constructor.
     *
     * @param string   $uniqueString  The unique string identifier
     * @param string   $content       The content
     * @param callable $freshFunction The function to check if a timestamp represents the latest resource
     */
    public function __construct($uniqueString, $content, $freshFunction)
    {
        $this->uniqueString = $uniqueString;
        $this->content = $content;
        $this->freshFunction = $freshFunction;
    }

    public function isFresh($timestamp)
    {
        return is_callable($this->freshFunction) ? call_user_func($this->freshFunction, $timestamp) : false;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->uniqueString;
    }
}
