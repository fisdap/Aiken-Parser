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
        for ($i = 0; $i < count($this->distractors); $i++) {
            if ($this->distractors[$i]->key == $key) {
                $value = $this->distractors[$i]->value;

                unset($this->distractors[$i]);

                return $value;
            }
        }

        $implodedDistractors = implode(' : ', $this->toArray());

        throw new \Exception('Your Items were not imported.  Unable to match correct answer ' . $key . ' to distractors. An issue exists with the question that has these distractors: ' . $implodedDistractors);
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
