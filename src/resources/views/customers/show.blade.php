@extends('layouts.app')

@can('view', $customer)
    @section('title', 'Customer Profile')

    @section('content')

        <ul>
            <li>First Name : {{ $customer->first_name }}</li>
            <li>Last Name : {{ $customer->last_name }}</li>
            <li>DOB: {{ $customer->dob }}</li>
            <li>Gender: {{ $customer->gender }}</li>
            <li>Created: {{ $customer->created_at }}</li>

            @if($customer->contactDetails)
                <h3>Contact details</h3>
                <ul>
                    <li>Email: {{ $customer->user->email }}</li>
                    <li>Phone: {{ $customer->contactDetails->phone }}</li>
                    <li>Address: {{ $customer->contactDetails->address_1 }}</li>
                    <li>Address: {{ $customer->contactDetails->address_2 }}</li>
                    <li>Address: {{ $customer->contactDetails->address_3 }}</li>
                    <li>City: {{ $customer->contactDetails->city }}</li>
                    <li>County: {{ $customer->contactDetails->county }}</li>
                    <li>Post code: {{ $customer->contactDetails->post_code }}</li>
                    <li>Country: {{ $customer->contactDetails->country }}</li>
                </ul>
            @endif

        </ul>

        <form action="{{ route('customers.destroy', $customer) }}" method="POST">
            @csrf
            @method('DELETE')
                <input type="hidden" name="list" value="{{ $lists }}">
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <input id="delete" type="submit" onclick="return confirm('Are you sure?')" name="submit" value="Delete">
        </form>
        <br>
        <a href="{{ route('customers.edit', $customer->id ) }}">Edit Profile</a>
    <br><br>
        <div>
            <h3>Customers Lists</h3>
        </div>
        <table>
            <tr>
                <th>Event</th>
                <th>Slot</th>
                <th>List Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        @forelse($lists as $list)
            <tr>
                <td>{{ $list['eventName'] }}</td>
                <td>{{ $list['slotName'] }}</td>
                <td>{{ $list['listName'] }} </td>
                <td>{{ $list['startDate'] }}</td>
                <td>{{ $list['endDate'] }}</td>
                <td>{{ $list['status'] }}</td>
            </tr>
        @empty

        </table>
            <div>
                <h3>Customer list applications</h3>
            </div>
        @endforelse

        <br>
    @endsection
@endcan