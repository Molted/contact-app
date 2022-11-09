<?php

use Illuminate\Support\Str;

function sortable($label, $column = null)
{
    $column = $column ?? Str::snake($label); // check if the $column is null, if null then do Str:snake($label)
    $sortBy = request()->query('sort_by'); // Default value is null
    $direction = "";
    if (ltrim($sortBy, "-") === $column)
    {
        $direction = strpos($sortBy, '-') === 0 ? 'desc' : 'asc';
    }
    $sortBy = !$sortBy || strpos($sortBy, "-") === 0 ? $column : "-{$column}";
    $url = request()->fullUrlWithQuery(['sort_by' => $sortBy]);
    
    return "<a href='{$url}' class='sortable {$direction}'>{$label}</a>";
}