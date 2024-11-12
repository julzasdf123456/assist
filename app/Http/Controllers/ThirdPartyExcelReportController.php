<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThirdPartyExcelReportRequest;
use App\Http\Requests\UpdateThirdPartyExcelReportRequest;
use App\Repositories\ThirdPartyExcelReportRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class ThirdPartyExcelReportController extends AppBaseController
{
    /** @var ThirdPartyExcelReportRepository $thirdPartyExcelReportRepository*/
    private $thirdPartyExcelReportRepository;

    public function __construct(ThirdPartyExcelReportRepository $thirdPartyExcelReportRepo)
    {
        $this->middleware('auth');
        $this->thirdPartyExcelReportRepository = $thirdPartyExcelReportRepo;
    }

    /**
     * Display a listing of the ThirdPartyExcelReport.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $thirdPartyExcelReports = $this->thirdPartyExcelReportRepository->all();

        return view('third_party_excel_reports.index')
            ->with('thirdPartyExcelReports', $thirdPartyExcelReports);
    }

    /**
     * Show the form for creating a new ThirdPartyExcelReport.
     *
     * @return Response
     */
    public function create()
    {
        return view('third_party_excel_reports.create');
    }

    /**
     * Store a newly created ThirdPartyExcelReport in storage.
     *
     * @param CreateThirdPartyExcelReportRequest $request
     *
     * @return Response
     */
    public function store(CreateThirdPartyExcelReportRequest $request)
    {
        $input = $request->all();

        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->create($input);

        Flash::success('Third Party Excel Report saved successfully.');

        return redirect(route('thirdPartyExcelReports.index'));
    }

    /**
     * Display the specified ThirdPartyExcelReport.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->find($id);

        if (empty($thirdPartyExcelReport)) {
            Flash::error('Third Party Excel Report not found');

            return redirect(route('thirdPartyExcelReports.index'));
        }

        return view('third_party_excel_reports.show')->with('thirdPartyExcelReport', $thirdPartyExcelReport);
    }

    /**
     * Show the form for editing the specified ThirdPartyExcelReport.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->find($id);

        if (empty($thirdPartyExcelReport)) {
            Flash::error('Third Party Excel Report not found');

            return redirect(route('thirdPartyExcelReports.index'));
        }

        return view('third_party_excel_reports.edit')->with('thirdPartyExcelReport', $thirdPartyExcelReport);
    }

    /**
     * Update the specified ThirdPartyExcelReport in storage.
     *
     * @param int $id
     * @param UpdateThirdPartyExcelReportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateThirdPartyExcelReportRequest $request)
    {
        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->find($id);

        if (empty($thirdPartyExcelReport)) {
            Flash::error('Third Party Excel Report not found');

            return redirect(route('thirdPartyExcelReports.index'));
        }

        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->update($request->all(), $id);

        Flash::success('Third Party Excel Report updated successfully.');

        return redirect(route('thirdPartyExcelReports.index'));
    }

    /**
     * Remove the specified ThirdPartyExcelReport from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $thirdPartyExcelReport = $this->thirdPartyExcelReportRepository->find($id);

        if (empty($thirdPartyExcelReport)) {
            Flash::error('Third Party Excel Report not found');

            return redirect(route('thirdPartyExcelReports.index'));
        }

        $this->thirdPartyExcelReportRepository->delete($id);

        Flash::success('Third Party Excel Report deleted successfully.');

        return redirect(route('thirdPartyExcelReports.index'));
    }
}
