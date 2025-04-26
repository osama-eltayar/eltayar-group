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

class BookingClient extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\BookingClient>
     */
    public static $model = \App\Models\BookingClient::class;

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
        'booking_id',
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
            BelongsTo::make(__('client'), 'Client', Client::class),
            BelongsTo::make(__('booking'), 'Booking', Booking::class)
                ->default($request->viaResourceId)
                ->required(),
            Select::make(__('room_type'), 'room_type')
                ->options(RoomType::toOptions())
                ->dependsOn(
                    ['Booking'],
                    fn( $field, NovaRequest $request, FormData $formData) =>
                    $field->setValue(\App\Models\Booking::query()->whereKey($request->Booking)->first()?->room_type)
                ),
            Number::make(__('balance'), 'balance')->exceptOnForms(),
            Number::make(__('price'), 'price')
                ->dependsOn(['room_type','Booking'],fn (Number $field, NovaRequest $request, FormData $formData) =>
                    $field->setValue(
                        TripPrice::query()
                            ->where('room_type',$formData->room_type)
                            ->where('trip_id' ,\App\Models\Booking::query()->whereKey($request->Booking)->first()?->room_type)
                            ->first()?->price)
                ),
            Number::make(__('discount_amount'), 'discount_amount')->exceptOnForms(),
            Number::make(__('final_price'), 'final_price')->exceptOnForms(),
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
