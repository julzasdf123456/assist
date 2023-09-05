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
                DB::raw("(SELECT TOP 1 ColorHex FROM ThirdPartytokens WHERE Company=ThirdPartyTransactions.Company) AS Color"),
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
            $paidBill = PaidBills::whereRaw("AccountNumber='" . $item->AccountNumber . "' AND ServicePeriodEnd='" . date('Y-m-d', strtotime($item->ServicePeriodEnd)) . "'")
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
                'ORNumber' => '' /**  $paidBill != null ? $paidBill->ORNumber : null **/,
                'Posted' => '' /**  $paidBill != null ? 'Yes' : 'No' **/,
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
            $paidBill = PaidBills::whereRaw("AccountNumber='" . $item->AccountNumber . "' AND ServicePeriodEnd='" . date('Y-m-d', strtotime($item->ServicePeriodEnd)) . "'")
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

    public function getPostedCalendarData(Request $request) {
        $data = DB::connection('sqlsrv')
            ->table('ThirdPartyTransactions')
            ->whereRaw("Status IS NOT NULL")
            ->select(
                DB::raw("TRY_CAST(created_at AS DATE) AS DateCollected"),
                'Company',
                DB::raw("(SELECT TOP 1 ColorHex FROM ThirdPartytokens WHERE Company=ThirdPartyTransactions.Company) AS Color"),
                DB::raw("SUM(TotalAmount) AS TotalCollection"),
                DB::raw("COUNT(id) AS NoOfCollection"),
            )
            ->groupByRaw(DB::raw("TRY_CAST(created_at AS DATE)"))
            ->groupBy('Company')
            ->get();

        return response()->json($data, 200);
    }

    public function getGraphData(Request $request) {
        $month = $request['Month'];
        $year = $request['Year'];

        $joined = $year . "-" . $month;
        $from = $year . "-" . $month . "-01";
        $to = date('Y-m-d', strtotime("last day of " . $from));

        $lastDate = date('d', strtotime("last day of " . $from));
        $lastDate = intval($lastDate);

        $data = DB::connection('sqlsrv')
            ->table('ThirdPartyTransactions')
            ->whereRaw("TRY_CAST(created_at AS DATE) BETWEEN '" . $from . "' AND '" . $to . "'")
            ->select(
                'Company',
                DB::raw("SUM(TotalAmount) AS TotalCollection"),
                DB::raw("(SELECT TOP 1 ColorHex FROM ThirdPartytokens WHERE Company=ThirdPartyTransactions.Company) AS Color"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-01') AS Data01"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-02') AS Data02"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-03') AS Data03"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-04') AS Data04"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-05') AS Data05"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-06') AS Data06"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-07') AS Data07"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-08') AS Data08"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-09') AS Data09"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-10') AS Data10"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-11') AS Data11"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-12') AS Data12"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-13') AS Data13"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-14') AS Data14"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-15') AS Data15"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-16') AS Data16"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-17') AS Data17"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-18') AS Data18"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-19') AS Data19"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-20') AS Data20"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-21') AS Data21"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-22') AS Data22"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-23') AS Data23"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-24') AS Data24"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-25') AS Data25"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-26') AS Data26"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-27') AS Data27"),
                $lastDate >= 28 ? DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-28') AS Data28") : DB::raw("'0' AS Data28"),
                $lastDate >= 29 ? DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-29') AS Data29") : DB::raw("'0' AS Data29"),
                $lastDate >= 30 ? DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-30') AS Data30") : DB::raw("'0' AS Data30"),
                $lastDate >= 31 ? DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE)='" . $joined . "-31') AS Data31") : DB::raw("'0' AS Data31"),
            )
            ->groupBy('Company')
            ->get();

        return response()->json($data, 200);
    }

    public function getGraphDataYearly(Request $request) {
        $year = $request['Year'];

        $from = $year . "-01-01";
        $to = date('Y-m-d', strtotime("last day of December " . $year));

        $data = DB::connection('sqlsrv')
            ->table('ThirdPartyTransactions')
            ->whereRaw("TRY_CAST(created_at AS DATE) BETWEEN '" . $from . "' AND '" . $to . "'")
            ->select(
                'Company',
                DB::raw("SUM(TotalAmount) AS TotalCollection"),
                DB::raw("(SELECT TOP 1 ColorHex FROM ThirdPartytokens WHERE Company=ThirdPartyTransactions.Company) AS Color"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-01-01' AND '" . ThirdPartyTransactions::getLastDayOf('January', $year) . "') AS January"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-02-01' AND '" . ThirdPartyTransactions::getLastDayOf('February', $year) . "') AS February"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-03-01' AND '" . ThirdPartyTransactions::getLastDayOf('March', $year) . "') AS March"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-04-01' AND '" . ThirdPartyTransactions::getLastDayOf('April', $year) . "') AS April"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-05-01' AND '" . ThirdPartyTransactions::getLastDayOf('May', $year) . "') AS May"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-06-01' AND '" . ThirdPartyTransactions::getLastDayOf('June', $year) . "') AS June"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-07-01' AND '" . ThirdPartyTransactions::getLastDayOf('July', $year) . "') AS July"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-08-01' AND '" . ThirdPartyTransactions::getLastDayOf('August', $year) . "') AS August"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-09-01' AND '" . ThirdPartyTransactions::getLastDayOf('September', $year) . "') AS September"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-10-01' AND '" . ThirdPartyTransactions::getLastDayOf('October', $year) . "') AS October"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-11-01' AND '" . ThirdPartyTransactions::getLastDayOf('November', $year) . "') AS November"),
                DB::raw("(SELECT SUM(a.TotalAmount) FROM ThirdPartyTransactions a WHERE a.Company=ThirdPartyTransactions.Company AND TRY_CAST(a.created_at AS DATE) BETWEEN '" . $year . "-12-01' AND '" . ThirdPartyTransactions::getLastDayOf('December', $year) . "') AS December"),
            )
            ->groupBy('Company')
            ->get();

        return response()->json($data, 200);
    }
}
