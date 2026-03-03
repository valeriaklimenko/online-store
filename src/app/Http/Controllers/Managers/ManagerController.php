<?php

namespace App\Http\Controllers\Managers;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Managers\ManagerStoreRequest;
use App\Services\ManagerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ManagerController extends Controller
{
    /**
     * Display manager dashboard.
     */
    public function dashboard(): View
    {
        return view('managers.dashboard');
    }

    /**
     * Display a listing of managers.
     */
    public function index(ManagerService $managerService): View
    {
        $managers = $managerService->getAllManagers();
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
     * Create a new manager in storage.
     */
    public function store(ManagerStoreRequest $request, ManagerService $managerService): RedirectResponse
    {
        $managerService->createManager($request->validated());
        return redirect()->route('managers.index')
            ->with('success', FlashMessage::MANAGER_CREATED->value);
    }

    /**
     * Remove the specified manager from storage.
     */
    public function destroy(int $id, ManagerService $managerService): RedirectResponse
    {
        $managerService->deleteManager($id);
        return redirect()->route('managers.index')
            ->with('success', FlashMessage::MANAGER_DELETED->value);
    }
}
