@extends('layouts.app')

@section('title', 'Managers — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Store Team</p>
            <h1 class="section-title">Manager Management</h1>
        </div>
        <a href="{{ route('managers.create') }}" class="btn btn-primary">Add Manager</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        @if($managers->count())
            <table class="table-shell">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($managers as $manager)
                        <tr>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>{{ $manager->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-right">
                                <form action="{{ route('managers.destroy', $manager->id) }}" method="POST" onsubmit="return confirm('Delete manager {{ $manager->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if(method_exists($managers, 'links'))
                <div class="pagination-row">
                    {{ $managers->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <h3 class="section-heading">No Managers Added Yet</h3>
                <p>Create your first manager to give them access to the control panel.</p>
                <a href="{{ route('managers.create') }}" class="btn btn-primary">Add Manager</a>
            </div>
        @endif
    </div>
@endsection
