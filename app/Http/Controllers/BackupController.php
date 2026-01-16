<?php

namespace App\Http\Controllers;

use App\Services\BackupService;
use Illuminate\Http\Request;
use Exception;

class BackupController extends Controller
{
    protected $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    public function index()
    {
        $backups = $this->backupService->getAllBackups();
        return view('dashboard.backups.index', compact('backups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6',
        ]);

        try {
            // Set time limit unlimited biar ga timeout kalo db gede
            set_time_limit(0);

            $this->backupService->createBackup($request->password);

            return redirect()->back()->with('success', 'Backup berhasil dibuat!');
        } catch (Exception $e) {
            // TAMPILKAN ERROR KE LAYAR BIAR KITA TAU SEBABNYA
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function restore(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
        ]);

        try {
            $this->backupService->restoreBackup($id, $request->password);
            return redirect()->back()->with('success', 'Database berhasil di-restore (Merge/Replace).');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Restore Gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->backupService->deleteBackup($id);
            return redirect()->back()->with('success', 'File backup berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
