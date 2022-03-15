<?php

namespace App\Handlers\Fragment;

use App\Models\Ingredient;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class LootFragmentHandler extends FragmentHandler {

    public static function getMarkup(array $fragment) : string {
        if (count($fragment['tables']) < 1) return 'No loot tables.';
        $content = '';

        $tab = static::getTabMarkup($fragment);
        $tab = $tab ? ('<div class="gui-tab">' . $tab . '</div>') : '';
        $content .= '<div class="my-2 gui' . (($fragment['obsolete'] ?? false) ? ' gui-transparent' : '') . ' md:justify-start justify-center items-center flex-wrap md:flex-nowrap"><div class="flex">' . $tab . '<div class="gui-border w-max">';
        foreach ($fragment['tables'] as $table) {
            $markup = static::getTableMarkup($table);
            $content .= $markup;
        }
        $content .= '</div></div>';

        $note = $fragment['note'] ?? null;
        if ($note) {
            $content .= FragmentHandler::render($note, fn(string $content) => '<p class="wiki-recipe-note">' . $content . '</p>');
        }

        $content .= '</div>';
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
            $modifiers = ['count' => ['min' => 1, 'max' => 1]];
            $conditions = $entry['conditions'] ?? [];
            $functions = $entry['functions'] ?? [];

            foreach ($functions as $function) {
                if ($function['function'] === 'minecraft:set_count') {
                    if ($function['add']) {
                        $modifiers['count']['min'] += $function['count']['min'];
                        $modifiers['count']['max'] += $function['count']['max'];
                    } else {
                        $modifiers['count']['min'] = $function['count']['min'];
                        $modifiers['count']['max'] = $function['count']['max'];
                    }
                } elseif ($function['function'] === 'minecraft:looting_enchant') {
                    $modifiers['count']['looting'] = $modifiers['count']['looting'] ?? [];
                    $modifiers['count']['looting']['min'] = $function['count']['min'];
                    $modifiers['count']['looting']['max'] = $function['count']['max'];
                }
            }
            foreach ($conditions as $condition) {
                if ($condition['condition'] === 'minecraft:killed_by_player') {
                    $modifiers['player'] = true;
                } elseif ($condition['condition'] === 'minecraft:random_chance_with_looting') {
                    $modifiers['chance'] = ['of' => $condition['chance'], 'looting' => $condition['looting_multiplier'] ?? 0];
                }
            }

            $content .= '<div class="gui-loot-entry mc-text">';
            $content .= Ingredient::renderSlot(Ingredient::fromArray(['item' => $entry['name']])->setNameFrom($translations)->setLinkFrom($links));

            $content .= '<div class="gui-loot-modifiers">';
            if (!isset($modifiers['chance']) || $modifiers['count']['min'] != 1 || $modifiers['count']['max'] != 1) {
                $content .= '<p>' . (($modifiers['count']['min'] != $modifiers['count']['max']) ? ($modifiers['count']['min'] . '-' . $modifiers['count']['max']) : $modifiers['count']['min']) . '</p>';
            } else {
                $content .= '<p>' . __('wiki.loot.chance', ['percent' => $modifiers['chance']['of'] * 100]) . '</p>';
            }
            if (isset($modifiers['count']['looting'])) {
                $content .= '<p class="mc-text-enchant">' . __('wiki.loot.looting', ['amount' => (($modifiers['count']['looting']['min'] != $modifiers['count']['looting']['max']) ? ($modifiers['count']['looting']['min'] . '-' . $modifiers['count']['looting']['max']) : $modifiers['count']['looting']['min'])]) . '</p>';
            }
            if (isset($modifiers['chance']['looting'])) {
                $content .= '<p class="mc-text-enchant">' . __('wiki.loot.looting', ['amount' => __('wiki.loot.chance', ['percent' => $modifiers['chance']['looting'] * 100])]) . '</p>';
            }
            if ($modifiers['player'] ?? null) {
                $content .= '<p>' . __('wiki.loot.player_kill') . '</p>';
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
