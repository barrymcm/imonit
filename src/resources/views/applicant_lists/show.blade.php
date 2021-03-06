@extends('layouts.app')

@section('title', 'Listing')

@section('content')

    @if(session()->has('cancel'))
        <div class="grid grid-cols-1 w-full">
            <p class="alert-info">{!! session()->get('cancel') !!}</p>
        </div>
    @endif

    <div class="grid grid-cols-4 grid-flow-rows bg-blue-400 rounded-md text-center h-28 p-5 mb-14">
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Event Name</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">List Name</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Max Applicants</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Available Places</div>
        <div class="my-3">{{ $event->name }}</div>
        <div class="my-3">{{ $list->name }}</div>
        <div class="my-3">{{ $list->max_applicants }}</div>
        <div class="my-3">{{ $list->max_applicants - count($list->applicants)}}</div>
    </div>

    <div class="grid grid-cols-4 grid-flow-rows px-5">
        <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Name</div>
        <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Application date</div>
        
        @can('organiser-view', $user)
            <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Time</div>
            <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Attended</div>
        @endcan

        @foreach($list->applicants as $applicant)
            <div class="col-start-1 py-3">
                {{ $applicant->first_name }} {{ $applicant->last_name }}
            </div>
            <div class="col-start-2 py-3">
                {{ $applicant->created_at->format('l jS \\of F Y') }}
            </div>
            
            @can('organiser-view', $user)
                <div class="col-start-3 py-3">
                    {{ $applicant->created_at->format('h:i:s A') }}
                </div>
            @endcan    
            
            @can('view', $applicant)
                <div class="flex flex-cols-2 col-start-4 justify-between">
                    <div class="bg-blue-400 text-white rounded-md h-10 px-4 py-2">
                        <a class="w-full" href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                    </div>

                    <div>
                        <form  action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                            <input type="hidden" name="event" value="{{ $event->id }}">
                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                            <input class="bg-red-500 text-white rounded-md h-10 px-4 py-1" type="submit" value="Remove Me">
                        </form>
                    </div>
                </div>
            @endcan

            @can('organiser-view', $user)
            <div class="flex flex-cols-3 col-start-4 h-10 justify-between text-white text-center">
                <div class="align-center ml-7 pt-3">
                    <input id="applicant" type="checkbox" name="{{ $list->id }}" value="{{ $applicant->id }}" onclick="sendData({{ $list->id }}, {{ $applicant->id }})">
                </div>
                <div class="bg-blue-400 rounded-md ml-7 py-2 cursor-pointer">
                    <a class="w-1/3 px-3" href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                </div>

                <div class="w-1/3">
                    <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                        <input type="hidden" name="event" value="{{ $event->id }}">
                        <input type="hidden" name="list_id" value="{{ $list->id }}">
                        <input class="bg-red-500 rounded-md py-2 px-3 cursor-pointer" type="submit" value="Delete">
                    </form>
                </div>
            </div>
            @endcan
        @endforeach
    </div>
    @if( session('warning'))
        {{ session('warning') }}
        <a href="{{ route('login', ['list' => $list, 'event' => $event]) }}">sign in?</a>
        or if you dont have an account you can
        <a href="{{ route('register.select_account_type', ['list' => $list, 'event' => $event]) }}">register</a>
    @endif
 
    @if( session('notice'))
        <p class="alert-info">
            {{ session('notice') }} <a href="{{ route('customers.create', ['id' => auth()->user()->customer]) }}">Click here!</a>
        </p>
    @endif

    @if( session('status'))
        <p class="alert-info">{{ session('status') }}</p>
    @endif

    @can('add', $user)
        @if (count($list->applicants) < $list->max_applicants && !$isOnList)
            <div class="flex leading-loose text-white my-10 mx-10 justify-end">
                <a class="bg-green-400 h-10 rounded-md px-4 py-1 w-1/8" href="{{ route('applicants.create', [ 'list' => $list, 'event' => $event]) }}">Add me!</a>
            </div>
        @endif
    @endcan

    @can('organiser-view', $user)
    <div class="flex flex-row justify-end text-white">
        <a class="rounded-md bg-yellow-400 my-10 px-3 py-2 mr-5" href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">Edit List</a>
        @if(count($list->applicants) < 1)
            <form action="{{ route('applicant_lists.destroy', $list->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="event" value="{{ $event->id }}">
                <input class="rounded-md bg-red-500 my-10 px-3 py-1 mr-5" type="submit" name="submit" value="Cancel List">
            </form>
        @endif
    </div>
    @endcan

    <div class="flex leading-loose text-blue-700 my-10">
        <a class="flex items-center pb-3" href="{{ route('events.show', $event) }}">
            <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
            </svg>
        Back to Slot</a>
    </div>

@endsection

<script type="text/javascript">
    var xhro = false;

    if(window.XMLHttpRequest) {
        var xhro = new XMLHttpRequest();
    }

    function sendData(listId, applicantId) 
    {
        var url = '/applicants/attended';

        if(xhro) {
            xhro.open("POST", url, true);
            xhro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }

        xhro.send("applicant_id=" + applicantId + "&list_id=" + listId);
    }
</script>