<?php

namespace App\FragmentHandlers;

use App\Models\Article;
use App\Models\ArticleFragment;
use RuntimeException;

class TableFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['rows'] as $row) {
            $content .= '<tr>';
            foreach ($row as $cell) {
                $type = $cell['fragment'];
                $handler = FragmentHandler::getHandlerForType($type);
                $content .= '<td class="border border-gray-300 px-1.5 py-0.5">' . $handler::getMarkup($cell) . '</td>';
            }
            $content .= '</tr>';
        }
        return '<table class="min-w-full divide-y divide-gray-200 table-auto">' . $content . '</table>';
    }

}
