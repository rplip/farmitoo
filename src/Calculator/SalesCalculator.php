<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Order;
use App\Entity\Promotion;

class SalesCalculator
{
    /**
     * @param Order $order
     *
     * @return int
     */
    public function calculate(Order $order): int
    {
        $promotions = [];
        $promotions[]= new Promotion('01 august 2021', '01 september 2021', 200, 0, 1200); // réduction de 12€, applicable du 01 aout au 01 septembre 2021 pour une commande de 200€ minimum
        $promotions[]= new Promotion('', '', 0, 10, 300); //réduction de 3€, applicable dès 10 produits achetés sur le site à n'importe quel moment et sans montant minimum

        $sales = $order->getPromotionReduction();

        if (0 === $sales) { // Vérification pour ne mettre en place que la première promotion à être validée
            foreach ($promotions as $promo) {
                $start = strtotime($promo->getSaleBeginning()); // On transforme les dates de début, de fin et l'actuelle en timestamp
                $end = strtotime($promo->getSaleEnding());
                $current = strtotime('now');

                $price = $order->getPrice()/100; // On recupère le montant global de la commande

                $quantity = 0;
                foreach ($order->getItems() as $item) { // Calcul de la quantité d'articles de la commande
                    $quantity += $item->getQuantity();
                }

                if (0 === \strlen($promo->getSaleBeginning())) { //Si aucune date de début de promo n'est renseignée, la condition n'est pas bloquante
                    $start = $current-1;
                }
                if (0 === \strlen($promo->getSaleEnding())) { //Si aucune date de fin de promo n'est renseignée, la condition n'est pas bloquante
                    $end = $current+1;
                }

                if ($start < $current && $current < $end) { // Vérification des dates de la promotion
                    if ($price >= $promo->getMinAmount()) { // Vérification du montant minimum de la commande
                        if ($quantity >= $promo->getMinItems()) { // Vérification du nombre d'articles
                            $sales = $promo->getReduction()/100;
                            break;                                // On sort de la boucle afin de ne mettre en place que la 1ère promotion à être validée
                        }
                    }
                }
            }
        }

        return $sales;
    }
}
