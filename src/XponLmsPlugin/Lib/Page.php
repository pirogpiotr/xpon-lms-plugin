<?php


namespace XponLmsPlugin\Lib;


use Exception;
use InvalidArgumentException;
use Smarty;
use SmartyException;

class Page
{
    const KEY_PAGE = 'xponPage';

    /** @var Smarty */
    protected $smarty;

    /** @var string */
    protected $template;

    /** @var array */
    protected $smartyVars = [];

    /** @var Exception */
    protected $exception;

    /** @var string */
    protected $errorMessage;

    /** @var Pager */
    protected $pager;

    public function __construct(Smarty $smarty)
    {
        $this->smarty = $smarty;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return static
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * @return Exception
     * @noinspection PhpUnused @smarty
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param Exception $exception
     * @return static
     */
    public function setException(Exception $exception)
    {
        $this->exception = $exception;
        return $this;
    }

    /**
     * @return string
     * @noinspection PhpUnused @smarty
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return static
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return Pager
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * @param Pager $pager
     * @return static
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
        return $this;
    }

    /**
     * @param mixed ...$args
     * @throws InvalidArgumentException
     */
    public function assign(...$args)
    {
        $count = count($args);
        if ($count < 1) {
            throw new InvalidArgumentException(__FUNCTION__ . " count(argument) < 1");
        } elseif ($count == 1 && is_array($args[0])) {
            foreach ($args[0] as $key => $val) {
                $this->smartyVars[$key] = $val;
            }
        } elseif ($count == 2) {
            if (!is_scalar($args[0])) {
                throw new InvalidArgumentException(__FUNCTION__ . " argument0 type error");
            }
            $this->smartyVars[$args[0]] = $args[1];
        } else {
            throw new InvalidArgumentException(__FUNCTION__ . " argument error");
        }
    }

    protected function getSmarty()
    {
        return $this->smarty;
    }

    /**
     * @throws SmartyException
     */
    public function display()
    {
        $this->getSmarty()
            ->assign($this->smartyVars)
            ->assign(self::KEY_PAGE, $this)
            ->display($this->getTemplate());
    }
}
