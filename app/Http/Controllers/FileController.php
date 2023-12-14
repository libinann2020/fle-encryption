<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');

        if ($file) {
            $encryptedContent = Crypt::encrypt(file_get_contents($file));
            Storage::put('encrypted/' . $file->getClientOriginalName(), $encryptedContent);
            return redirect()->back()->with('success', 'File uploaded and encrypted successfully!');
        }

        return redirect()->back()->with('error', 'No file found!');
    }
    // public function upload(Request $request)
    // {
    //     $file = $request->file('file');

    //     if ($file) {
    //         $originalFileName = $file->getClientOriginalName();
    //         $encryptedFileName = 'encrypted_' . Crypt::encryptString($originalFileName);

    //         $encryptedContent = Crypt::encrypt(file_get_contents($file));

    //         // Store the encrypted content with its original file name
    //         Storage::put('encrypted/' . $encryptedFileName, $encryptedContent);
    //         Storage::put('original_names/' . $encryptedFileName . '.txt', $originalFileName);

    //         return redirect()->back()->with('success', 'File uploaded and encrypted successfully!');
    //     }

    //     return redirect()->back()->with('error', 'No file found!');
    // }


    public function showFiles()
    {
        $files = Storage::files('encrypted');
        return view('list')->with('files', $files);
    }

    public function download($fileName)
    {
        $filePath = 'encrypted/' . $fileName;

        try {
            $encryptedContent = Storage::get($filePath);
            $decryptedContent = Crypt::decrypt($encryptedContent);
            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="decrypted_' . $fileName . '"',
            ];

            return response()->streamDownload(function () use ($decryptedContent) {
                echo $decryptedContent;
            }, $fileName, $headers);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'File decryption failed!');
        }
    }

    // public function download($fileName)
    // {
    //     $filePath = 'encrypted/' . $fileName;

    //     try {
    //         $encryptedContent = Storage::get($filePath);
    //         $decryptedContent = Crypt::decrypt($encryptedContent);

    //         // Get the original file name
    //         $originalFileName = Storage::get('original_names/' . $fileName . '.txt');
    //         // Storage::delete('original_names/' . $fileName . '.txt');
    //         // dd($originalFileName);

    //         $headers = [
    //             'Content-Type' => 'application/octet-stream',
    //             'Content-Disposition' => 'attachment; filename="' . $originalFileName . '"',
    //         ];

    //         return response()->streamDownload(function () use ($decryptedContent) {
    //             echo $decryptedContent;
    //         }, $originalFileName, $headers);
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'File decryption failed!');
    //     }
    // }
}
