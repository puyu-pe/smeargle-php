<?php

namespace PuyuPe\Smeargle\blocks\style;

class Smg
{
    public static function center(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->center()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function left(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->left()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function right(?int $charxels = 0): SmgStyle
    {
        return SmgStyle::builder()->right()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function bold(bool $value = true, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->bold($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function normalize(bool $value = false, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->normalize($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function fontWidth(int $value, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->fontWidth($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function fontHeight(int $value, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->fontHeight($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function fontSize(int $value, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->fontSize($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function bgInverted(bool $value = true, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->bgInverted($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function pad(string $char, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->pad($char)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function charxels(int $value): SmgStyle
    {
        return SmgStyle::builder()->charxels($value);
    }

    public static function width(int $value): SmgStyle
    {
        return SmgStyle::builder()->width($value);
    }

    public static function height(int $value): SmgStyle
    {
        return SmgStyle::builder()->height($value);
    }

    public static function size(int $value): SmgStyle
    {
        return SmgStyle::builder()->size($value);
    }

    public static function scale(SmgScale $value): SmgStyle
    {
        return SmgStyle::builder()->scale($value);
    }

    public static function charCode(string $value, ?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->charCode($value)->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function leftBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function rightBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->right()->bold()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function centerBold(?int $charxels = null): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->if($charxels !== null, Smg::charxels($charxels));
    }

    public static function if(bool $flag, SmgStyle $trueStyle): SmgStyle
    {
        return SmgStyle::builder()->if($flag, $trueStyle);
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
