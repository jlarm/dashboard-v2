<?php

namespace App\Http\Controllers\Dealer\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Dealer\Vendor;

class QuestionnaireController extends Controller
{
    public function __invoke(Vendor $vendor)
    {
        return view('dealer.vendor.form', [
            'vendor' => $vendor,
        ]);
    }
}
