<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Entity\ShippingCalculationByOrder;
use App\Entity\ShippingCalculationBySlice;
use App\Updater\OrderUpdater;
use App\Updater\PromoUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    /**
     * @param OrderUpdater $orderUpdater
     *
     * @return Response
     */
    public function index(OrderUpdater $orderUpdater): Response
    {
        $farmitooBrand = new Brand('Farmitoo', new ShippingCalculationByOrder(1200), 20);
        $gallagherBrand = new Brand('Gallagher', new ShippingCalculationBySlice(1400, 2), 10);

        $order = new Order();

        $product1 = new Product('Cuve à gasoil', 10000, $farmitooBrand);
        $product2 = new Product('Electrificateur de clôture', 2500, $gallagherBrand);
        $product3 = new Product('Couveuse', 6000, $gallagherBrand);

        $orderUpdater->addProduct($order, $product1, 10);
        $orderUpdater->addProduct($order, $product2, 2);
        $orderUpdater->addProduct($order, $product3, 1);

        $promotion1= new Promotion('01 august 2021', '01 september 2021', 200, 0, 1200); // réduction de 12€, applicable du 01 aout au 01 septembre 2021 pour une commande de 200€ minimum
        $promotion2= new Promotion('', '', 0, 10, 300); //réduction de 3€, applicable dès 10 produits achetés sur le site à n'importe quel moment et sans montant minimum

        $promoUpdater = new PromoUpdater;
        $promoUpdater->addPromotion($order, $promotion1);
        $promoUpdater->addPromotion($order, $promotion2);

        $quantity = 0;
        foreach ($order->getItems() as $item) {
            $quantity += $item->getQuantity();
        }
        
        return $this->render('cart.html.twig', [
            'order' => $order,
            'quantity' => $quantity,
        ]);
    }
}
