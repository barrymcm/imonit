@extends('layouts.app')

@section('title', 'Listing')

@section('content')
    <table>
        <head>
            <tr>
                <th>List Name</th>
                <th>Max Applicants</th>
                <th>Name</th>
                <th>Application date</th>
                <th>Time</th>
            </tr>
        </head>
        <tbody>
        <tr>
            <td>{{ $list->name }}</td>
            <td>{{ $list->max_applicants }}</td>
        </tr>
        @foreach($list->applicants as $applicant)
            <tr>
                <td></td>
                <td></td>
                <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                <td>{{ $applicant->created_at->format('l jS \\of F Y') }}</td>
                <td>{{ $applicant->created_at->format('h:i:s A') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <a href="{{ route('events.show', ['event' => $event]) }}">Back to events</a>
    <br><br>
    @if(count($list->applicants) < $list->max_applicants)
        {{--<a href="{{ route('applicant.create', $list->id, $event) }}">Add new applicant</a>--}}
    @endif
@endsection