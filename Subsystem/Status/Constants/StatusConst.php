<?php

namespace Subsystem\Status\Constants;

use Illuminate\Support\Arr;

/**
 * StatusConst
 *
 * @category Constants
 * @package  Subsystem\Status
 * @author   Allen Jay Desamparado <allen.desamparado@monstar-lab.com>
 */
final class StatusConst
{
    const COMPLETED_STATUS_ID = 2;
    const COMPLETED_STATUS_TEXT = 'completed';

    const INCOMPLETE_STATUS_ID = 1;
    const INCOMPLETE_STATUS_TEXT = 'incomplete';

    const VALUES = [
        self::COMPLETED_STATUS_ID => self::COMPLETED_STATUS_TEXT,
        self::INCOMPLETE_STATUS_ID => self::INCOMPLETE_STATUS_TEXT,
    ];

    /**
     * getText
     *
     * @param int $id
     *
     * @return string
     */
    public static function getText(int $id): string
    {
        return Arr::get(self::VALUES, $id);
    }

    /**
     * getId
     *
     * @param string $text

     * @return int
     */
    public static function getId(string $text): int
    {
        return Arr::get(array_flip(self::VALUES), $text);
    }
}
