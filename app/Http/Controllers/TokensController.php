<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTokensRequest;
use App\Http\Requests\UpdateTokensRequest;
use App\Repositories\TokensRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TokensController extends AppBaseController
{
    /** @var  TokensRepository */
    private $tokensRepository;

    public function __construct(TokensRepository $tokensRepo)
    {
        $this->tokensRepository = $tokensRepo;
    }

    /**
     * Display a listing of the Tokens.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tokens = $this->tokensRepository->all();

        return view('tokens.index')
            ->with('tokens', $tokens);
    }

    /**
     * Show the form for creating a new Tokens.
     *
     * @return Response
     */
    public function create()
    {
        return view('tokens.create');
    }

    /**
     * Store a newly created Tokens in storage.
     *
     * @param CreateTokensRequest $request
     *
     * @return Response
     */
    public function store(CreateTokensRequest $request)
    {
        $input = $request->all();

        $tokens = $this->tokensRepository->create($input);

        Flash::success('Tokens saved successfully.');

        return redirect(route('tokens.index'));
    }

    /**
     * Display the specified Tokens.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tokens = $this->tokensRepository->find($id);

        if (empty($tokens)) {
            Flash::error('Tokens not found');

            return redirect(route('tokens.index'));
        }

        return view('tokens.show')->with('tokens', $tokens);
    }

    /**
     * Show the form for editing the specified Tokens.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tokens = $this->tokensRepository->find($id);

        if (empty($tokens)) {
            Flash::error('Tokens not found');

            return redirect(route('tokens.index'));
        }

        return view('tokens.edit')->with('tokens', $tokens);
    }

    /**
     * Update the specified Tokens in storage.
     *
     * @param int $id
     * @param UpdateTokensRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTokensRequest $request)
    {
        $tokens = $this->tokensRepository->find($id);

        if (empty($tokens)) {
            Flash::error('Tokens not found');

            return redirect(route('tokens.index'));
        }

        $tokens = $this->tokensRepository->update($request->all(), $id);

        Flash::success('Tokens updated successfully.');

        return redirect(route('tokens.index'));
    }

    /**
     * Remove the specified Tokens from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tokens = $this->tokensRepository->find($id);

        if (empty($tokens)) {
            Flash::error('Tokens not found');

            return redirect(route('tokens.index'));
        }

        $this->tokensRepository->delete($id);

        Flash::success('Tokens deleted successfully.');

        return redirect(route('tokens.index'));
    }
}
