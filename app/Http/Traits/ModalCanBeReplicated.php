<?php

//Add the ability to replicate Laravel models to other models.

//https://gist.github.com/mpociot/ea51fed3b438e90b50228f4b113aba13
namespace App\Http\Traits;
use Illuminate\Support\Arr;

trait ModalCanBeReplicated
{
    public function replicateTo(string $model, array $with = null, array $except = null)
    {
        $defaults = [
            $this->getKeyName(),
            $this->getCreatedAtColumn(),
            $this->getUpdatedAtColumn(),
        ];

        $attributes = Arr::except(
            $this->attributes, $except ? array_unique(array_merge($except, $defaults)) : $defaults
        );

        $attributes = array_merge($attributes, $with ?? []);

        return tap(new $model, function ($instance) use ($attributes) {
            $instance->setRawAttributes($attributes);

            $instance->setRelations($this->relations);

            $instance->fireModelEvent('replicating', false);
        });
    }
}
