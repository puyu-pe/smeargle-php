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

    public static function bold(): SmgStyle
    {
        return SmgStyle::builder()->bold();
    }

    public static function normalize(): SmgStyle
    {
        return SmgStyle::builder()->normalize();
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

    public static function bgInverted(): SmgStyle
    {
        return SmgStyle::builder()->bgInverted();
    }

    public static function pad(string $char): SmgStyle
    {
        return SmgStyle::builder()->pad($char);
    }

    public static function span(int $span): SmgStyle
    {
        return SmgStyle::builder()->span($span);
    }

    public static function maxSpan(): SmgStyle
    {
        return SmgStyle::builder()->maxSpan();
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
        return SmgStyle::builder()->center()->maxSpan();
    }

    public static function leftMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->left()->maxSpan();
    }

    public static function rightMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->right()->maxSpan();
    }

    public static function leftBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->maxSpan();
    }

    public static function rightBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->right()->bold()->maxSpan();
    }

    public static function centerBoldMaxSpan(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->maxSpan();
    }

    public static function title(): SmgStyle
    {
        return SmgStyle::builder()->center()->bold()->fontSize(2)->maxSpan();
    }

    public static function subtitle(): SmgStyle
    {
        return SmgStyle::builder()->left()->bold()->maxSpan();
    }
}
