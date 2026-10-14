<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasSortOrder
{
    protected static function bootHasSortOrder(): void
    {
        // Item baru otomatis ditaruh paling akhir; urutan bisa diubah dengan drag & drop di dashboard.
        static::creating(function ($model) {
            if ($model->sort_order === null) {
                $model->sort_order = (int) static::max('sort_order') + 1;
            }
        });
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('id');
    }
}
