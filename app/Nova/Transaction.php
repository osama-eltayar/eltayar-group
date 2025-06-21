<?php

namespace App\Nova;

use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Transaction extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Transaction>
     */
    public static $model = \App\Models\Transaction::class;

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
        'about',
        'client_id',
        'user_id',
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

            BelongsTo::make(__('transaction.user'), 'user', User::class)
                ->readonly(),

            BelongsTo::make(__('transaction.client'), 'client', Client::class)
                ->rules('required'),

            MorphTo::make(__('transaction.transactionable'))
                ->types([
                    Booking::class,
                ])
                ->nullable(),

            Text::make(__('transaction.about'))
                ->rules('required')
                ->sortable(),

            Number::make(__('transaction.amount'))
                ->rules('required', 'numeric', 'min:0')
                ->sortable(),

            Select::make(__('transaction.currency'), 'currency_code')
                ->options(Currency::toOptions())
                ->rules('required')
                ->displayUsingLabels()
                ->sortable(),

            Select::make(__('transaction.payment_method'), 'payment_method')
                ->options(PaymentMethod::toOptions())
                ->rules('required')
                ->displayUsingLabels()
                ->sortable(),

            Select::make(__('transaction.type'))
                ->options(TransactionType::toOptions())
                ->rules('required')
                ->displayUsingLabels()
                ->sortable(),

            Textarea::make(__('transaction.notes'))
                ->nullable()
                ->hideFromIndex(),
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