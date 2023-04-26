<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThirdPartyTransactionsRequest;
use App\Http\Requests\UpdateThirdPartyTransactionsRequest;
use App\Repositories\ThirdPartyTransactionsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\ThirdPartyTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AccountMaster;
use App\Models\PaidBills;
use App\Models\Bills;
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
        $thirdPartyTransactions = DB::table('ThirdPartyTransactions')
            ->select(
                DB::raw("TRY_CAST(created_at AS DATE) As DateOfTransaction"),
                "Company",
                DB::raw("COUNT(id) AS NumberOfTransactions"),
                DB::raw("SUM(TRY_CAST(TotalAmount AS DECIMAL(15,2))) AS Total")
            )
            ->whereRaw("Status IS NULL")
            ->groupBy("Company")
            ->groupByRaw("TRY_CAST(created_at AS DATE)")
            ->orderByRaw("TRY_CAST(created_at AS DATE)")
            ->get();

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

    public function viewTransactions($date, $company) {
        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status IS NULL")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $account = AccountMaster::find($item->AccountNumber);
            $paidBill = PaidBills::where('AccountNumber', $item->AccountNumber)
                ->where('ServicePeriodEnd', date('Y-m-d', strtotime($item->ServicePeriodEnd)))
                ->first();

            array_push($data, [
                'id' => $item->id,
                'AccountNumber' => $item->AccountNumber,
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'BillNumber' => $item->BillNumber,
                'KwhUsed' => $item->KwhUsed,
                'Amount' => $item->Amount,
                'Surcharge' => $item->Surcharge,
                'TotalAmount' => $item->TotalAmount,
                'Teller' => $item->Teller,
                'Company' => $item->Company,
                'RefNo' => $item->ORNumber,
                'created_at' => $item->created_at,
                'ConsumerName' => $account != null ? $account->ConsumerName : '-',
                'ORNumber' => $paidBill != null ? $paidBill->ORNumber : null,
                'Posted' => $paidBill != null ? 'Yes' : 'No',
            ]);
        }
        
        return view('/third_party_transactions/view_transactions', [
            'company' => $company,
            'date' => $date,
            'data' => $data
        ]);
    }

    public function postTransactions(Request $request) {
        $date = $request['Date'];
        $company = $request['Company'];

        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status IS NULL")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $account = AccountMaster::find($item->AccountNumber);
            $paidBill = PaidBills::where('AccountNumber', $item->AccountNumber)
                ->where('ServicePeriodEnd', $item->ServicePeriodEnd)
                ->first();
            $bill = Bills::where('AccountNumber', $item->AccountNumber)
                ->where('ServicePeriodEnd', $item->ServicePeriodEnd)
                ->first();

            if ($paidBill != null) {
                // SKIP DOUBLE PAYMENTS
                $item->Status = 'DOUBLE PAYMENTS';
                $item->save();
            } else {
                if ($bill != null) {
                    // GET VAT OF SURCHARGE FIRST
                    if ($item->Surcharge > 0) {
                        $sVat = floatval($item->Surcharge) - (floatval($item->Surcharge) / 1.12);
                        $surcharge = (floatval($item->Surcharge) / 1.12);
                    } else {
                        $sVat = 0;
                        $surcharge = 0;
                    }

                    $paidBill = new PaidBills;
                    $paidBill->AccountNumber = $item->AccountNumber;
                    $paidBill->BillNumber = $bill->BillNumber;
                    $paidBill->ServicePeriodEnd = $bill->ServicePeriodEnd;
                    $paidBill->Power = $bill->KWHAmount;
                    $paidBill->Meter = round(floatval($bill->Item2) + $sVat, 2);
                    $paidBill->PR = $bill->PR;
                    $paidBill->Others = $bill->Others;
                    $paidBill->NetAmount = $item->TotalAmount;
                    $paidBill->PaymentType = 'SUB-OFFICE/STATION';
                    $paidBill->ORNumber = null;
                    $paidBill->Teller = $item->Company;
                    $paidBill->DCRNumber = "";
                    $paidBill->PostingDate = $item->created_at;
                    $paidBill->PostingSequence = '1';
                    $paidBill->PromptPayment = '0';
                    $paidBill->Surcharge = round($surcharge, 2);
                    $paidBill->save();

                    $item->Status = 'POSTED | ' . Auth::user()->name;
                    $item->save();
                } else {
                    // BILL NOT FOUND
                }               
            }
        }

        return response('ok', 200);
    }

    public function markAsPosted(Request $request) {
        $date = $request['Date'];
        $company = $request['Company'];

        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status IS NULL")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $item->Status = 'POSTED | ' . Auth::user()->name;
            $item->save();
        }

        return response('ok', 200);
    }

    public function postedTransactions(Request $request) {
        $thirdPartyTransactions = DB::table('ThirdPartyTransactions')
            ->select(
                DB::raw("TRY_CAST(created_at AS DATE) As DateOfTransaction"),
                "Company",
                DB::raw("COUNT(id) AS NumberOfTransactions"),
                DB::raw("SUM(TRY_CAST(TotalAmount AS DECIMAL(15,2))) AS Total")
            )
            ->whereRaw("Status IS NOT NULL")
            ->groupBy("Company")
            ->groupByRaw("TRY_CAST(created_at AS DATE)")
            ->orderByRaw("TRY_CAST(created_at AS DATE) DESC")
            ->get();

        return view('third_party_transactions.posted_transactions', [
            'thirdPartyTransactions' => $thirdPartyTransactions
        ]);
    }

    public function viewPostedTransactions($date, $company) {
        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status IS NOT NULL")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $account = AccountMaster::find($item->AccountNumber);
            $paidBill = PaidBills::where('AccountNumber', $item->AccountNumber)
                ->where('ServicePeriodEnd', date('Y-m-d', strtotime($item->ServicePeriodEnd)))
                ->first();

            array_push($data, [
                'id' => $item->id,
                'AccountNumber' => $item->AccountNumber,
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'BillNumber' => $item->BillNumber,
                'KwhUsed' => $item->KwhUsed,
                'Amount' => $item->Amount,
                'Surcharge' => $item->Surcharge,
                'TotalAmount' => $item->TotalAmount,
                'Teller' => $item->Teller,
                'Company' => $item->Company,
                'RefNo' => $item->ORNumber,
                'created_at' => $item->created_at,
                'ConsumerName' => $account != null ? $account->ConsumerName : '-',
                'ORNumber' => $paidBill != null ? $paidBill->ORNumber : null,
                'ORDate' => $paidBill != null ? $paidBill->ORDate : null,
                'Status' => $item->Status,
            ]);
        }
        
        return view('/third_party_transactions/view_posted_transactions', [
            'company' => $company,
            'date' => $date,
            'data' => $data
        ]);
    }

    public function printDoublePayments($date, $company) {
        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status='DOUBLE PAYMENTS'")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $account = AccountMaster::find($item->AccountNumber);

            array_push($data, [
                'id' => $item->id,
                'AccountNumber' => $item->AccountNumber,
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'BillNumber' => $item->BillNumber,
                'KwhUsed' => $item->KwhUsed,
                'Amount' => $item->Amount,
                'Surcharge' => $item->Surcharge,
                'TotalAmount' => $item->TotalAmount,
                'Teller' => $item->Teller,
                'Company' => $item->Company,
                'RefNo' => $item->ORNumber,
                'created_at' => $item->created_at,
                'ConsumerName' => $account != null ? $account->ConsumerName : '-',
                'Status' => $item->Status,
            ]);
        }

        return view('/third_party_transactions/print_double_payments', [
            'company' => $company,
            'date' => $date,
            'data' => $data
        ]);
    }

    public function printPostedPayments($date, $company) {
        $transactions = ThirdPartyTransactions::whereRaw("Company='" . $company . "' AND TRY_CAST(created_at AS DATE)='" . $date . "' AND Status LIKE 'POSTED%'")
            ->select('*')
            ->orderBy('created_at')
            ->get();

        $data = [];
        foreach($transactions as $item) {
            $account = AccountMaster::find($item->AccountNumber);

            array_push($data, [
                'id' => $item->id,
                'AccountNumber' => $item->AccountNumber,
                'ServicePeriodEnd' => $item->ServicePeriodEnd,
                'BillNumber' => $item->BillNumber,
                'KwhUsed' => $item->KwhUsed,
                'Amount' => $item->Amount,
                'Surcharge' => $item->Surcharge,
                'TotalAmount' => $item->TotalAmount,
                'Teller' => $item->Teller,
                'Company' => $item->Company,
                'RefNo' => $item->ORNumber,
                'created_at' => $item->created_at,
                'ConsumerName' => $account != null ? $account->ConsumerName : '-',
                'Status' => $item->Status,
            ]);
        }

        return view('/third_party_transactions/print_posted_payments', [
            'company' => $company,
            'date' => $date,
            'data' => $data
        ]);
    }
}
