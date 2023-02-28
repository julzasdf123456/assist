<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThirdPartyTransactionsRequest;
use App\Http\Requests\UpdateThirdPartyTransactionsRequest;
use App\Repositories\ThirdPartyTransactionsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\ThirdPartyTransactions;
use Flash;
use Response;

class ThirdPartyTransactionsController extends AppBaseController
{
    /** @var  ThirdPartyTransactionsRepository */
    private $thirdPartyTransactionsRepository;

    public function __construct(ThirdPartyTransactionsRepository $thirdPartyTransactionsRepo)
    {
        $this->middleware('auth');
        $this->thirdPartyTransactionsRepository = $thirdPartyTransactionsRepo;
    }

    /**
     * Display a listing of the ThirdPartyTransactions.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $thirdPartyTransactions = ThirdPartyTransactions::orderByDesc('created_at')->get();

        return view('third_party_transactions.index', [
            'thirdPartyTransactions' => $thirdPartyTransactions
        ]);
    }

    /**
     * Show the form for creating a new ThirdPartyTransactions.
     *
     * @return Response
     */
    public function create()
    {
        return view('third_party_transactions.create');
    }

    /**
     * Store a newly created ThirdPartyTransactions in storage.
     *
     * @param CreateThirdPartyTransactionsRequest $request
     *
     * @return Response
     */
    public function store(CreateThirdPartyTransactionsRequest $request)
    {
        $input = $request->all();

        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->create($input);

        Flash::success('Third Party Transactions saved successfully.');

        return redirect(route('thirdPartyTransactions.index'));
    }

    /**
     * Display the specified ThirdPartyTransactions.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->find($id);

        if (empty($thirdPartyTransactions)) {
            Flash::error('Third Party Transactions not found');

            return redirect(route('thirdPartyTransactions.index'));
        }

        return view('third_party_transactions.show')->with('thirdPartyTransactions', $thirdPartyTransactions);
    }

    /**
     * Show the form for editing the specified ThirdPartyTransactions.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->find($id);

        if (empty($thirdPartyTransactions)) {
            Flash::error('Third Party Transactions not found');

            return redirect(route('thirdPartyTransactions.index'));
        }

        return view('third_party_transactions.edit')->with('thirdPartyTransactions', $thirdPartyTransactions);
    }

    /**
     * Update the specified ThirdPartyTransactions in storage.
     *
     * @param int $id
     * @param UpdateThirdPartyTransactionsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateThirdPartyTransactionsRequest $request)
    {
        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->find($id);

        if (empty($thirdPartyTransactions)) {
            Flash::error('Third Party Transactions not found');

            return redirect(route('thirdPartyTransactions.index'));
        }

        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->update($request->all(), $id);

        Flash::success('Third Party Transactions updated successfully.');

        return redirect(route('thirdPartyTransactions.index'));
    }

    /**
     * Remove the specified ThirdPartyTransactions from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $thirdPartyTransactions = $this->thirdPartyTransactionsRepository->find($id);

        if (empty($thirdPartyTransactions)) {
            Flash::error('Third Party Transactions not found');

            return redirect(route('thirdPartyTransactions.index'));
        }

        $this->thirdPartyTransactionsRepository->delete($id);

        Flash::success('Third Party Transactions deleted successfully.');

        return redirect(route('thirdPartyTransactions.index'));
    }
}
