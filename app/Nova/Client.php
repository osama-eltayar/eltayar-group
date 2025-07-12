<?php

namespace App\Nova;

use App\Enums\ClientStatus;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Client extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Client>
     */
    public static $model = \App\Models\Client::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name_ar';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name_ar',
        'name_en',
        'national_number',
        'passport_number',
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
            Text::make(__('client.name_ar'), 'name_ar')->required()->rules('required_without:name_en')->sortable()->filterable(),
            Text::make(__('client.name_en'), 'name_en')->rules('required_without:name_ar')->sortable()->filterable(),
            Text::make(__('client.national_number'), 'national_number')->required()->rules(['required', 'numeric', 'unique:clients,national_number,{{resourceId}}'])->filterable()->sortable(),
            Date::make(__('client.date_of_birth'), 'date_of_birth')->sortable()->filterable()->rules(['nullable','date','before:today'])->max(today()),
            Text::make(__('client.passport_number'), 'passport_number')->rules([ 'nullable','unique:clients,passport_number,{{resourceId}}'])->filterable()->sortable(),
            Select::make(__('client.status'), 'status')->options(ClientStatus::toOptions())->required()->default(ClientStatus::Active)->rules('required')->sortable()->filterable()->displayUsingLabels(),
            BelongsTo::make(__('client.parent'), 'parent', self::class)->nullable()->sortable()->filterable(),
            HasMany::make(__('client.children'), 'children', self::class)->nullable(),
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
