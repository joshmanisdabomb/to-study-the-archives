<?php

namespace App\Handlers\Fragment;

use Symfony\Component\VarDumper\Cloner\AbstractCloner;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

class TableFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        $content = '';
        foreach ($fragment['rows'] as $row) {
            $content .= '<tr>';
            foreach ($row['cells'] as $cell) {
                $heading = $cell['heading'] ?? null;
                $tag = $heading ? 'th' : 'td';
                $content .= '<' . $tag . ' class="border border-gray-300 px-1.5 py-0.5">';
                foreach ($cell['fragments'] as $fragment) {
                    $type = $fragment['fragment'];
                    $handler = FragmentHandler::getHandlerForType($type);
                    if (class_exists($handler)) {
                        $content .= '<p>' . $handler::getMarkup($fragment) . '</p>';
                    } else {
                        $cloner = new VarCloner();
                        $dumper = new HtmlDumper();

                        $dumper->dump(
                            $cloner->cloneVar($fragment),
                            function ($line, $depth) use (&$content) {
                                if ($depth >= 0) $content .= str_repeat('  ', $depth).$line."\n";
                            }
                        );
                    }
                }
                $content .= '</' . $tag . '>';
            }
            $content .= '</tr>';
        }
        return '<table class="min-w-full divide-y divide-gray-200 table-auto">' . $content . '</table>';
    }

}
