<?php

namespace App\Observers;

use App\Models\Izin;
use App\Models\BlockLedger;
use App\Helpers\BlockchainHelper;
use Carbon\Carbon;

class IzinObserver
{
    /**
     * Ketika izin pertama kali dibuat
     */
    public function created(Izin $izin): void
    {
        $this->recordLedger($izin, 'CREATE');
    }

    /**
     * Ketika izin diperbarui (misalnya status diubah)
     */
    public function updated(Izin $izin): void
    {
        $this->recordLedger($izin, 'UPDATE');
    }

    /**
     * Mencatat data ke blockchain ledger
     */
    private function recordLedger(Izin $izin, string $action): void
    {
        // Ambil blok terakhir
        $lastBlock = BlockLedger::orderBy('id', 'desc')->first();
        $previousHash = $lastBlock?->current_hash;

        // Timestamp blockchain (bukan created_at DB)
        $timestamp = Carbon::now();

        // Data yang dikunci ke blockchain
        $data = json_encode([
            'action'     => $action,
            'izin_id'    => $izin->id,
            'user_id'    => $izin->user_id,
            'tanggal'    => $izin->tanggal,
            'keterangan' => $izin->keterangan,
            'photo_path' => $izin->photo_path,
            'catatan'    => $izin->catatan,
            'status'     => $izin->status,
            'created_at' => $izin->created_at,
            'updated_at' => $izin->updated_at,
        ]);

        // 🔐 HASH = SHA256(Data + Timestamp + PreviousHash)
        $currentHash = BlockchainHelper::generateHash(
            $data,
            $timestamp,
            $previousHash
        );

        // Simpan ke ledger
        BlockLedger::create([
            'data'          => $data,
            'timestamp'     => $timestamp,
            'previous_hash' => $previousHash,
            'current_hash'  => $currentHash,
        ]);
    }
}
