<?php

namespace App\Nova;

use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     * @var string
     */
    public static $model = \App\Models\Event::class;
    /**
     * The columns that should be searched.
     * @var array
     */
    public static $search = [
        'id',
        'course.name',
    ];

    public static function relatableCourses(NovaRequest $request, $query, Field $field)
    {
        if ($field instanceof BelongsTo) {
            $query->whereHas('lecturer', function ($query) use ($request) {
                $query->where('team_id', $request->user()->id);
            });
        }

        return $query;
    }

    public function title()
    {
        return $this->from.' - '.$this->venue->name.' - '.$this->course->name;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()
              ->sortable(),

            DateTime::make('From')
                    ->rules('required')
                    ->step(CarbonInterval::minutes(30))->displayUsing(fn ($value) => $value->asDateTime()),

            DateTime::make('To')
                    ->rules('required')
                    ->step(CarbonInterval::minutes(30))->displayUsing(fn ($value) => $value->asDateTime()),

            BelongsTo::make('Course'),
            BelongsTo::make('Venue')
                     ->searchable(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
