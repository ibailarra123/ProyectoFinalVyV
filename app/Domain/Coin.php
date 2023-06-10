<?php

namespace App\Domain;

use Exception;

class Coin
{
    private string $coin_id;
    private string $name;
    private string $symbol;
    private float $amount;
    private float $value_usd;


    public function __construct(string $coin_id, string $name, string $symbol, float $amount, float $value_usd)
    {
        $this->coin_id = $coin_id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->amount = $amount;
        $this->value_usd = $value_usd;
    }

    /**
     * @return float
     */
    public function getAmount(): ?float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCoinId(): ?string
    {
        return $this->coin_id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    /**
     * @return float
     * @throws Exception
     */
    public function getValueUsd(): ?float
    {
        $this->value_usd = $this->updateValueUsd(0, 99, $this->getCoinId());
        return $this->value_usd;
    }

    /**
     * @throws Exception
     */
    public function updateValueUsd($start, $end, $coinId): ?float
    {
        $url = 'https://api.coinlore.net/api/tickers/?start=' . $start . '&limit=' . $end;
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        foreach ($data['data'] as $item) {
            if ($item['id'] == $coinId) {
                return $item['price_usd'];
            }
        }

        // Si no se encontró el ID en la página actual, se intenta en la siguiente
        if ($end <= 500) {
            return $this->updateValueUsd($start + 100, $end + 100, $coinId);
        }

        throw new Exception('Moneda no encontrada');
    }
}
