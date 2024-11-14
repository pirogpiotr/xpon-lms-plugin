<?php
/** @noinspection PhpUnused */

namespace XponLmsPlugin\Debug;

class Performance
{
    const PART_USERSHOW = 'usershow';
    const PART_GETONTLIST = 'getontlist';
    const PART_GETOLTLIST = 'getoltlist';

    /** @var static */
    private static $instance;

    /** @var float[] */
    private $timeStart = [];

    /** @var float[] */
    private $timeStop = [];

    /** @var float[] */
    private $timeResult = [];

    public function __construct()
    {
    }

    /**
     * @param $partName
     * @return float
     */
    public function startPart($partName)
    {
        $this->timeStart[$partName] = microtime(true);
        $this->timeStop[$partName] = null;

        return $this->timeStart[$partName];
    }

    /**
     * @param $partName
     * @return float
     */
    public static function start($partName)
    {
        return static::getInstance()->startPart($partName);
    }

    /**
     * @param $partName
     * @return float Zwraca różnicę
     */
    public function stopPart($partName)
    {
        $this->timeStop[$partName] = microtime(true);
        $this->timeResult[$partName] = $this->timeStop[$partName] - $this->timeStart[$partName];

        return $this->timeResult[$partName];
    }

    /**
     * @param $partName
     * @return float Zwraca różnicę
     */
    public static function stop($partName)
    {
        return static::getInstance()->stopPart($partName);
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @return float[]
     */
    public function &getResults()
    {
        return $this->timeResult;
    }

}
