<?php

namespace App\Infrastructure\Persistence;

use App\Application\UserDataSource\CoinDataSource;
use App\Domain\Coin;
use Exception;

class ApiCoinDataSource implements CoinDataSource
{
    public function getById(string $coinId, float $amountUSD): ?Coin
    {
        $curl = curl_init();
        for ($start = 0; $start < 500; $start += 100) {
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.coinlore.net/api/tickers/?start=' . $start . '&limit=100',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $json = json_decode($response);

            foreach ($json->data as $cryptocoin) {
                if ($cryptocoin->id == $coinId) {
                    $coin = new Coin(
                        $coinId,
                        $cryptocoin->name,
                        $cryptocoin->symbol,
                        $amountUSD / $cryptocoin->price_usd,
                        $amountUSD
                    );
                    return ($coin);
                }
            }
        }
        curl_close($curl);
        throw new Exception('Error, moneda no existe');
    }
}
