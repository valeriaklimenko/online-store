@extends('layouts.app')

@section('title', 'Менеджеры — Klavera')

@section('content')
    <div class="page-head">
        <div>
            <p class="overline">Команда магазина</p>
            <h1 class="section-title">Управление менеджерами</h1>
        </div>
        <a href="{{ route('managers.create') }}" class="btn btn-primary">Добавить менеджера</a>
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
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Дата создания</th>
                        <th class="text-right">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($managers as $manager)
                        <tr>
                            <td>{{ $manager->name }}</td>
                            <td>{{ $manager->email }}</td>
                            <td>{{ $manager->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-right">
                                <form action="{{ route('managers.destroy', $manager->id) }}" method="POST" onsubmit="return confirm('Удалить менеджера {{ $manager->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-ghost">Удалить</button>
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
                <h3 class="section-heading">Менеджеры ещё не добавлены</h3>
                <p>Создайте первого менеджера, чтобы дать ему доступ к панели управления.</p>
                <a href="{{ route('managers.create') }}" class="btn btn-primary">Добавить менеджера</a>
            </div>
        @endif
    </div>
@endsection














