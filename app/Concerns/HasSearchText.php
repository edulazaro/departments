<?php

namespace App\Concerns;

trait HasSearchText
{
    public function scopeSearchText($query, $searchText = null)
    {
        return $this->searchTextOn($query, 'search_text', $searchText);
    }

    public function scopeSearchTextOn($query, $field, $searchText = null)
    {
        return $this->searchTextOn($query, $field, $searchText);
    }

    public function searchTextOn($query, $field, $searchText = null)
    {
        if (empty($searchText)) return $query;

        $words = explode(' ', $searchText);
        
        $query->where(function($query) use ($words, $field) {
            foreach ($words as  $word) {
                $query->where($field, 'like', '%' . $word . '%');
            }
        });

        return $query;
    }
}