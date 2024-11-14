<?php


namespace XponLmsPlugin\Lib;

use DateInterval;
use DateTime;
use Exception;
use RuntimeException;
use Smarty_Internal_Template;

class Helper
{

    /**
     * @param $datetime
     * @return string|null
     */
    public static function dateDiffShort($datetime)
    {
        if ($datetime == '') {
            return null;
        }

        try {
            $date = new DateTime("$datetime");
            $nowdate = new DateTime();
        } catch (Exception $e) {
            return null;
        }

        $interval = $nowdate->diff($date);

        return self::formatIntervalShort($interval);
    }

    /**
     * @param $interval
     * @return string
     */
    public static function intervalDiffShort($interval)
    {
        try {
            $interval = (new DateTime('@0'))->diff(new DateTime("@$interval"));
        } catch (Exception $e) {
            return null;
        }

        return static::formatIntervalShort($interval);
    }

    /**
     * @param DateInterval $interval
     * @return string
     */
    public static function formatIntervalShort(DateInterval $interval)
    {
        $days = $interval->format('%a');

        if ($days > 60) {
            $months = floor($days / 30);
            $days = $days % 30;
            return "{$months}mies. {$days}d";
        } elseif ($days > 0) {
            return "" . $days . "d";
        } elseif ($interval->h > 0) {
            return "" . $interval->h . "h";
        } elseif ($interval->i > 0) {
            return "" . $interval->i . "m";
        } else {
            return "" . $interval->s . "s";
        }
    }

    /**
     * @param int $ifIndex
     * @return int[] [frameId, slotId, portId]
     * @noinspection PhpUnused @smarty
     */
    public static function decodeHuaweiIfIndex($ifIndex)
    {
        $frameId = 0;
        $slotId = ($ifIndex & 0x3E000) >> 13;
        $portId = ($ifIndex & 0x1F00) >> 8;

        return [$frameId, $slotId, $portId];
    }

    /**
     * @param $params
     * @param Smarty_Internal_Template $smarty
     * @return string
     * @throws RuntimeException
     */
    public static function printListHeader($params, Smarty_Internal_Template $smarty)
    {
        $nameArray = array_key_exists('name', $params) ? $params['name'] : 'default name';
        if (!is_array($nameArray)) {
            $nameArray = [$nameArray];
        }
        $display = array_key_exists('display', $params) ? $params['display'] : 'default display';

        /** @var Page $page */
        $page = $smarty->getTemplateVars(Page::KEY_PAGE);
        if (!$page || !$page instanceof Page || !($pager = $page->getPager()) instanceof Pager) {
            throw new RuntimeException("Smarty_plugin::printListHeader(): page not found");
            // return "no page object";
            // return $display;
        }

        $sortByCurrent = false;
        if (implode(',', $nameArray) === str_replace('-', '', $pager->getSort())) {
            $sortByCurrent = true;
        }

        $direction = $pager->getFirstDirection();

        if ($sortByCurrent) {
            foreach ($nameArray as &$name) {
                $name = ($direction ? '' : '-') . $name;
            }
        }

        $sortStr = implode(',', $nameArray);

        $html = "<a href='{$pager->getUrlWithParams([XponApiHelper::KEY_SORT => $sortStr])}'>$display</a>";
        if ($sortByCurrent) {
            $html .= ' <img src="img/' . ($direction ? 'asc' : 'desc') . '_order.gif">';
        }

        return $html;
    }
}
