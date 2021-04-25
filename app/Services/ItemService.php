<?php


namespace App\Services;


use App\Models\AutoBidConfig;
use App\Models\Item;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\ValidationException;

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

    public function show(Item $item): Model
    {
        $item->load(['buyer' => function (BelongsTo $query) {
            $query
                ->select('id', 'name');
        }]);
        return $item;
    }

    /**
     * @param Item $item
     * @param User $user
     * @param array $request
     * @return Model
     * @throws ValidationException
     */
    public function doBid(Item $item, User $user, array $request): Model
    {
        if ($request['auto_bidding'] && $request['auto_bidding'] === true) {
            $this->validateAutoBidding($user);
        }

        if ($item->user_id !== $user->id && $item->auto_bidding) {
            return $this->handleAutoBid($item, $user, $request);
        }

        return $this->saveBid($item, $user->id, $request);
    }

    private function saveBid(Item $item, int $user_id, array $request): Model
    {
        $item->price = $request['bid_price'];
        $item->auto_bidding = $request['auto_bidding'] ?? false;
        $item->user_id = $user_id;
        $item->save();

        return $item;
    }

    private function handleAutoBid(Item $item, User $user, array $request): Model
    {
        $autoBidConfig = AutoBidConfig::firstWhere('user_id', $item->user_id);

        if ($autoBidConfig) {
            $diff = ($request['bid_price'] + 1) - $item->price ;

            if (($autoBidConfig->auto_bidding_max_amount - $autoBidConfig->auto_bidding_current_amount) > $diff) {
                $autoBidConfig->increment('auto_bidding_current_amount', $diff);

                return $this->saveBid($item, $item->user_id, [
                    'bid_price' => $request['bid_price'] + 1,
                    'auto_bidding' => true
                ]);
            }
        }

        return $this->saveBid($item, $user->id, $request);
    }

    /**
     * @param User $user
     * @throws ValidationException
     */
    private function validateAutoBidding(User $user): void
    {
        $autoBidConfig = AutoBidConfig::firstWhere('user_id', $user->id);

        if (!$autoBidConfig) {
            throw ValidationException::withMessages([
                'auto_bidding' => ['The Auto bidding is not configured, go to Config Page.'],
            ]);
        }
    }
}
