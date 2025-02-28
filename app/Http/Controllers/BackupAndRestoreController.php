<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupAndRestoreController extends Controller
{
    public function backup(Request $request) {

        $simpleBackup = SimpleBackup::setDatabase([
            config('database.connections.mysql.database'),
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            ])
            ->storeAfterExportTo(public_path('backups'), $request->filename . '_' . now());


        if(!$simpleBackup) {
            return response()->json([
                'status' => false,
                'message' => 'Backup Failed!'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Backup Success!'
        ], 201);
    }
}
