<?php

namespace Anton\WmsBundle\Controller;

use Anton\WmsBundle\Entity\Map;
use Anton\WmsBundle\Entity\Product;
use Anton\WmsBundle\Entity\Warehouse;
use Anton\WmsBundle\Entity\WarehouseCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function productReceiptAction()
    {
        $categories = $this->getDoctrine()->getRepository(WarehouseCategory::class)->findAll();
        return $this->render('@AntonWms/product.receipt.html.twig',[
            'categories' => $categories
        ]);
    }

    public function productShipmentAction()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->getMappedProduct();

        return $this->render('@AntonWms/product.shipment.html.twig', ['products' => $products]);
    }

    public function getWarehouseAndProductByCategoryAction(WarehouseCategory $warehouseCategory)
    {
        $warehouses = $this
            ->getDoctrine()
            ->getRepository(Warehouse::class)
            ->findBy(['category' => $warehouseCategory->getId()]);

        $result = [];
        foreach ($warehouses as $warehouse){
            $result['warehouses'][] = [
                'id' => $warehouse->getId(),
                'name' => $warehouse->getName()
            ];
        }
        $products = $warehouseCategory->getAvailableProducts();
        foreach ($products as $product){
            $result['products'][] = [
                'id' => $product->getId(),
                'name' => $product->getName() . ', ' . $product->getBarcode()
            ];
        }

        return new JsonResponse($result);
    }

    public function getWarehouseInfoAction(Warehouse $warehouse)
    {
        $freeMaps = $warehouse->getFreeMap();
        $response['freeMaps'] = [];
        foreach ($freeMaps as $freeMap) {
            $response['freeMaps'][] = [
                'id' => $freeMap->getId(),
                'name' => $freeMap->getCoordinate()
            ];
        }
        $response['html'] = $this->render('@AntonWms/warehouse.info.html.twig', ['warehouse' => $warehouse])->getContent();

        return new JsonResponse($response);
    }

    public function getProductInfoAction(Product $product)
    {
        return $this->render('@AntonWms/product.info.html.twig', ['product' => $product]);
    }

    public function addToMapAction(Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->find($request->get('productId'));
        $map = $this->getDoctrine()->getRepository(Map::class)->find($request->get('mapId'));
        try{
            $em = $this->getDoctrine()->getManager();
            $map->setProduct($product);
            $em->persist($map);
            $em->flush();
            $response['result'] = true;
        } catch (\Exception $exception) {
            $response['result'] = false;
        }

        return new JsonResponse($response);
    }

    public function removeIntoMapAction(Product $product)
    {
        try{
            $product->removeMap();
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $response['result'] = true;
        } catch (\Exception $exception) {
            $response['result'] = false;
        }

        return new JsonResponse($response);
    }
}