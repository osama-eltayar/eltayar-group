<?php

namespace App\Nova;

use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Trip extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Trip>
     */
    public static $model = \App\Models\Trip::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make(__('trip.name'), 'name')
                ->filterable()
                ->required()
                ->rules(['required', 'between:3,150', Rule::unique('trips', 'name')->ignore($this->resource?->id)])
                ->sortable(),
            Textarea::make(__('trip.description'), 'description')->hideFromIndex(),
            Date::make(__('trip.started_at'), 'started_at')->filterable()->sortable(),
            Date::make(__('trip.ended_at'), 'ended_at')->filterable()->rules('nullable','after:'.$this->started_at)->sortable(),
            Select::make(__('trip.status'), 'status')->options(TripStatus::toOptions())->rules('required')->required()->sortable()->filterable(),
            Select::make(__('trip.activity'), 'activity')->options(TripActivity::toOptions())->rules('required')->required()->sortable()->filterable(),
            Select::make(__('trip.type'), 'type')->options(TripType::toOptions())->rules('required')->required()->sortable()->filterable(),
            Number::make(__('trip.maximum_allowed'), 'maximum_allowed')->sortable(),
//            HasMany::make('clients','tripClients',TripClient::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
