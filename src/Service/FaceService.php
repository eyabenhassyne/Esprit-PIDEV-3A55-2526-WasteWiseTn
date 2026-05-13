<?php

namespace App\Service;

final class FaceService
{
    /**
     * Seuil classique (à ajuster). Plus bas = plus strict.
     */
    private float $threshold;

    public function __construct(float $threshold = 0.55)
    {
        $this->threshold = $threshold;
    }

    /**
     * Distance euclidienne entre deux embeddings.
     *
     * @param list<float|int|string> $a
     * @param list<float|int|string> $b
     */
    public function distance(array $a, array $b): float
    {
        $n = count($a);
        if ($n === 0 || $n !== count($b)) {
            return INF; // plus propre que 999
        }

        $sum = 0.0;

        for ($i = 0; $i < $n; $i++) {
            // cast + protection valeurs bizarres
            $da = (float) $a[$i];
            $db = (float) $b[$i];

            if (!is_finite($da) || !is_finite($db)) {
                return INF;
            }

            $diff = $da - $db;
            $sum += $diff * $diff;
        }

        return sqrt($sum);
    }

    /**
     * Vérifie si deux embeddings matchent selon le seuil.
     *
     * @param list<float|int|string> $stored
     * @param list<float|int|string> $probe
     */
    public function isMatch(array $stored, array $probe): bool
    {
        return $this->distance($stored, $probe) <= $this->threshold;
    }

    public function getThreshold(): float
    {
        return $this->threshold;
    }

    public function setThreshold(float $threshold): self
    {
        $this->threshold = $threshold;
        return $this;
    }
}