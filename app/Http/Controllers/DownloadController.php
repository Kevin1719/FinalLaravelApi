<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Models\Candidat;
use App\Models\Preparatoire;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


class DownloadController extends Controller
{
    public function redirect($id)
    {
        return redirect()->route('download', $id);
    }
    public function download(Request $request, $id)
    {

        $can = Candidat::findOrFail($id);
        // $file = public_path()."/".$can->selectedReleveDeNoteTerminale;
        // // return response()->json(['reponse' => $can->selectedReleveDeNoteTerminale]);
        // return response()->download($file,'relevedebacc.xlsx');
        $zip = new ZipArchive;
        $file_name = $can->prenom."".$can->nom.'.zip';
        if($zip->open(public_path($file_name), ZipArchive::CREATE) === TRUE){
            $pth = 'storage'.DIRECTORY_SEPARATOR.'dossier'.DIRECTORY_SEPARATOR.''.$can->nom."".$can->prenom;
            $files = File::files(public_path($pth));
            foreach($files as $file) {
                $relativeNameInZipFile = basename($file);
                $zip->addFile($file, $relativeNameInZipFile);
            }
            $zip->close();
        }
        $type = File::mimeType(public_path($file_name));
        $headers = ['Content-Type' => $type];

        return response()->download(public_path($file_name),$file_name,$headers);


    }
    public function dowloadBorderau(Request $request, $id)
    {
        $can = Preparatoire::findOrFail($id);
        $parts = explode('/',$can->bordereauDeDonnee);
        $chemin = implode(DIRECTORY_SEPARATOR,$parts);
        $zip = new ZipArchive;
        $file_name = $can->prenom."".$can->nom.'.zip';
        if($zip->open(public_path($file_name), ZipArchive::CREATE) === TRUE){
            $pth = 'storage'.DIRECTORY_SEPARATOR.$chemin;
            $files = File::files(public_path($pth));
            foreach($files as $file) {
                $relativeNameInZipFile = basename($file);
                $zip->addFile($file, $relativeNameInZipFile);
            }
            $zip->close();
        }
        $type = File::mimeType(public_path($file_name));
        $headers = ['Content-Type' => $type];

        return response()->download(public_path($file_name),$can->nom,$headers);
    }
}
