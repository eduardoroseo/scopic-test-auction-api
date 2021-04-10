<?php


namespace App\Services;


use App\Models\Item;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ItemService
{
    public function all(array $queryRequest = []): LengthAwarePaginator
    {
        return Item::where('bid_expiration', '>', now())
            ->where('available', 1)
            ->when(isset($queryRequest['search']), function (Builder $query) use ($queryRequest) {
                $query->where(function (Builder $query) use ($queryRequest) {
                    $query->where('name', 'LIKE', "%{$queryRequest['search']}%")
                        ->orWhere('description', 'LIKE', "%{$queryRequest['search']}%");
                });
            })
            ->when(isset($queryRequest['orderByPrice']), function (Builder $query) use ($queryRequest) {
                $query->orderBy('price', $queryRequest['orderByPrice']);
            })
            ->paginate(10);
    }
}
