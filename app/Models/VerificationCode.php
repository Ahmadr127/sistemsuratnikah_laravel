<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class VerificationCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'type',
        'code_hash',
        'attempts',
        'expires_at',
        'consumed_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'consumed_at' => 'datetime',
    ];

    public const TYPE_REGISTER = 'register';
    public const TYPE_PASSWORD_RESET = 'password_reset';
    public const TYPE_LOGIN_MFA = 'login_mfa';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generate(string $email, ?int $userId, string $type, int $digits = 4, int $ttlMinutes = 10): array
    {
        $code = str_pad((string) random_int(0, 10 ** $digits - 1), $digits, '0', STR_PAD_LEFT);

        static::where('email', $email)
            ->where('type', $type)
            ->whereNull('consumed_at')
            ->delete();

        $record = static::create([
            'user_id' => $userId,
            'email' => $email,
            'type' => $type,
            'code_hash' => Hash::make($code),
            'expires_at' => Carbon::now()->addMinutes($ttlMinutes),
        ]);

        return [$record, $code];
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isConsumed(): bool
    {
        return !is_null($this->consumed_at);
    }

    public function checkAndConsume(string $code, int $maxAttempts = 5): bool
    {
        if ($this->isExpired() || $this->isConsumed()) {
            return false;
        }
        if ($this->attempts >= $maxAttempts) {
            return false;
        }

        $valid = Hash::check($code, $this->code_hash);
        $this->attempts++;
        if ($valid) {
            $this->consumed_at = Carbon::now();
        }
        $this->save();

        return $valid;
    }
}
