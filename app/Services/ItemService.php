<?php


namespace App\Services;


use App\Models\Item;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            ->with(['buyer' => function(BelongsTo $query) {
                $query->select('id', 'name', 'email');
            }])
            ->paginate(10);
    }

    public function doBid(Item $item, User $user, array $request): Model
    {
        $item->price = $request['bid_price'];
        $item->auto_bidding = $request['auto_bidding'] ?? false;
        $item->user_id = $user->id;
        $item->save();

        return $item;
    }
}
