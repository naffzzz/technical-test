<?php

namespace App\Http\Controllers;

use App\Applications\TransactionApplication;
use App\Infastructures\Response;
use App\Repositories\TransactionRepository;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class DownloadController extends Controller
{
    protected $transactionApplication;
    protected $transactionRepository;
    protected $response;

    public function __construct(
        TransactionApplication $transactionApplication,
        TransactionRepository $transactionRepository,
        Response $response)
    {
        $this->transactionApplication = $transactionApplication;
        $this->transactionRepository = $transactionRepository;
        $this->response = $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function downloadQrCode($transactionId)
    {
        $transaction = $this->transactionRepository->findById($transactionId);
        if ($transaction->qr_code_token != null)
        {
            $qrCode = QrCode::size(300)->generate($transaction->qr_code_token);
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('qrCodeTemplate', compact('qrCode'));
            return $pdf->download('qr_code_event.pdf');
        }
        return $this->response->errorResponse("Failed get qr code");
    }
}