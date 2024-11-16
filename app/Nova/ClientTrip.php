<?php

namespace App\Nova;

use App\Enums\RoomType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClientTrip extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\ClientTrip>
     */
    public static $model = \App\Models\ClientTrip::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'trip_id',
        'client_id',

    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Client', 'client', Client::class),
            BelongsTo::make('Trip', 'trip', Trip::class),
            Select::make(__('room_type'), 'room_type')->options(RoomType::toOptions()),
            Number::make(__('balance'), 'balance')->exceptOnForms(),
            Number::make(__('price'), 'price'),
            Number::make(__('total_price'), 'total_price')->exceptOnForms(),
            Number::make(__('final_price'), 'final_price')->exceptOnForms(),
            Number::make(__('discount_amount'), 'discount_amount'),



        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
