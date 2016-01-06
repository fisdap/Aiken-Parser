<?php namespace Fisdap\Aiken\Parser;

use Fisdap\Aiken\Parser\Contracts\Arrayable;

/**
 * Class TestItem
 *
 * Class representing a single test item
 *
 * @package Fisdap\Aiken\Parser
 * @author Jason Michels <jmichels@fisdap.net>
 * @version $Id$
 */
class TestItem implements Arrayable
{
    const STEM = 'stem';
    const CORRECT_ANSWER = 'correctAnswer';
    const DISTRACTORS = 'distractors';

    const CORRECT_ANSWER_LINE_DETECTOR_SLUG = 'ANSWER: ';
    const CORRECT_ANSWER_LINE_DETECTOR_SLUG_SPANISH = 'RESPUESTA: ';
    const DISTRACTOR_A_LINE_DETECTOR_SLUG = 'A. ';
    const DISTRACTOR_B_LINE_DETECTOR_SLUG = 'B. ';
    const DISTRACTOR_C_LINE_DETECTOR_SLUG = 'C. ';
    const DISTRACTOR_D_LINE_DETECTOR_SLUG = 'D. ';

    /**
     * Correct answer detector slugs
     *
     * @var array
     */
    public static $correctAnswerDetectorSlugs = [
        self::CORRECT_ANSWER_LINE_DETECTOR_SLUG,
        self::CORRECT_ANSWER_LINE_DETECTOR_SLUG_SPANISH
    ];

    /**
     * Keys used to define distractors from the answer
     *
     * @var array
     */
    public static $distractorDetectorSlugs = [
        self::DISTRACTOR_A_LINE_DETECTOR_SLUG => 'A',
        self::DISTRACTOR_B_LINE_DETECTOR_SLUG => 'B',
        self::DISTRACTOR_C_LINE_DETECTOR_SLUG => 'C',
        self::DISTRACTOR_D_LINE_DETECTOR_SLUG => 'D'
    ];

    /**
     * Test item stem
     *
     * @var string
     */
    protected $stem;

    /**
     * Test item distractor collection
     *
     * @var DistractorCollection
     */
    private $distractors;

    /**
     * Test item correct answer
     *
     * @var string
     */
    protected $correctAnswer;

    /**
     * Get collection of distractors object
     *
     * @return DistractorCollection
     */
    protected function getDistractorCollection()
    {
        if (!$this->distractors) {
            $this->distractors = new DistractorCollection();
        }
        return $this->distractors;
    }

    /**
     * Append a distractor to the array
     *
     * @param Distractor $distractor
     * @return $this
     */
    public function appendDistractor(Distractor $distractor)
    {
        $this->getDistractorCollection()->append($distractor);
        return $this;
    }

    /**
     * Set the test item stem
     *
     * @param $stem
     * @return $this
     */
    public function setStem($stem)
    {
        $this->stem = $stem;
        return $this;
    }

    /**
     * Set the correct answer
     *
     * @param $answerKey
     * @return $this
     * @throws \Exception
     */
    public function setCorrectAnswer($answerKey)
    {
        $this->correctAnswer = $this->getDistractorCollection()->getCorrectAnswerValue($answerKey);
        return $this;
    }

    /**
     * Return object as array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::STEM          => $this->stem,
            self::DISTRACTORS   => $this->getDistractorCollection()->toArray(),
            self::CORRECT_ANSWER => $this->correctAnswer,
        ];
    }
}
