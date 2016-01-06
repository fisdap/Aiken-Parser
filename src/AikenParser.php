<?php namespace Fisdap\Aiken\Parser;

/**
 * Class AikenParser
 *
 * Parse aiken file and return test item collection
 *
 * @package Fisdap\Aiken\Parser
 * @author Jason Michels <jmichels@fisdap.net>
 * @version $Id$
 */
class AikenParser
{
    /**
     * Location of the file to parse into array
     *
     * @var string
     */
    private $file;

    /**
     * @var TestItemCollection
     */
    private $testItemCollection;

    /**
     * AikenParser constructor.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Build the test item collection and return it
     *
     * @return TestItemCollection
     */
    public function buildTestItemCollection()
    {
        if (!$this->testItemCollection) {

            $this->testItemCollection = new TestItemCollection();
            $testItem = new TestItem();

            $lines = file($this->file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {

                if ($this->isCorrectAnswer($line)) {
                    $testItem->setCorrectAnswer($this->parseCorrectAnswerKey($line));

                    $this->testItemCollection->append($testItem);

                    $testItem = new TestItem();

                } elseif ($this->isDistractor($line)) {
                    $testItem->appendDistractor($this->parseDistractor($line));
                } else {
                    $testItem->setStem($line);
                }
            }
        }

        return $this->testItemCollection;
    }

    /**
     * Check if this line is the correct answer line
     *
     * @param string $line
     * @return bool
     */
    protected function isCorrectAnswer($line)
    {
        foreach (TestItem::$correctAnswerDetectorSlugs as $slug) {
            if (strpos($line, $slug) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Parse the correct answer from the line
     *
     * @param $line
     * @return string
     * @throws \Exception
     */
    protected function parseCorrectAnswerKey($line)
    {
        foreach (TestItem::$correctAnswerDetectorSlugs as $slug) {
            if (strpos($line, $slug) === 0) {
                return trim(substr($line, strlen($slug)));
            }
        }

        throw new \Exception('Unable to parse the correct answer from this line: ' . $line);
    }

    /**
     * Check if the line is a distractor
     *
     * @param string $line
     * @return bool
     */
    protected function isDistractor($line)
    {
        foreach (TestItem::$distractorDetectorSlugs as $key => $value) {
            if (strpos($line, $key) === 0) {
                return true;
            }
        }
        return false;
    }

    /**
     * Parse the distractor from the line
     *
     * @param string $line
     * @return Distractor
     */
    protected function parseDistractor($line)
    {
        $key = substr($line, 0, 3);
        $value = trim(substr($line, 3));

        return new Distractor(TestItem::$distractorDetectorSlugs[$key], $value);
    }
}
