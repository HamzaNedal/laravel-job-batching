<?php

namespace App\Http\Controllers;

use App\Jobs\SalesCsvProcess;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SalesController extends Controller
{
    public function index()
    {
        return view('upload-file');
    }
    public function upload()
    {
        if (request()->has('file')) {
            $data = array_map('str_getcsv', file(request()->file));
            $chunks = array_chunk($data, 1000);
            $batch = Bus::batch([])->dispatch();
            $header = [];
            foreach ($chunks as $key => $chunk) {
                // $name = "/tmp$key.csv";
                // $path = resource_path("temp");
                // file_put_contents($path . $name, json_encode($chunk));
                if ($key === 0) {
                    $header = $chunk[0];
                    unset($chunk[0]);
                }
                $batch->add(new SalesCsvProcess($chunk, $header));
                // SalesCsvProcess::dispatch($chunk, $header);
            }
            return $batch;
        }

        return "Done";
    }

    public function batch($batchId)
    {
        return Bus::findBatch($batchId);
    }
    // public function store($batch)
    // {
    //     $path = resource_path("temp");
    //     $files = glob("$path/*.csv");
       
    //     foreach ($files as $key => $file) {
    //         $data = json_decode(file($file)[0]);
    //         if ($key === 0) {
    //             $header = $data[0];
    //             unset($data[0]);
    //         }
    //         SalesCsvProcess::dispatch($data, $header);
    //         unlink($file);
    //     }
    //     return "Done";
    // }
}
