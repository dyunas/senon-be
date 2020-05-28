<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackUpController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $disk = Storage::disk('public');
    $dir = 'SenonBE';

    $files = $disk->files($dir);

    $backups = [];

    // make an array of backup files, with their filesize and creation date
    foreach ($files as $k => $f) {
      // only take the zip files into account
      if (substr($f, -4) == '.zip' && $disk->exists($f)) {
        $backups[] = [
          'file_path' => $f,
          'file_name' => str_replace($dir . '/', '', $f),
          'file_size' => $disk->size($f),
          'last_modified' => $disk->lastModified($f),
        ];
      }
    }
    // reverse the backups, so the newest one would be on top
    $backups = array_reverse($backups);

    return response()->json($backups);
  }

  /**
   * Create new databse backup.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    try {
      // start the backup process
      Artisan::call('backup:run');

      // return the results
      return response()->json(['message' => 'Backup Completed!']);
    } catch (Exception $e) {
      // Throw exception error
      return $e->getMessage();
    }
  }

  public function download_db_backup($file_name)
  {
    $file =  'SenonBE/' . $file_name;
    $disk = Storage::disk('public');
    if ($disk->exists($file)) {
      $fs = Storage::disk('public')->getDriver();
      $stream = $fs->readStream($file);

      return \Response::stream(function () use ($stream) {
        fpassthru($stream);
      }, 200, [
        "Content-Type" => $fs->getMimetype($file),
        "Content-Length" => $fs->getSize($file),
        "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
      ]);
    } else {
      abort(404, "The backup file doesn't exist.");
    }
  }

  /**
   * Restores the specified database backup in storage.
   *
   * @return \Illuminate\Http\Response
   */
  public function restore()
  {
    //
  }

  /**
   * Remove the specified database backup from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($file_name)
  {
    $disk = Storage::disk('public');

    if ($disk->exists('SenonBE/' . $file_name)) {
      $disk->delete('SenonBE/' . $file_name);
      return response()->json(['message' => 'Database backup deleted!']);
    } else {
      abort(404, "The backup file doesn't exist.");
    }
  }
}
