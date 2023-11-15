<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Trait CanLoadRelationships
 *
 * Provides functionality to dynamically load relationships on Eloquent models
 * based on request parameters.
 */
trait CanLoadRelationships
{
    /**
     * Dynamically load relationships on a model or query builder.
     *
     * @param Model|QueryBuilder|EloquentBuilder $for The model or query builder to load relationships on.
     * @param array|null $relations List of potential relationships to load.
     * @return Model|EloquentBuilder|QueryBuilder The model or query builder with loaded relationships.
     */
    public function loadRelationships(Model|QueryBuilder|EloquentBuilder $for, ?array $relations): Model|EloquentBuilder|QueryBuilder
    {
        $relations = $relations ?? $this->$relations ?? [];
        foreach ($relations as $relation) {
            // Conditionally load each relation based on request parameters
            $for->when(
                $this->shouldIncludeRelation($relation),
                fn($queries) => $for instanceof Model ? $queries->load($relation) : $queries->with($relation)
            );
        }
        return $for;
    }

    /**
     * Determine if a relation should be included based on request parameters.
     *
     * This method checks if the 'include' parameter in the request contains the specified relation.
     *
     * @param string $relation The relation name to check.
     * @return bool Returns true if the relation should be included, false otherwise.
     */
    protected function shouldIncludeRelation(string $relation): bool
    {
        $include = \request()->query('include');
        if (!$include) {
            return false;
        }
        $relations = array_map('trim', explode(',', $include));

        return in_array($relation, $relations);
    }
}
