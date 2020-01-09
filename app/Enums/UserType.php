<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UserType extends Enum
{
    const PERFORMER =   1;
    const VENUE =   2;
    public static $types = [self::PERFORMER, self::VENUE];
}
