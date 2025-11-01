@extends('admin.panel.layout.master')
@section('style')
    <link rel="stylesheet" href="{{ asset('admin-assets/panel-assets/css/Ticket.css') }}"/>
@endsection
@section('content')
    <section class="ticketSection">
        <div class="ticketWrapper">
            <h1 class="ticketTitle">تیکت ها</h1>
            <div class="ticketSearchFormWrapper">
                <form action="" class="ticketSearchForm d-none d-md-block" id="ticketSearchForm" method="get"
                      autocomplete="off">
                    <div class="ticketSearchFormInputContainer">
                        <select id="searchType" name="search-type" class="searchType">
                            <option value="1" selected>عنوان</option>
                            <option value="2">شناسه</option>
                        </select>
                        <span class="select-input-icon">&#9662;</span>
                        <input type="text" placeholder="عبارت مورد نظر + کلید Enter" id="searchInput"
                               name="search-input" class="searchInput">
                    </div>
                    <input type="text" style="display: none;" name="ticket-type" id="ticketType">
                    <input type="text" style="display: none" name="perPage" value="{{isset($_GET['perPage']) ? $_GET['perPage'] : '10'}}">
                </form>
                <input type="text" class="form-control d-block d-md-none ticketSearchMobile" id="ticketSearchMobile"
                       placeholder="جستجو..">
                <select class="form-select d-block d-md-none ticketBoxMobile" id="ticketBoxMobile">
                    <option value="1">تیکت‌های باز</option>
                    <option value="2">درحال بررسی</option>
                    <option value="3">پاسخ داده شده</option>
                    <option value="4">بسته شده</option>
                </select>
            </div>
            <div class="ticketTypeWrapper d-none d-md-flex">
                <div class="ticketTypeBox" data-ticket-type="1">
                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M37.035 21.097c-.118-.059-.236-.118-.295-.177-.236-.118-.414-.236-.65-.295-1.653-.472-3.896.59-8.5 2.715l-1.593.709c-1.417.649-2.244 1.062-3.01 1.18h-1.004c-.709-.118-1.535-.531-2.893-1.18l-1.889-.886c-3.955-1.889-6.257-2.951-7.91-2.951-.59 0-1.12.118-1.593.413-.06 0-.06.059-.118.059h-.06c-1.711 1.18-1.77 3.66-1.77 9.68 0 3.896.059 5.608 1.122 6.73l.118.118c1.121 1.062 2.774 1.121 6.729 1.121h17.177c3.778 0 5.49-.059 6.552-1.062l.236-.236c1.063-1.122 1.063-2.716 1.063-6.552 0-5.844-.06-8.264-1.712-9.386Z">
                        </path>
                        <path d="M21.984 25.229c.177.059.354.059.59.059.119 0 .296 0 .473-.06h-1.063Z" fill="#fff">
                        </path>
                        <path
                            d="M35.085 7.285C33.55 5.75 31.307 5.75 27.352 5.75h-9.975c-4.014 0-6.198 0-7.733 1.535C8.11 8.819 8.11 10.413 8.11 14.427c0 1.8 1.861 3.22 3.61 3.652 1.878.464 4.095 1.521 6.956 2.9 1.223.573 2.97 1.89 4.31 1.89 1.278 0 2.844-1.173 4.013-1.713 2.323-1.114 4.218-2.004 5.85-2.533 1.894-.614 3.713-2.263 3.713-4.255 0-3.955 0-5.549-1.476-7.083ZM19.443 9.528h5.843c.65 0 1.181.531 1.181 1.18 0 .65-.531 1.18-1.18 1.18h-5.844c-.65 0-1.18-.53-1.18-1.18 0-.649.53-1.18 1.18-1.18Zm7.91 7.555h-9.976c-.65 0-1.18-.53-1.18-1.18 0-.65.53-1.18 1.18-1.18h9.975c.65 0 1.181.53 1.181 1.18 0 .59-.531 1.18-1.18 1.18Z">
                        </path>
                    </svg>
                    <h2>تیکت‌های باز</h2>
                    <span>{{ $countResult['status'][1] }} تیکت</span>
                </div>
                <div class="ticketTypeBox" data-ticket-type="2">
                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M28.637 6.33C27.307 5 25.365 5 21.94 5H13.3C9.823 5 7.932 5 6.603 6.33c-1.33 1.328-1.33 2.709-1.33 6.185 0 1.56 1.612 2.79 3.126 3.163 1.627.402 3.547 1.318 6.026 2.512 1.058.496 2.572 1.636 3.732 1.636 1.107 0 2.463-1.015 3.476-1.483 2.012-.964 3.653-1.736 5.066-2.194 1.64-.532 3.216-1.96 3.216-3.685 0-3.425 0-4.806-1.278-6.135ZM15.089 8.271h5.062c.562 0 1.022.46 1.022 1.022 0 .563-.46 1.023-1.022 1.023h-5.062c-.562 0-1.022-.46-1.022-1.023 0-.562.46-1.022 1.022-1.022Zm6.85 6.544H13.3c-.561 0-1.022-.46-1.022-1.023 0-.562.46-1.022 1.023-1.022h8.64c.562 0 1.022.46 1.022 1.022 0 .512-.46 1.023-1.022 1.023Z">
                        </path>
                        <path
                            d="M30.428 18.293c-.042-.021-.084-.042-.122-.063-.094-.052-.183-.115-.278-.166-.14-.075-.264-.142-.418-.18-1.432-.41-3.375.51-7.362 2.351l-1.33.614c-1.18.54-1.887.893-2.531 1.01a.85.85 0 0 1-.152.012h-.71a.836.836 0 0 1-.164-.015c-.596-.119-1.3-.47-2.424-1.007l-1.636-.767c-3.425-1.636-5.419-2.556-6.85-2.556-.512 0-.972.102-1.38.358-.052 0-.052.05-.103.05h-.051c-1.483.972-1.585 3.12-1.585 8.334 0 3.374.051 4.857.971 5.828l.103.102c.971.92 2.402.971 5.828.971h11.39c.816 0 1.318-.95 1.018-1.707a7.7 7.7 0 0 1-.547-2.843c0-4.345 3.527-7.821 7.821-7.821.112 0 .224.001.335.005.706.023 1.393-.574 1.148-1.236-.21-.566-.52-.974-.971-1.274Z">
                        </path>
                        <path
                            d="M30.277 22.587a6.393 6.393 0 0 0-6.39 6.39 6.393 6.393 0 0 0 6.39 6.391 6.393 6.393 0 0 0 6.39-6.39 6.393 6.393 0 0 0-6.39-6.39Zm2.505 8.487h-2.914a1.135 1.135 0 0 1-1.124-1.125v-3.885c0-.614.51-1.125 1.124-1.125.614 0 1.125.511 1.125 1.125v2.76h1.79c.613 0 1.124.512 1.124 1.125 0 .614-.511 1.125-1.125 1.125Z"
                            fill="#FFBA1F"></path>
                    </svg>
                    <h2>درحال بررسی</h2>
                    <span>{{ $countResult['status'][2] }} تیکت</span>
                </div>
                <div class="ticketTypeBox" data-ticket-type="3">
                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M30.113 22.307a6.534 6.534 0 0 0-6.554 6.554 6.534 6.534 0 0 0 6.554 6.554 6.534 6.534 0 0 0 6.554-6.554c0-3.584-2.919-6.554-6.554-6.554Zm3.072 5.889-2.919 2.918a1.01 1.01 0 0 1-.717.307c-.256 0-.512-.102-.716-.307l-1.485-1.485c-.41-.41-.41-1.024 0-1.382.41-.41 1.024-.41 1.382 0l.768.768 2.253-2.253c.41-.41 1.024-.41 1.383 0 .46.41.46 1.075.05 1.433Z"
                            fill="#44D3A7"></path>
                        <path
                            d="M28.677 6.331C27.346 5 25.4 5 21.97 5h-8.654C9.834 5 7.94 5 6.61 6.331c-1.332 1.332-1.332 2.714-1.332 6.196 0 1.562 1.615 2.793 3.13 3.168 1.63.402 3.553 1.32 6.036 2.515 1.06.497 2.576 1.639 3.738 1.639 1.109 0 2.467-1.017 3.481-1.485 2.016-.966 3.659-1.739 5.074-2.198 1.643-.532 3.221-1.963 3.221-3.69 0-3.43 0-4.813-1.28-6.145ZM15.108 8.277h5.07c.563 0 1.024.46 1.024 1.024 0 .563-.461 1.024-1.025 1.024h-5.069c-.563 0-1.024-.46-1.024-1.024 0-.563.461-1.024 1.024-1.024Zm6.862 6.554h-8.654c-.563 0-1.024-.46-1.024-1.024 0-.563.461-1.024 1.024-1.024h8.654c.563 0 1.024.46 1.024 1.024 0 .512-.461 1.024-1.024 1.024Z">
                        </path>
                        <path
                            d="M30.47 18.313a3.932 3.932 0 0 1-.122-.063c-.095-.051-.183-.115-.278-.166-.14-.074-.265-.142-.42-.18-1.433-.41-3.379.512-7.373 2.355l-1.331.614c-1.183.542-1.891.895-2.536 1.012-.05.009-.101.012-.152.012h-.711a.836.836 0 0 1-.164-.014c-.597-.12-1.302-.471-2.428-1.01l-1.638-.768c-3.431-1.638-5.428-2.56-6.862-2.56-.512 0-.972.103-1.382.359-.051 0-.051.05-.102.05h-.052c-1.485.974-1.587 3.124-1.587 8.347 0 3.38.051 4.864.973 5.837l.102.102c.973.922 2.407.973 5.838.973h11.411c.815 0 1.318-.95 1.017-1.707a7.713 7.713 0 0 1-.55-2.85c0-4.352 3.534-7.834 7.835-7.834.112 0 .225.002.337.006.706.023 1.393-.574 1.148-1.236-.21-.568-.52-.977-.973-1.279Z">
                        </path>
                    </svg>
                    <h2>پاسخ داده شده</h2>
                    <span>{{ $countResult['status'][3] }} تیکت</span>
                </div>
                <div class="ticketTypeBox" data-ticket-type="4">
                    <svg viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M32.204 18.345a1.116 1.116 0 0 1-.256-.154c-.206-.102-.36-.205-.565-.256-1.437-.411-3.388.513-7.392 2.36l-1.385.616c-1.232.565-1.95.924-2.618 1.027h-.873c-.616-.102-1.334-.462-2.515-1.026l-1.642-.77c-3.44-1.643-5.441-2.567-6.878-2.567-.514 0-.976.103-1.386.36-.051 0-.051.05-.103.05H6.54C5.05 19.013 5 21.169 5 26.405c0 3.387.051 4.876.975 5.851l.103.103c.975.924 2.412.975 5.851.975h14.937c3.285 0 4.774-.051 5.697-.924l.206-.205c.924-.975.924-2.361.924-5.698 0-5.081-.052-7.186-1.489-8.16Z">
                        </path>
                        <path
                            d="M30.512 6.335C29.177 5 27.227 5 23.788 5h-8.675c-3.49 0-5.39 0-6.724 1.335-1.334 1.334-1.334 2.72-1.334 6.21 0 1.566 1.618 2.8 3.138 3.176 1.633.404 3.561 1.323 6.05 2.522 1.063.498 2.582 1.642 3.747 1.642 1.111 0 2.473-1.019 3.49-1.488 2.02-.969 3.667-1.743 5.086-2.203 1.647-.534 3.229-1.968 3.229-3.7 0-3.439 0-4.825-1.283-6.16Z">
                        </path>
                    </svg>
                    <h2>بسته شده</h2>
                    <span>{{ $countResult['status'][4] }} تیکت</span>
                </div>
            </div>
        </div>
    </section>
    <div class="d-flex justify-content-around main-record-boxes">
        <div class="bg-check-signup ">
            <div class="dropdown text-end mt-4 me-4">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    نمایش ({{ $perPage }})
                    <svg class="ms-1" width="12" height="6" viewBox="0 0 12 6" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.5327 1.52796C11.8243 1.23376 11.8222 0.758893 11.528 0.467309C11.2338 0.175726 10.7589 0.177844 10.4673 0.472041L8.72 2.23501C8.01086 2.9505 7.52282 3.44131 7.1093 3.77341C6.7076 4.096 6.44958 4.20668 6.2185 4.23613C6.07341 4.25462 5.92659 4.25462 5.7815 4.23613C5.55042 4.20668 5.2924 4.09601 4.89071 3.77341C4.47718 3.44131 3.98914 2.95051 3.28 2.23501L1.53269 0.472042C1.24111 0.177845 0.766238 0.175726 0.472041 0.46731C0.177844 0.758894 0.175726 1.23376 0.467309 1.52796L2.24609 3.32269C2.91604 3.99866 3.46359 4.55114 3.95146 4.94294C4.45879 5.35037 4.97373 5.64531 5.59184 5.72409C5.86287 5.75864 6.13714 5.75864 6.40816 5.72409C7.02628 5.64531 7.54122 5.35037 8.04854 4.94294C8.53641 4.55114 9.08396 3.99867 9.7539 3.32269L11.5327 1.52796Z"
                            fill="#97F7FF"></path>
                    </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                    <a class="dropdown-item"
                       @if($perPage != 10)
                           href="{{ route('admin.ticket.index', array_merge(request()->query(), ['perPage' => 10])) }}"
                        @endif
                    >10</a>
                    <a class="dropdown-item"
                       @if($perPage != 50)
                           href="{{ route('admin.ticket.index', array_merge(request()->query(), ['perPage' => 50])) }}"
                        @endif
                    >50</a>
                    <a class="dropdown-item"
                       @if($perPage != 100)
                           href="{{ route('admin.ticket.index', array_merge(request()->query(), ['perPage' => 100])) }}"
                        @endif
                    >100</a>
                </ul>
            </div>

            <table class="d-none d-md-table">
                <tbody>
                <tr class="head-nav">
                    <th class="rounded-right"><span class="d-none d-md-block">عنوان</span></th>
                    <th>شناسه</th>
                    <th>شرکت</th>
                    <th>کاربر</th>
                    <th class="d-none d-md-table-cell">وضعیت</th>
                    <th class="d-none d-md-table-cell">آخرین تغییر</th>
                    <th class="d-none d-md-table-cell">بخش</th>
                    <th class="rounded-left">عملیات</th>
                </tr>
                @foreach ($tickets as $ticket)
                    <tr class="bodyTable">
                        <td class="rounded-right ps-4">{{ $ticket->title }}</td>
                        <td class="">{{ $ticket->uuid }}</td>
                        <td class="">{{ $ticket->brand ? $ticket->brand->name : '' }}</td>
                        <td class="">{{ $ticket->user ? $ticket->user->name : '' }}</td>
                        <td class="d-none d-md-table-cell text-success">{{ $ticket->status }}</td>
                        <td class="d-none d-md-table-cell ps-4">{{ $ticket->updated_at }}</td>
                        <td class="d-none d-md-table-cell ps-4">{{ $ticket->category ? $ticket->category->title : '' }}
                        </td>
                        <td class="rounded-left">

                            <a href="{{ route('admin.ticket.show', $ticket->uuid) }}" class="btn btn-primary me-3 d-none d-md-block"
                               style="height: 40px">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="10"
                                     viewBox="0 0 12 10" fill="none">
                                    <path
                                        d="M4.87451 5C4.87451 4.37868 5.37819 3.875 5.99951 3.875C6.62083 3.875 7.12451 4.37868 7.12451 5C7.12451 5.62132 6.62083 6.125 5.99951 6.125C5.37819 6.125 4.87451 5.62132 4.87451 5Z"
                                        fill="white"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M3.17538 1.79786C3.96114 1.1545 4.92904 0.625 5.99951 0.625C7.06999 0.625 8.03789 1.1545 8.82365 1.79786C9.6137 2.44473 10.2597 3.23932 10.6938 3.84401L10.7296 3.8938C10.9909 4.25692 11.2061 4.55583 11.2061 5C11.2061 5.44417 10.9909 5.74308 10.7296 6.10621L10.6938 6.15599C10.2597 6.76068 9.6137 7.55527 8.82365 8.20214C8.03789 8.8455 7.06999 9.375 5.99951 9.375C4.92904 9.375 3.96114 8.8455 3.17538 8.20214C2.38533 7.55527 1.73932 6.76068 1.30522 6.15599L1.26942 6.10621C1.00809 5.74308 0.792969 5.44417 0.792969 5C0.792969 4.55583 1.00809 4.25692 1.26942 3.8938L1.30522 3.84401C1.73932 3.23932 2.38533 2.44473 3.17538 1.79786ZM5.99951 3.125C4.96398 3.125 4.12451 3.96447 4.12451 5C4.12451 6.03553 4.96398 6.875 5.99951 6.875C7.03505 6.875 7.87451 6.03553 7.87451 5C7.87451 3.96447 7.03505 3.125 5.99951 3.125Z"
                                          fill="white"></path>
                                </svg>
                                <span>مشاهده</span>
                            </a>
                            <a href="" class="d-block d-md-none ms-4">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18"
                                     viewBox="0 0 22 18" fill="none">
                                    <path
                                        d="M8.75 9C8.75 7.75736 9.75736 6.75 11 6.75C12.2426 6.75 13.25 7.75736 13.25 9C13.25 10.2426 12.2426 11.25 11 11.25C9.75736 11.25 8.75 10.2426 8.75 9Z"
                                        fill="#2E75DC"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M5.35173 2.59572C6.92325 1.30899 8.85905 0.25 11 0.25C13.141 0.25 15.0768 1.30899 16.6483 2.59572C18.2284 3.88946 19.5204 5.47865 20.3886 6.68801L20.4602 6.78759C20.9829 7.51384 21.4131 8.11166 21.4131 9C21.4131 9.88835 20.9829 10.4862 20.4602 11.2124L20.3886 11.312C19.5204 12.5214 18.2284 14.1105 16.6483 15.4043C15.0768 16.691 13.141 17.75 11 17.75C8.85905 17.75 6.92325 16.691 5.35173 15.4043C3.77164 14.1105 2.47962 12.5214 1.61142 11.312L1.53981 11.2124C1.01715 10.4862 0.586914 9.88834 0.586914 9C0.586914 8.11166 1.01715 7.51384 1.53981 6.78759L1.61142 6.68801C2.47962 5.47865 3.77164 3.88946 5.35173 2.59572ZM11 5.25C8.92893 5.25 7.25 6.92893 7.25 9C7.25 11.0711 8.92893 12.75 11 12.75C13.0711 12.75 14.75 11.0711 14.75 9C14.75 6.92893 13.0711 5.25 11 5.25Z"
                                          fill="#2E75DC"></path>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="accordion m-3 isyap-accordion-mobile d-md-none" id="accordionTickets">
                @foreach ($tickets as $ticket)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#ticket-1" aria-expanded="false" aria-controls="ticket-1">
                                <div>
                                <span class="accordion-ticket-title">
                                    {{$ticket->title}}
                                </span>
                                    <span class="accordion-ticket-status">
                                    {{ $ticket->status }}
                                </span>
                                </div>
                            </button>
                        </h2>
                        <div id="ticket-1" class="accordion-collapse collapse" data-bs-parent="#accordionTickets">
                            <div class="accordion-body">
                                <div class="ticket-accordion-body">
                                    <div class="ticket-accordion-body-item">
                                        <span class="ticket-accordion-body-item-title">شناسه</span>
                                        <p class="ticket-accordion-body-item-text">{{ $ticket->uuid }}</p>
                                    </div>
                                    <div class="ticket-accordion-body-item">
                                        <span class="ticket-accordion-body-item-title">شرکت</span>
                                        <p class="ticket-accordion-body-item-text">{{ $ticket->brand ? $ticket->brand->name : '' }}</p>
                                    </div>
                                    <div class="ticket-accordion-body-item">
                                        <span class="ticket-accordion-body-item-title">کاربر</span>
                                        <p class="ticket-accordion-body-item-text">{{ $ticket->user ? $ticket->user->name : '' }}</p>
                                    </div>
                                    <div class="ticket-accordion-body-item">
                                        <span class="ticket-accordion-body-item-title">آخرین تغییر</span>
                                        <p class="ticket-accordion-body-item-text">{{ $ticket->updated_at }}</p>
                                    </div>
                                    <div class="ticket-accordion-body-item">
                                        <span class="ticket-accordion-body-item-title">بخش</span>
                                        <p class="ticket-accordion-body-item-text">{{ $ticket->category ? $ticket->category->title : '' }}</p>
                                    </div>
                                </div>
                                <div class="ticket-accordion-button text-center">
                                    <a href="#" class="btn btn-primary">مشاهده کنید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <nav aria-label="Page navigation example" class="mt-3">
                {{ $tickets->links('vendor.pagination.admin-pagination') }}
            </nav>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin-assets/panel-assets/js/Ticket.js') }}"></script>
@endsection
