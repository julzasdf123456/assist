<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountLinksRequest;
use App\Http\Requests\UpdateAccountLinksRequest;
use App\Repositories\AccountLinksRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class AccountLinksController extends AppBaseController
{
    /** @var  AccountLinksRepository */
    private $accountLinksRepository;

    public function __construct(AccountLinksRepository $accountLinksRepo)
    {
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

        Flash::success('Account Links deleted successfully.');

        return redirect(route('users.index'));
    }
}
