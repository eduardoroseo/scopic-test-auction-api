<?php


namespace App\Services;


use App\Models\AutoBidConfig;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class AutoBidConfigService
{
    public function getByUser(User $user): Model
    {
        return AutoBidConfig::where('user_id', $user->id)
            ->firstOrFail();
    }

    public function save(User $user, array $request): Model
    {
        return AutoBidConfig::updateOrCreate(['user_id' => $user->id], [
            'auto_bidding_max_amount' => $request['auto_bidding_max_amount']
        ]);
    }

    /**
     * @param User $user
     * @return bool
     * @throws ValidationException
     */
    public function delete(User $user): bool
    {
        $autoBidConfig = AutoBidConfig::firstWhere('user_id', $user->id);

        if (!$autoBidConfig) {
            throw ValidationException::withMessages([
                'auto_bid_config' => ['The Auto bidding is already disabled.'],
            ]);
        }
        $autoBidConfig->delete();

        return true;
    }
}
