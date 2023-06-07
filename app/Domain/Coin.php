<?php

namespace App\Domain;

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
     */
    public function getValueUsd(): ?float
    {
        $this->value_usd = $this->updateValueUsd();
        return $this->value_usd;
    }

    public function updateValueUsd($start,$id): ?float
    {
        $url = 'https://api.coinlore.net/api/tickers/?start='. $start .'&limit=100';
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        foreach ($data['data'] as $item) {
            if ($item['id'] === $id) {
                return $item['price_usd'];
            }
        }

        // Si no se encontró el ID en la página actual, se intenta en la siguiente
        if ($data['total'] > $start + 100) {
            return updateValueUsd($start + 101, $id);
        }

        return null; // No se encontró el ID en el JSON completo
    }
}
