<?php

namespace App\Domain;

use Egulias\EmailValidator\Result\Reason\CommaInDomain;
use App\Domain\Coin;

class Wallet
{
    private int $wallet_id;
    private int $user_id;
    private array $coins;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
        $this->coins = array();
        $this->wallet_id = rand(0, 1000);
    }

    /**
     * @return Coin[]
     */
    public function getCoins(): array
    {
        return $this->coins;
    }

    public function getId(): int
    {
        return $this->wallet_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getCoin(int $coin_id): Coin
    {
        return $this->coins[$coin_id];
    }

    public function addCoin(Coin $coin): void
    {
        $this->coins[$coin->getCoinId()] = $coin;
    }

    public function deleteCoin(Coin $coin): void
    {
        unset($this->coins[$coin->getCoinId()]);
    }

    public function getTotalAmount(): float
    {
        $sum = 0;
        foreach ($this->coins as $coin) {
            $sum += $coin->getValueUsd();
        }
        return $sum;
    }
}
