<?php

/*
 * This file is part of the HTMLUP package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc;

trait HtmlHelper
{
    public function escape($input)
    {
        return \htmlspecialchars($input);
    }

    public function h($level, $line)
    {
        if (\is_string($level)) {
            $level = \trim($level, '- ') === '' ? 2 : 1;
        }

        if ($level < 7) {
            return "\n<h{$level}>" . \ltrim(\ltrim($line, '# ')) . "</h{$level}>";
        }

        return '';
    }

    public function hr($prevLine, $line)
    {
        if ($prevLine === '' && \preg_match(BlockElementParser::RE_MD_RULE, $line)) {
            return "\n<hr />";
        }
    }

    public function codeStart($lang)
    {
        $lang = isset($lang[1])
            ? ' class="language-' . $lang[1] . '"'
            : '';

        return "\n<pre><code{$lang}>";
    }

    public function codeLine($line, $isBlock, $indentLen = 4)
    {
        $code  = "\n"; // @todo: donot use \n for first line
        $code .= $isBlock ? $line : \substr($line, $indentLen);

        return $code;
    }

    public function tableStart($line, $delim = '|')
    {
        $table = "<table>\n<thead>\n<tr>\n";

        foreach (\explode($delim, \trim($line, $delim)) as $hdr) {
            $table .= '<th>' . \trim($hdr) . "</th>\n";
        }

        $table .= "</tr>\n</thead>\n<tbody>\n";

        return $table;
    }

    public function tableRow($line, $colCount, $delim = '|')
    {
        $row = "<tr>\n";

        foreach (\explode($delim, \trim($line, $delim)) as $i => $col) {
            if ($i > $colCount) {
                break;
            }

            $col  = \trim($col);
            $row .= "<td>{$col}</td>\n";
        }

        $row .= "</tr>\n";

        return $row;
    }
}
