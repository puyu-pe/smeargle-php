<?php

namespace PuyuPe\Smeargle\blocks\style;

class Smg
{
    public static function center(): SmgStyle
    {
        return SmgStyle::builder()->center();
    }

    public static function left(): SmgStyle
    {
        return SmgStyle::builder()->left();
    }

    public static function right(): SmgStyle
    {
        return SmgStyle::builder()->right();
    }

    public static function bold(bool $bold = true): SmgStyle
    {
        return SmgStyle::builder()->bold($bold);
    }

    public static function normalize(bool $normalize = false): SmgStyle
    {
        return SmgStyle::builder()->normalize($normalize);
    }

    public static function fontWidth(int $fontWidth): SmgStyle
    {
        return SmgStyle::builder()->fontWidth($fontWidth);
    }

    public static function fontHeight(int $fontHeight): SmgStyle
    {
        return SmgStyle::builder()->fontHeight($fontHeight);
    }

    public static function fontSize(int $fontSize): SmgStyle
    {
        return SmgStyle::builder()->fontSize($fontSize);
    }

    public static function bgInverted(bool $bgInverted): SmgStyle
    {
        return SmgStyle::builder()->bgInverted($bgInverted);
    }

    public static function pad(string $char): SmgStyle
    {
        return SmgStyle::builder()->pad($char);
    }

    public static function span(int $span): SmgStyle
    {
        return SmgStyle::builder()->charxels($span);
    }

    public static function maxSpan(): SmgStyle
    {
        return SmgStyle::builder()->auto();
    }

    public static function leftBold(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold();
    }

    public static function rightBold(): SmgStyle
    {
        return SmgStyle::builder()->right()->bold();
    }

    public static function centerBold(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold();
    }

    public static function centerMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->center()->auto();
    }

    public static function leftMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->left()->auto();
    }

    public static function rightMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->right()->auto();
    }

    public static function leftBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->auto();
    }

    public static function rightBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->right()->bold()->auto();
    }

    public static function centerBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->auto();
    }

    public static function ifElse(bool $flag, SmgStyle $true, SmgStyle $false): SmgStyle
    {
        return $flag ? $true : $false;
    }

    public static function if(bool $flag, SmgStyle $true): ?SmgStyle
    {
        return $flag ? $true : null;
    }

    public static function title(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->fontSize(2)->auto();
    }

    public static function subtitle(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->auto();
    }
}
