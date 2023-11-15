<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait CanLoadRelationships
{
    public function loadRelationships(Model|QueryBuilder|EloquentBuilder $for, array $relations): Model|EloquentBuilder|QueryBuilder
    {
        foreach ($relations as $relation) {
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
