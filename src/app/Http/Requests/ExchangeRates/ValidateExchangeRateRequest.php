<?php

namespace LaravelEnso\Currencies\App\Http\Requests\ExchangeRates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use LaravelEnso\Currencies\App\Models\Currency;
use LaravelEnso\Currencies\App\Models\ExchangeRate;

class ValidateExchangeRateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from_id' => 'integer|required|exists:currencies,id|different:to_id',
            'to_id' => 'integer|required|exists:currencies,id',
            'conversion' => 'numeric|required',
            'date' => 'date|required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('date') && $this->exchangeRate()->first()) {
                $validator->errors()->add(
                    'date', __('This exchange rate is already defined for the specified date!')
                );
            }

            if ($this->missingDefault()) {
                (new Collection(['from_id', 'to_id']))->each(fn ($field) => $validator->errors()
                    ->add($field, __('The exchange rate must use your default currency!'))
                );
            }
        });
    }

    protected function exchangeRate()
    {
        return ExchangeRate::whereToId($this->get('to_id'))
            ->whereFromId($this->get('from_id'))
            ->whereDate('date', $this->get('date'))
            ->where('id', '<>', optional($this->route('exchangeRate'))->id);
    }

    protected function missingDefault()
    {
        return ! (new Collection([$this->get('to_id'), $this->get('from_id')]))
            ->contains(Currency::default()->first()->id);
    }
}
