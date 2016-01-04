<?php namespace Fisdap\Aiken\Parser;

use Fisdap\Aiken\Parser\Contracts\Arrayable;

/**
 * Class TestItemCollection
 *
 * Collection of test item objects
 *
 * @package Fisdap\Aiken\Parser
 * @author Jason Michels <jmichels@fisdap.net>
 * @version $Id$
 */
class TestItemCollection implements Arrayable
{
    /**
     * @var TestItem[]
     */
    protected $testItems = [];

    /**
     * Append a new test item to the test item collection
     *
     * @param TestItem $item
     * @return $this
     */
    public function append(TestItem $item)
    {
        $this->testItems[] = $item;
        return $this;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->testItems as $testItem) {
            $data[] = $testItem->toArray();
        }

        return $data;
    }
}
