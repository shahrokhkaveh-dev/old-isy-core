<?php

namespace App\Models;

use App\Enums\TicketComment\Fields;
use App\Models\Admin\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\File\Fields as FileFields;
use App\Enums\File\Entries as FileEntries;

class TicketComment extends Model
{
    use HasFactory;

    protected $fillable = [
        Fields::COMMENT,
        Fields::UUID,
        Fields::TICKET_ID,
        Fields::USER_TYPE,
        Fields::USER_ID,
        Fields::USER_NAME,
        Fields::IP,
        Fields::SEEN_AT,
    ];

    public function user()
    {
        if ($this->user_type == 1) {
            return $this->belongsTo(Admin::class);
        } else {
            return $this->belongsTo(User::class);
        }
    }

    public function file()
    {
        return $this->hasOne(File::class, FileFields::RELATED_ID)->where(FileFields::RELATED_ENTRY, FileEntries::TICKET_RELATED_ENTRY);
    }
}
