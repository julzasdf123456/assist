<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountLinksRequest;
use App\Http\Requests\UpdateAccountLinksRequest;
use App\Repositories\AccountLinksRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\AccountLinks;
use App\Models\Notifiers;
use App\Models\UserAppLogs;
use Illuminate\Support\Facades\Auth; 
use Flash;
use Response;

class AccountLinksController extends AppBaseController
{
    /** @var  AccountLinksRepository */
    private $accountLinksRepository;

    public function __construct(AccountLinksRepository $accountLinksRepo)
    {
        $this->middleware('auth');
        $this->accountLinksRepository = $accountLinksRepo;
    }

    /**
     * Display a listing of the AccountLinks.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $accountLinks = $this->accountLinksRepository->all();

        return view('account_links.index')
            ->with('accountLinks', $accountLinks);
    }

    /**
     * Show the form for creating a new AccountLinks.
     *
     * @return Response
     */
    public function create()
    {
        return view('account_links.create');
    }

    /**
     * Store a newly created AccountLinks in storage.
     *
     * @param CreateAccountLinksRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountLinksRequest $request)
    {
        $input = $request->all();

        $accountLinks = $this->accountLinksRepository->create($input);

        Flash::success('Account Links saved successfully.');

        return redirect(route('accountLinks.index'));
    }

    /**
     * Display the specified AccountLinks.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $accountLinks = $this->accountLinksRepository->find($id);

        if (empty($accountLinks)) {
            Flash::error('Account Links not found');

            return redirect(route('accountLinks.index'));
        }

        return view('account_links.show')->with('accountLinks', $accountLinks);
    }

    /**
     * Show the form for editing the specified AccountLinks.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $accountLinks = $this->accountLinksRepository->find($id);

        if (empty($accountLinks)) {
            Flash::error('Account Links not found');

            return redirect(route('accountLinks.index'));
        }

        return view('account_links.edit')->with('accountLinks', $accountLinks);
    }

    /**
     * Update the specified AccountLinks in storage.
     *
     * @param int $id
     * @param UpdateAccountLinksRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountLinksRequest $request)
    {
        $accountLinks = $this->accountLinksRepository->find($id);

        if (empty($accountLinks)) {
            Flash::error('Account Links not found');

            return redirect(route('accountLinks.index'));
        }

        $accountLinks = $this->accountLinksRepository->update($request->all(), $id);

        Flash::success('Account Links updated successfully.');

        return redirect(route('accountLinks.index'));
    }

    /**
     * Remove the specified AccountLinks from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $accountLinks = $this->accountLinksRepository->find($id);

        if (empty($accountLinks)) {
            Flash::error('Account Links not found');

            return redirect(route('accountLinks.index'));
        }

        $this->accountLinksRepository->delete($id);

        // REGISTER LOG
        $log = new UserAppLogs;
        $log->UserId = $accountLinks->UserId;
        $log->Type = "Account " . $accountLinks->AccountNumber . " Removed";
        $log->Details = "Account number " . $accountLinks->AccountNumber . " was removed by " . Auth::user()->name . ".";
        $log->save();

        // ADD TO NOTIFIERS
        $notifier = new Notifiers;
        $notifier->Type = "Link Approved";
        $notifier->ToUser = $accountLinks->UserId;
        $notifier->Title = $accountLinks->AccountNumber . " Removed";
        $notifier->Details = "This account was removed by admins for security reason.";
        $notifier->CommentsEnabled = "False";
        $notifier->save();

        Flash::success('Account Links deleted successfully.');

        return redirect(route('users.show', [$accountLinks->UserId]));
    }

    public function approveAccountLink($id) {
        $accountLinks = AccountLinks::find($id);

        if ($accountLinks != null) {
            $accountLinks->Status = "Linked";
            $accountLinks->save();

            // ADD TO NOTIFIERS
            $notifier = new Notifiers;
            $notifier->Type = "Link Approved";
            $notifier->ToUser = $accountLinks->UserId;
            $notifier->Title = $accountLinks->AccountNumber . " Approved";
            $notifier->Details = "Your request for account linking for this account has been approved.";
            $notifier->CommentsEnabled = "False";
            $notifier->save();

            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $accountLinks->UserId;
            $log->Type = "Account Link with Account No. " . $accountLinks->AccountNumber . " Approved";
            $log->Details = "Approved by " . Auth::user()->name;
            $log->save();
        }        

        return redirect(route('users.show', [$accountLinks->UserId]));
    }

    public function rejectAccountLink($id) {
        $accountLinks = AccountLinks::find($id);

        if ($accountLinks != null) {
            $accountLinks->delete();

            // ADD TO NOTIFIERS
            $notifier = new Notifiers;
            $notifier->Type = "Link Approved";
            $notifier->ToUser = $accountLinks->UserId;
            $notifier->Title = $accountLinks->AccountNumber . " Rejected";
            $notifier->Details = "Your request for account linking for this account has been Rejected.";
            $notifier->CommentsEnabled = "False";
            $notifier->save();

            // REGISTER LOG
            $log = new UserAppLogs;
            $log->UserId = $accountLinks->UserId;
            $log->Type = "Account Link with Account No. " . $accountLinks->AccountNumber . " Rejected";
            $log->Details = "Rejected by " . Auth::user()->name;
            $log->save();
        }        

        return redirect(route('users.show', [$accountLinks->UserId]));
    }
}
