<?php

namespace PuyuPe\Smeargle\util;

use PuyuPe\Smeargle\properties\SmgProperties;
use PuyuPe\Smeargle\styles\SmgScale;
use PuyuPe\Smeargle\styles\SmgStyle;

class Smg
{

    public static function blockWidth(int $charxels): SmgProperties
    {
        return SmgProperties::builder()->setBlockWidth($charxels);
    }

    public static function center(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->center()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function left(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->left()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function right(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->right()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function bold(?bool $value = true): SmgStyle
    {
        return SmgStyle::builder()->bold($value);
    }

    public static function normalize(?bool $value = true): SmgStyle
    {
        return SmgStyle::builder()->normalize($value);
    }

    public static function fontWidth(?int $value): SmgStyle
    {
        return SmgStyle::builder()->fontWidth($value);
    }

    public static function fontHeight(?int $value): SmgStyle
    {
        return SmgStyle::builder()->fontHeight($value);
    }

    public static function fontSize(?int $value): SmgStyle
    {
        return SmgStyle::builder()->fontSize($value);
    }

    public static function bgInverted(?bool $value = true): SmgStyle
    {
        return SmgStyle::builder()->bgInverted($value);
    }

    public static function pad(?string $char): SmgStyle
    {
        return SmgStyle::builder()->pad($char);
    }

    public static function charxels(?int $value): SmgStyle
    {
        return SmgStyle::builder()->charxels($value);
    }

    public static function width(?int $value): SmgStyle
    {
        return SmgStyle::builder()->width($value);
    }

    public static function height(?int $value): SmgStyle
    {
        return SmgStyle::builder()->height($value);
    }

    public static function size(?int $value): SmgStyle
    {
        return SmgStyle::builder()->size($value);
    }

    public static function scale(?SmgScale $value): SmgStyle
    {
        return SmgStyle::builder()->scale($value);
    }

    public static function charCode(?string $value): SmgStyle
    {
        return SmgStyle::builder()->charCode($value);
    }

    public static function leftBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function rightBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->right()->bold()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function centerBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->ifThen($charxels !== null, Smg::charxels($charxels));
    }

    public static function ifThen(bool $flag, SmgStyle $trueStyle): SmgStyle
    {
        return SmgStyle::builder()->ifThen($flag, $trueStyle);
    }

    public static function ifElse(bool $flag, SmgStyle $trueStyle, SmgStyle $falseStyle): SmgStyle
    {
        return SmgStyle::builder()->ifElse($flag, $trueStyle, $falseStyle);
    }

    public static function title(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->fontSize(2)->charxels(1000);
    }

    public static function subtitle(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->charxels(1000);
    }
}
