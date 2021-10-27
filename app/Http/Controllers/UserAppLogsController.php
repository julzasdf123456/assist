<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserAppLogsRequest;
use App\Http\Requests\UpdateUserAppLogsRequest;
use App\Repositories\UserAppLogsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class UserAppLogsController extends AppBaseController
{
    /** @var  UserAppLogsRepository */
    private $userAppLogsRepository;

    public function __construct(UserAppLogsRepository $userAppLogsRepo)
    {
        $this->middleware('auth');
        $this->userAppLogsRepository = $userAppLogsRepo;
    }

    /**
     * Display a listing of the UserAppLogs.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userAppLogs = $this->userAppLogsRepository->all();

        return view('user_app_logs.index')
            ->with('userAppLogs', $userAppLogs);
    }

    /**
     * Show the form for creating a new UserAppLogs.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_app_logs.create');
    }

    /**
     * Store a newly created UserAppLogs in storage.
     *
     * @param CreateUserAppLogsRequest $request
     *
     * @return Response
     */
    public function store(CreateUserAppLogsRequest $request)
    {
        $input = $request->all();

        $userAppLogs = $this->userAppLogsRepository->create($input);

        Flash::success('User App Logs saved successfully.');

        return redirect(route('userAppLogs.index'));
    }

    /**
     * Display the specified UserAppLogs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userAppLogs = $this->userAppLogsRepository->find($id);

        if (empty($userAppLogs)) {
            Flash::error('User App Logs not found');

            return redirect(route('userAppLogs.index'));
        }

        return view('user_app_logs.show')->with('userAppLogs', $userAppLogs);
    }

    /**
     * Show the form for editing the specified UserAppLogs.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userAppLogs = $this->userAppLogsRepository->find($id);

        if (empty($userAppLogs)) {
            Flash::error('User App Logs not found');

            return redirect(route('userAppLogs.index'));
        }

        return view('user_app_logs.edit')->with('userAppLogs', $userAppLogs);
    }

    /**
     * Update the specified UserAppLogs in storage.
     *
     * @param int $id
     * @param UpdateUserAppLogsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserAppLogsRequest $request)
    {
        $userAppLogs = $this->userAppLogsRepository->find($id);

        if (empty($userAppLogs)) {
            Flash::error('User App Logs not found');

            return redirect(route('userAppLogs.index'));
        }

        $userAppLogs = $this->userAppLogsRepository->update($request->all(), $id);

        Flash::success('User App Logs updated successfully.');

        return redirect(route('userAppLogs.index'));
    }

    /**
     * Remove the specified UserAppLogs from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userAppLogs = $this->userAppLogsRepository->find($id);

        if (empty($userAppLogs)) {
            Flash::error('User App Logs not found');

            return redirect(route('userAppLogs.index'));
        }

        $this->userAppLogsRepository->delete($id);

        Flash::success('User App Logs deleted successfully.');

        return redirect(route('userAppLogs.index'));
    }
}
