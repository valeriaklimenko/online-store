<?php

namespace App\Http\Controllers\Managers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\ManagerStoreRequest;
use App\Models\User;
use App\Services\Managers\ManagerCreateService;
use App\Services\Managers\ManagerDeleteService;
use App\Services\Managers\ManagerListService;
use App\Services\Managers\ManagerStoreService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;


class ManagerController extends Controller
{

    /**
     * Display manager dashboard.
     */
    public function dashboard(): \Illuminate\Contracts\View\View
    {
        return view('managers.dashboard');
    }

    /**
     * Display a listing of managers.
     */
    public function index(ManagerListService $listService): View
    {
        $managers = $listService->getAllManagers();
        return view('managers.index', compact('managers'));
    }

    /**
     * Show the form for creating a new manager.
     */
    public function create(): View
    {
        return view('managers.create');
    }

    /**
     * Created a new manager in storage.
     */
    public function store(ManagerStoreRequest $request, ManagerStoreService $managerStoreService): RedirectResponse
    {
        $managerStoreService->store($request->validated());
        return redirect()->route('managers.index')
            ->with('success', 'Менеджер успешно создан');
    }

    /**
     * Remove the specified manager from storage.
     */
    public function destroy(string  $id, ManagerDeleteService $deleteManagerService): RedirectResponse
    {
        $deleteManagerService->deleteManager($id);
        return redirect()->route('managers.index')
            ->with('success', 'The manager was successfully deleted');
    }
}
