<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class PDFController extends Controller
{
    
    public function pdfGeneration(){
        // Convert
        $documentations = Documentation::all();
        $pdf_view = PDF::loadView('pdf.convert', compact('documentations'));

        return $pdf_view -> download('dokumentasi.pdf');
        
    }
}
