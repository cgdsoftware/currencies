<?php

namespace LaravelEnso\Currencies\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Countries\App\Models\Country;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Tables\App\Traits\TableCache;

class Currency extends Model
{
    use AvoidsDeletionConflicts, TableCache;

    protected $fillable = ['code', 'name', 'symbol', 'is_default'];

    protected $casts = ['is_default' => 'boolean'];

    public function fromExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'from_id');
    }

    public function toExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'to_id');
    }

    public function countries()
    {
        return $this->hasMany(Country::class, 'currency_code', 'code');
    }

    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    public function scopeForeign($query)
    {
        return $query->whereIsDefault(false);
    }
}
