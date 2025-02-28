<?php

namespace App\Managers\ApiBrasil\Listeners;

use App\Http\Responses\TheOneResponse;
use App\Models\OnBoarding;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\Wallet\WithdrawService;
use App\Supports\Enums\Users\UserDocumentStatus;
use App\Supports\Enums\Users\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebHookService
{
    public function __construct(private Request $request) {}

    public function run()
    {
        Log::channel('stack')->info(json_encode($this->request->all()));

        #_slack($this->request->all());

        #$request = $this->request->only('type', 'data');
        #
        #if (!isset($request['type']) || !isset($request['data'])) {
        #    TheOneResponse::ok([]);
        #}
        #
        #match ($request['type']) {
        #    #'account.waiting_documents' => $this->accountWaitingDocument($request),
        #    'account.activated' => $this->activeAccount(),
        #    'user.created' => $this->userCreated($request),
        #    default => TheOneResponse::ok([])
        #};

        return TheOneResponse::ok([]);
    }

    private function validateRequestInvoiceStatusChanged(Request $request)
    {
        //TODO webhook iugu fazer a validação com o webhook secret
        //return true;]

        $validator = Validator::make($request->all(), [
            'event' => 'required',
            'data' => 'array',
            'data.id' => 'required',
        ]);

        if ($validator->fails()) {
        }

        return true;
    }
}
