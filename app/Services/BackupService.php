<?php

namespace App\Services;

use App\Repositories\BackupRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class BackupService
{
    protected $backupRepo;

    public function __construct(BackupRepository $backupRepo)
    {
        $this->backupRepo = $backupRepo;
    }

    public function getAllBackups()
    {
        return $this->backupRepo->getAll();
    }

    public function createBackup($password)
    {
        Log::info("--- PROSES BACKUP DIMULAI ---");

        // 1. Config Database
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');

        // Ambil path mysqldump
        $dumpBinaryPath = env('DB_DUMP_PATH', 'mysqldump');
        Log::info("Path awal mysqldump: " . $dumpBinaryPath);

        $fileName = 'backup-' . Carbon::now()->format('Y-m-d-H-i-s') . '.sql';

        // Buat folder temp
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $tempPath = $tempDir . '/' . $fileName;

        // --- PERBAIKAN PATH WINDOWS ---
        $fixedDumpPath = str_replace('/', '\\', $dumpBinaryPath);
        $fixedTempPath = str_replace('/', '\\', $tempPath);

        // Siapkan Password
        $passwordCmd = !empty($dbPass) ? "--password=\"{$dbPass}\"" : "";

        // --- COMMAND REVISI (Tanpa column-statistics) ---
        // Saya menghapus "--column-statistics=0" karena mysqldump Anda tidak support
        $command = "cmd /c \"\"{$fixedDumpPath}\" --user=\"{$dbUser}\" {$passwordCmd} --host=\"{$dbHost}\" --replace --no-create-info --skip-triggers --result-file=\"{$fixedTempPath}\" \"{$dbName}\"\" 2>&1";

        Log::info("Menjalankan Command: " . $command);

        $output = [];
        $resultCode = null;

        // EKSEKUSI
        exec($command, $output, $resultCode);

        // LOG HASIL
        Log::info("Result Code: " . $resultCode);

        // Cek jika gagal
        if ($resultCode !== 0) {
            $errorMsg = implode("\n", $output);
            Log::error("Backup Gagal! Output: " . $errorMsg);

            if (file_exists($tempPath)) unlink($tempPath);

            throw new Exception("Gagal Dump Database (Code $resultCode). Lihat log untuk detail.");
        }

        // Cek jika file kosong
        if (!file_exists($tempPath) || filesize($tempPath) === 0) {
            Log::error("File backup kosong (0 bytes).");
            throw new Exception("File backup tercipta tapi kosong.");
        }

        Log::info("Dump berhasil, mulai enkripsi...");

        // --- PROSES ENKRIPSI ---
        $sqlContent = file_get_contents($tempPath);

        $cipher = "AES-256-CBC";
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $encryptedContent = openssl_encrypt($sqlContent, $cipher, $password, 0, $iv);
        $finalContent = base64_encode($iv . '::' . $encryptedContent);

        $encryptedFileName = $fileName . '.enc';
        Storage::put('backups/' . $encryptedFileName, $finalContent);

        unlink($tempPath); // Hapus file sql mentah

        Log::info("Enkripsi selesai, menyimpan ke database...");

        return $this->backupRepo->create([
            'file_name' => $encryptedFileName,
            'backup_by' => Auth::id(),
            'key'       => Hash::make($password),
            'backup_at' => Carbon::now(),
        ]);
    }

    public function restoreBackup($id, $inputPassword)
    {
        Log::info("--- PROSES RESTORE DIMULAI ---");

        $backup = $this->backupRepo->find($id);

        // 1. Verifikasi Password (Hash Check)
        // Jika password salah, langsung lempar Exception agar ditangkap Controller
        if (!Hash::check($inputPassword, $backup->key)) {
            Log::warning("Percobaan restore gagal: Password salah oleh User ID " . Auth::id());
            throw new Exception("Password backup salah! Proses dibatalkan.");
        }

        // 2. Cek File Backup Fisik
        if (!Storage::exists('backups/' . $backup->file_name)) {
            throw new Exception("File backup tidak ditemukan di penyimpanan.");
        }

        Log::info("Password benar. Membaca file: " . $backup->file_name);

        // 3. Dekripsi File
        $fileContent = Storage::get('backups/' . $backup->file_name);
        $decoded = base64_decode($fileContent);

        if (strpos($decoded, '::') === false) {
            throw new Exception("Format file rusak.");
        }

        list($iv, $encryptedData) = explode('::', $decoded, 2);

        $cipher = "AES-256-CBC";
        $decryptedSql = openssl_decrypt($encryptedData, $cipher, $inputPassword, 0, $iv);

        if ($decryptedSql === false) {
            throw new Exception("Gagal mendekripsi file. Pastikan file tidak korup.");
        }

        // 4. Simpan SQL Sementara
        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $tempFileName = 'restore-' . time() . '.sql';
        $tempPath = $tempDir . '/' . $tempFileName;

        // Tambahkan perintah mematikan foreign key check
        $finalSql = "SET FOREIGN_KEY_CHECKS=0;\n" . $decryptedSql . "\nSET FOREIGN_KEY_CHECKS=1;";
        file_put_contents($tempPath, $finalSql);

        // 5. SIAPKAN COMMAND RESTORE (FIX WINDOWS)
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');
        $dbHost = env('DB_HOST');

        // Ambil path mysql.exe dari .env
        $mysqlBinaryPath = env('DB_MYSQL_PATH', 'mysql');

        // Fix Path Backslash untuk Windows
        $fixedMysqlPath = str_replace('/', '\\', $mysqlBinaryPath);
        $fixedTempPath = str_replace('/', '\\', $tempPath);

        $passwordCmd = !empty($dbPass) ? "--password=\"{$dbPass}\"" : "";

        // Command: mysql -u user -p db < file.sql
        // Bungkus dengan cmd /c agar simbol "<" terbaca di Windows
        $command = "cmd /c \"\"{$fixedMysqlPath}\" --user=\"{$dbUser}\" {$passwordCmd} --host=\"{$dbHost}\" \"{$dbName}\" < \"{$fixedTempPath}\"\" 2>&1";

        Log::info("Menjalankan Command Restore: " . $command);

        $output = [];
        $resultCode = null;
        exec($command, $output, $resultCode);

        // Hapus file temp
        if (file_exists($tempPath)) unlink($tempPath);

        if ($resultCode !== 0) {
            $errorMsg = implode("\n", $output);
            Log::error("Restore Gagal! Output: " . $errorMsg);
            throw new Exception("Gagal Restore Database (Code $resultCode). Cek Log Laravel.");
        }

        Log::info("Restore Berhasil!");
        return true;
    }

    public function deleteBackup($id)
    {
        $backup = $this->backupRepo->find($id);
        if (Storage::exists('backups/' . $backup->file_name)) {
            Storage::delete('backups/' . $backup->file_name);
        }
        return $this->backupRepo->delete($id);
    }
}
