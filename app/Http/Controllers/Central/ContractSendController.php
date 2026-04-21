<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Domain\Central\Contracts\Actions\SendContract;
use App\Domain\Central\Contracts\Actions\SendContractPdf;
use App\Http\Controllers\Controller;
use App\Http\Requests\Central\Contract\SendContractPdfRequest;
use App\Http\Requests\Central\Contract\SendContractRequest;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class ContractSendController extends Controller
{
    public function review(SendContractRequest $request, Contract $contract, SendContract $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $action->handle($user, $contract, $request->validated('emails'));

        return back()->with('flash.success', 'Contract sent for review.');
    }

    public function pdf(SendContractPdfRequest $request, Contract $contract, SendContractPdf $action): RedirectResponse
    {
        /** @var User $user */
        $user = $request->user();

        $action->handle($user, $contract, $request->validated('email'));

        return back()->with('flash.success', 'Contract PDF sent.');
    }
}
