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
     * Validate the test item has everything it needs
     *
     * @throws \Exception
     */
    public function validate()
    {
        if (count($this->getDistractorCollection()->toArray()) < 3) {
            throw new \Exception('An issue was encountered with the following text: ' . $this->stem . '.  Please check this file for leading and trailing spaces. No items were imported.');
        }

        if (empty($this->stem)) {
            throw new \Exception('Your Items were not imported.  A question is missing a stem. Please review the format of your Aiken file and upload again.');
        }

        if (empty($this->correctAnswer)) {
            throw new \Exception('Your Items were not imported.  This question does not have a correct answer.  Check to make sure the distractors do not have any extra space before or after the beginning letter. Look at the item with STEM: ' . $this->stem);
        }
    }

    /**
     * Validate that a test item does not have too many distractors
     *
     * @throws \Exception
     */
    public function validateDoesNotHaveTooManyDistractors()
    {
        if (count($this->getDistractorCollection()->toArray()) > 4) {
            throw new \Exception('An issue was encountered with the following text: ' . $this->stem . '.  This stem has too many distractors. Check that an ANSWER is not missing from previous test item.');
        }
    }

    /**
     * Return object as array
     *
     * @return array
     * @throws \Exception
     */
    public function toArray()
    {
        $this->validate();

        return [
            self::STEM          => $this->stem,
            self::DISTRACTORS   => $this->getDistractorCollection()->toArray(),
            self::CORRECT_ANSWER => $this->correctAnswer,
        ];
    }
}
