<?php namespace Fisdap\Aiken\Parser;

use Fisdap\Aiken\Parser\Contracts\Arrayable;

/**
 * Class DistractorCollection
 *
 * A collection of distractors
 *
 * @package Fisdap\Aiken\Parser
 * @author Jason Michels <jmichels@fisdap.net>
 * @version $Id$
 */
class DistractorCollection implements Arrayable
{
    /**
     * @var Distractor[]
     */
    protected $distractors = [];

    /**
     * Append distractor to collection
     *
     * @param Distractor $distractor
     * @return $this
     */
    public function append(Distractor $distractor)
    {
        $this->distractors[] = $distractor;
        return $this;
    }

    /**
     * Get the correct answer value
     *
     * @param $key
     * @return string
     * @throws \Exception
     */
    public function getCorrectAnswerValue($key)
    {
        foreach ($this->distractors as $distractor) {
            if ($distractor->key == $key) {
                return $distractor->value;
            }
        }

        throw new \Exception('Unable to match correct answer ' . $key . ' to distractors');
    }

    /**
     * Return object as array of values
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];

        foreach ($this->distractors as $distractor) {
            $data[] = $distractor->value;
        }

        return $data;
    }
}
