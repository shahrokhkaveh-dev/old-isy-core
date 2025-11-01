<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Enums\TicketComment\Entries;
use App\Enums\TicketComment\Fields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketCommentRequest;
use App\Repositories\TicketCommentRepository;
use App\Repositories\TicketRepository;
use App\Enums\Ticket\Entries as TicketEntries;
use App\Repositories\FileRepository;
use App\Enums\File\Entries as FileEntries;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function getTemporaryUrl($path)
    {
        if (Storage::exists($path)) {
            return response()->file(Storage::path($path));
        }

        abort(404);
    }
}
