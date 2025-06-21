<?php

namespace App\Nova;

use App\Enums\RoomType;
use App\Models\TripPrice;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Booking extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Booking>
     */
    public static $model = \App\Models\Booking::class;

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
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Client', 'client', Client::class),
            BelongsTo::make('Trip', 'trip', Trip::class),
            Select::make(__('booking.room_type'), 'room_type')->options(RoomType::toOptions()),
            Number::make(__('booking.balance'), 'balance')->exceptOnForms(),
            Number::make(__('booking.price'), 'price')->readonly()
                ->dependsOn(['trip','room_type'],function (Number $field, NovaRequest $request, FormData $formData) {
                    $field->setValue(
                        TripPrice::query()->where('room_type',$formData->room_type)->where('trip_id' ,$formData->trip)->first()?->price
                    );
                }),
            Number::make(__('booking.number_of_clients'), 'number_of_clients')->default(1),
            Number::make(__('booking.total_price'), 'total_price')->exceptOnForms(),
            Number::make(__('booking.final_price'), 'final_price')->exceptOnForms(),
            Number::make(__('booking.discount_amount'), 'discount_amount')->exceptOnForms(),
            HasMany::make(__('booking.clients'),'tripClients', TripClient::class),

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
