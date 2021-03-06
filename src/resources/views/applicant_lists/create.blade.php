@extends('layouts.app')

@section('title', 'Create List')

@section('content')

@can('create-list', $user)
<div class="flex flex-row border-gray-300 w-1/3 my-10 rounded-md justify-between">
    <form class="w-full" action="{{ route('applicant_lists.store', ['slot' => $slot, 'event' => $event]) }}" method="POST">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event }}">
        <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="hidden" name="slot_id" value="{{ $slot }}">

        <div class="flex my-5 h-10 justify-between">
            <label class="py-2" for="name">List name:</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="text" name="name" value="">
        </div>
        <div class="flex my-5 h-10 justify-between">
            <label class="py-2" for="max_applicants">Max applicants</label>
            <input class="rounded-md border-2 border-gray-300 h-10 px-5" type="number" name="max_applicants" min="1">
        </div>
        <div class="flex mt-14 h-10 justify-end">
            <input class="cursor-pointer rounded-md bg-green-600 text-white h-10 px-5 hover:bg-green-700 transition-ease-in-out duration-150" type="submit" value="Create">    
        </div>
        
    </form>
</div>
<div class="flex flex-row text-blue-700 w-1/4 my-5 justify-between">
    <a class="flex items-center pb-3" href="{{ route('events.show', $event) }}">
        <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
            <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
        </svg>
    Back to event</a>
</div>
@endcan

@endsection