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
use Illuminate\Validation\Rule;

class TripClient extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\TripClient>
     */
    public static $model = \App\Models\TripClient::class;

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
            BelongsTo::make('Client', 'client', Client::class)->sortable()->filterable(),
            BelongsTo::make('Booking', 'booking', Booking::class)->sortable()->filterable(),
            BelongsTo::make('Trip', 'trip', Trip::class)
                ->dependsOn(['Booking'],function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    $field->setValue(
                        \App\Models\Booking::query()
                            ->whereKey($formData->booking_id ?? $formData->resource(Booking::uriKey()))
                            ->first()?->trip_id
                    );
                })->sortable()->filterable()
                ->rules('required', Rule::unique('trip_clients', 'trip_id')->where('client_id', $this->resource?->client_id)->ignore($this->resource?->id)),
            Select::make(__('room_type'), 'room_type')->options(RoomType::toOptions())->displayUsingLabels()
                ->dependsOn(['Booking'],function (Select $field, NovaRequest $request, FormData $formData) {
                    $field->setValue(
                        \App\Models\Booking::query()->whereKey($formData->booking_id ?? $formData->resource(Booking::uriKey()))->first()?->room_type
                    );
                })->sortable()->filterable(),
            Number::make(__('balance'), 'balance')->exceptOnForms()->sortable()->filterable(),
            Number::make(__('price'), 'price')
                ->dependsOn(['trip','room_type'],function (Number $field, NovaRequest $request, FormData $formData) {
                    $field->setValue(
                        TripPrice::query()->where('room_type',$formData->room_type)->where('trip_id' ,$formData->trip_id)->first()?->price
                    );
                })->sortable()->filterable(),
            Number::make(__('discount_amount'), 'discount_amount')->exceptOnForms()->sortable()->filterable(),
            Number::make(__('final_price'), 'final_price')->exceptOnForms()->sortable()->filterable(),
        ];
    }

    public static function creating($callback)
    {
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
