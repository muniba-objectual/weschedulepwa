<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2AccessToken;
use QuickBooksOnline\API\Exception\SdkException;

/**
 * QuickBooks token model.
 *
 * @property int $id
 * @property OAuth2AccessToken $serialized_access_token
 * @property string $other_details
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class QuickbooksToken extends Model
{
    use HasFactory;

    protected $table = 'quickbooks_tokens';

    protected $fillable = ['serialized_access_token', 'other_details'];

    protected $hidden = ['serialized_access_token'];

    public function setSerializedAccessTokenAttribute($value)
    {
        $this->attributes['serialized_access_token'] = serialize($value);
    }

    public function getSerializedAccessTokenAttribute($value)
    {
        return unserialize($this->attributes['serialized_access_token']);
    }

    /**
     * @throws SdkException
     */
    public function isExpired(): bool
    {
        $currentDateTime = Carbon::now();
        $accessTokenExpiresAt = Carbon::createFromTimestamp($this->serialized_access_token->getAccessTokenExpiresAt());

        return $currentDateTime->gt($accessTokenExpiresAt);
    }

    /**
     * @throws SdkException
     */
    public function goingToExpire(): bool
    {
        $accessTokenExpiresAt = Carbon::createFromFormat('Y/m/d H:i:s', $this->serialized_access_token->getAccessTokenExpiresAt());

        $expirationWithBuffer = $accessTokenExpiresAt->subSeconds(config('app.quickbooks_expected_max_execution_time'));

        return Carbon::now()->gt($expirationWithBuffer);
    }
}
