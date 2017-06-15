<?php

namespace Anton\WmsBundle\Controller;


use Anton\WmsBundle\Entity\Warehouse;
use Anton\WmsBundle\Entity\WarehouseCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminController extends Controller
{
    public function productReceiptAction()
    {
        $categories = $this->getDoctrine()->getRepository(WarehouseCategory::class)->findAll();
        return $this->render('@AntonWms/product.receipt.html.twig',[
            'categories' => $categories
        ]);
    }

    public function getWarehouseByCategoryAction(WarehouseCategory $warehouseCategory)
    {
        $warehouses = $this
            ->getDoctrine()
            ->getRepository(Warehouse::class)
            ->findBy(['category' => $warehouseCategory->getId()]);
        $result = [];
        foreach ($warehouses as $warehouse){
            $result[] = [
                'id' => $warehouse->getId(),
                'name' => $warehouse->getName()
            ];
        }

        return new JsonResponse($result);
    }
}