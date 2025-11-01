<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Enums\Ticket\Entries;
use App\Enums\Ticket\Fields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TicketCommentRequest;
use App\Repositories\TicketRepository;
use Illuminate\Http\Request;
use App\Enums\TicketComment\Fields as TicketCommentFields;

class TicketController extends Controller
{
    private $ticketRepository;
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    public function index()
    {
        $perPage = request(CommonFields::PER_PAGE) ?? 10;
        $search = request(Fields::SEARCH_INPUT);
        $searchType = request(Fields::SEARCH_TYPE);
        $status = request(Fields::TICKET_TYPE)?? 1;
        $searchField = Fields::TITLE;

        if($searchType == Entries::UUID_SEARCH_TYPE){
            $searchField = CommonFields::UUID;
        }

        $where = [CommonFields::STATUS => $status];

        $count[CommonFields::STATUS] = array_keys(ENTRIES::STATUS);

        return $this->ticketRepository->select(
            [CommonFields::ID, CommonFields::UUID, CommonFields::CREATED_AT, CommonFields::STATUS, CommonFields::UPDATED_AT, Fields::CATEGORY, Fields::TITLE, CommonFields::BRAND_ID, CommonFields::USER_ID],
        [CommonFields::UPDATED_AT, 'desc'],
            $perPage,
         [$searchField],
          $search,
          $where,
          $count,
          'admin.panel.tickets.index');
    }

    public function show($uuid)
    {
        $ticket = $this->ticketRepository->show($uuid);

        return view('admin.panel.tickets.chat', compact('ticket'));
    }
}
