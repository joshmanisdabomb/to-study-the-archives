<?php

return [
    'page' => [
        'home' => 'Loosely Connected Concepts Wiki',
        'downloads' => 'LCC Downloads',
        'search' => "Search Results for ':for'",
    ],
    'navigation' => [
        'home' => 'Home',
        'downloads' => 'Downloads',
        'random' => 'Random Page',
        'search' => 'Search :name...',
        'block' => 'Blocks',
        'item' => 'Items',
        'entity' => 'Entities',
        'version' => 'Versions',
    ],
    'search' => [
        'matches' => '{1} :count match found:|[2,*] :count matches found:',
        'similar' => '{1} :count similar result found:|[2,*] :count similar results found:',
        'none' => 'No results found. Please refine your search and try again.',
    ],
    'recipe' => [
        'crafting_shaped' => 'Shaped Crafting Recipe',
        'crafting_shapeless' => 'Shapeless Crafting Recipe',
        'refining_shaped' => 'Shaped Refining Recipe',
        'refining_shapeless' => 'Shapeless Refining Recipe',
        'smelting' => 'Smelting Recipe',
        'stonecutting' => 'Stonecutting Recipe',
        'time_rift' => 'Time Rift Recipe',
        'spawner_table_shaped' => 'Shaped Arcane Table Recipe',
        'spawner_table_shapeless' => 'Shapeless Arcane Table Recipe',
    ],
    'loot' => [
        'entity' => 'Mob Drops',
        'looting' => '+:range per Looting'
    ],
    'icons' => [
        'registry' => [
            'block' => 'bi bi-box mr-1',
            'item' => 'bi bi-star mr-1',
            'effectivity' => 'bi bi-shield-lock mr-1',
            'entity' => 'fas fa-paw mr-1',
            'version' => 'bi bi-archive mr-1',
        ],
        'category' => 'bi bi-collection mr-1',
        'tag' => 'bi bi-tags mr-1',
    ],
    'category' => [
        'name' => [
            'block' => '{1} Block|[2,*] Blocks',
            'item' => '{1} Item|[2,*] Items',
            'entity' => '{1} Entity|[2,*] Entities',
            'effectivity' => '{1} Effectivity|[2,*] Effectivies',
            'version' => '{1} Version|[2,*] Versions',
        ]
    ],
    'list' => [
        'matches' => [
            'all' => '{1} :count article on this wiki:|[2,*] :count articles in this wiki:',
            'tag' => '{1} :count article in this tag:|[2,*] :count articles in this tag:',
            'category' => '{1} :count article in this category:|[2,*] :count articles in this category:',
        ],
        'type' => [
            'tag' => 'Article Tag',
            'category' => 'Article Category',
        ],
        'title' => 'All Pages'
    ],
];
