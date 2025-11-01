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

class TicketCommentController extends Controller
{
    private $ticketCommentRepository;

    public function __construct(TicketCommentRepository $ticketCommentRepository)
    {
        $this->ticketCommentRepository = $ticketCommentRepository;
    }

    public function send(TicketCommentRequest $request)
    {
        $data = $request->validated();
        $uuid = $data[Fields::UUID];

        $data[Fields::USER_TYPE] = Entries::ADMIN_USER_TYPE;
        $data[Fields::USER_ID] = auth('admin')->user()->id;
        $data[Fields::IP] = $request->ip();
        unset($data[Fields::UUID]);

        $ticketMessage = $this->ticketCommentRepository->create($data);

        if ($request->hasFile(Fields::FILE)) {
            $fileRepository = new FileRepository();
            $fileRepository->storageStore($uuid, $request->file(Fields::FILE), FileEntries::TICKET_RELATED_ENTRY, $ticketMessage->id);
            unset($data[Fields::FILE]);
        }

        $ticketRepository = new TicketRepository();
        $ticket[CommonFields::STATUS] = TicketEntries::ANSWERED_STATUS;
        $ticketRepository->update($ticket, $data[Fields::TICKET_ID]);

        return redirect()->route('admin.ticket.show', $uuid);
    }
}
