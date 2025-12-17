<?php
namespace App\Helpers;

class BlockchainHelper
{
    public static function generateHash($data, $timestamp, $previousHash)
    {
        return hash(
            'sha256',
            $data . $timestamp . ($previousHash ?? 'GENESIS')
        );
    }
}
