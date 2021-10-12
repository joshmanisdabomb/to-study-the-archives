<?php

namespace App\Handlers\Fragment;

use App\Models\Ingredient;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class LootFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        if (count($fragment['tables']) < 1) return 'No recipes.';
        $content = '';
        foreach ($fragment['tables'] as $table) {
            $tab = static::getTabMarkup($table);
            $tab = $tab ? ('<div class="gui-tab">' . $tab . '</div>') : '';
            $markup = static::getTableMarkup($table);
            $content .= '<div class="my-2 gui' . (($fragment['obsolete'] ?? false) ? ' gui-transparent' : '') . ' md:justify-start justify-center items-center flex-wrap md:flex-nowrap"><div class="flex">' . $tab . '<div class="gui-border w-max">' . $markup . '</div></div>';
            $note = $fragment['note'] ?? null;
            if ($note) {
                $handler = FragmentHandler::getHandlerForType($note['fragment']);
                if (class_exists($handler)) {
                    $content .= '<p class="wiki-recipe-note">' . $handler::getMarkup($note) . '</p>';
                } else {
                    $cloner = new VarCloner();
                    $dumper = new HtmlDumper();

                    $dumper->dump(
                        $cloner->cloneVar($note),
                        function ($line, $depth) use (&$content) {
                            if ($depth >= 0) $content .= str_repeat('  ', $depth).$line."\n";
                        }
                    );
                }
            }
            $content .= '</div>';
        }
        return $content;
    }

    public static function getTableMarkup(array $table) : string {
        return '<div class="gui-loot-table">
            ' . collect($table['pools'])->map(fn(array $pool) => static::getPoolMarkup($pool, $table['translations'], $table['links']))->join('') . '
        </div>';
    }

    public static function getPoolMarkup(array $pool, array $translations, array $links) : string {
        $content = '';
        foreach ($pool['entries'] as $entry) {
            $functions = ['count' => ['min' => 1, 'max' => 1]];

            foreach ($entry['functions'] as $function) {
                if ($function['function'] === 'minecraft:set_count') {
                    if ($function['add']) {
                        $functions['count']['min'] += $function['count']['min'];
                        $functions['count']['max'] += $function['count']['max'];
                    } else {
                        $functions['count']['min'] = $function['count']['min'];
                        $functions['count']['max'] = $function['count']['max'];
                    }
                } elseif ($function['function'] === 'minecraft:looting_enchant') {
                    $functions['looting'] = $functions['looting'] ?? [];
                    $functions['looting']['min'] = $function['count']['min'];
                    $functions['looting']['max'] = $function['count']['max'];
                }
            }

            $content .= '<div class="gui-loot-entry mc-text">';
            $content .= Ingredient::renderSlot(Ingredient::fromArray(['item' => $entry['name']])->setNameFrom($translations)->setLinkFrom($links));

            $content .= '<div class="gui-loot-functions">';
            $content .= '<p>' . (($functions['count']['min'] != $functions['count']['max']) ? ($functions['count']['min'] . '-' . $functions['count']['max']) : $functions['count']['min']) . '</p>';
            if ($functions['looting']) {
                $content .= '<p class="mc-text-enchant">' . __('wiki.loot.looting', ['range' => (($functions['looting']['min'] != $functions['looting']['max']) ? ($functions['looting']['min'] . '-' . $functions['looting']['max']) : $functions['looting']['min'])]) . '</p>';
            }
            $content .= '</div>';

            $content .= '</div>';
        }
        return '<div class="gui-loot-pool">' . $content . '</div>';
    }

    public static function getTabMarkup(array $fragment) : ?string {
        return Ingredient::renderSlot(Ingredient::fromArray(['item' => 'minecraft:iron_sword', 'translation' => __("wiki.loot." . request()->segment(1))]), 'gui-slot');
    }

    public static function getOuterMarkup(string $content, array $fragment) : string {
        return '<div>' . $content . '</div>';
    }

}
