<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentShare
 * @package App\Models
 *
 * @property int $id
 * @property int|null $document_id
 * @property Carbon|null email_sent_at
 * @property Carbon|null $downloaded_at
 * @property Carbon|null $last_access_at
 * @property Carbon|null $link_expire_at
 * @property string|null $password
 * @property string|null $download_html
 * @property string recipient_name
 * @property string $email
 * @property string $token
 *
 * @property DocumentFile document
 *
 * Readonly
 * @property bool $has_password_gard
 * @property bool $is_downloaded
 * @property bool $never_expires
 */
class DocumentShare extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document_id',
        'email_sent_at',
        'downloaded_at',
        'last_access_at',
        'link_expire_at',
        'password',
        'download_html',
        'recipient_name',
        'token',
        'email',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'has_password_guard',
        'is_downloaded',
        'never_expires',
        'can_open_by_anyone'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'last_access_at' => 'datetime',
        'link_expire_at' => 'datetime',
        'downloaded_at'  => 'datetime',
        'email'          => 'array'
    ];

    public function download(){
        //TODO::ashain, implement
    }

    public function getHasPasswordGuardAttribute(): bool
    {
        return (bool) $this->password;
    }

    public function getIsDownloadedAttribute(): bool
    {
        return (bool) $this->downloaded_at;
    }

    public function getNeverExpiresAttribute(): bool
    {
        return !$this->link_expire_at;
    }

    public function getCanOpenByAnyoneAttribute(): bool
    {
        return is_null($this->email);
    }

    public static function CreateFileLink(DocumentFile $document, string|array $email, int $expiresInHours, string $recipientName, string $password = null, string $html = null, bool $hasPasswordAuth = true): static
    {
        $instance = new static;
        $instance->recipient_name = $recipientName;
        $instance->link_expire_at = now()->addHours($expiresInHours);
        $instance->document_id = $document->id;
        $instance->download_html = $html;
        $instance->email = is_string($email)?[$email]:$email;
        $instance->token = \Illuminate\Support\Str::uuid()->toString();

        if($hasPasswordAuth){
            $instance->password = $password??static::generateRandomPassword();
        }else{
            $instance->password = null;
        }

        $instance->save();
        return $instance;
   }


    private static function generateRandomPassword(): string
    {
        $url = 'https://www.dinopass.com/password/strong'; //TODO::Michello feel free to modify this!
        $password = file_get_contents($url);

        // Remove any whitespace or newline characters from the password
        $password = trim($password);

        return $password;
    }

   public function getUrl(): string
   {
        return \Illuminate\Support\Facades\URL::temporarySignedRoute('documentViewer', $this->link_expire_at, ['token' => $this->token]);
   }

   public function document(): \Illuminate\Database\Eloquent\Relations\BelongsTo
   {
        return $this->belongsTo(DocumentFile::class, 'document_id');
   }
}
