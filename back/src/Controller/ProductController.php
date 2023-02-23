<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ProductController extends AbstractController {

  #[Route('/products', name: 'getProducts', methods: ['GET'])]
  public function getAllProducts(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse {
    $productList = $productRepository->findAll();
    $jsonProductList = $serializer->serialize($productList, 'json', ['groups' => 'getProducts']);
    return new JsonResponse($jsonProductList, Response::HTTP_OK, [], TRUE);
  }

  #[Route('/products/{id}', name: 'productDetail', methods: ['GET'])]
  public function getProductDetail(Product $product, SerializerInterface $serializer): JsonResponse {
    $jsonProduct = $serializer->serialize($product, 'json');
    return new JsonResponse($jsonProduct, Response::HTTP_OK, ['accept' => 'json'], TRUE);
  }

  #[Route('/products', name: "createProduct", methods: ['POST'])]
  public function createProduct(Request $request, SerializerInterface $serializer, EntityManagerInterface $em): JsonResponse {
    $jsonProduct = json_decode($request->getContent(), 1);

    $product = new Product();
    $product->setCode($jsonProduct['code']);
    $product->setName($jsonProduct['name']);
    $product->setDescription($jsonProduct['description']);
    $product->setPrice($jsonProduct['price']);
    $product->setCategory($jsonProduct['category']);
    $product->setQuantity(0);
    $product->setInventoryStatus($jsonProduct['inventoryStatus']);

    $em->persist($product);
    $em->flush();

    return new JsonResponse(NULL, Response::HTTP_NO_CONTENT);
  }

  #[Route('/products/{id}', name: "updateProduct", methods: ['PATCH'])]
  public function updateProduct(Request $request, ProductRepository $productRepository, EntityManagerInterface $em): JsonResponse {
    $jsonProduct = json_decode($request->getContent(), 1);
    $product = $productRepository->find($jsonProduct['id']);
    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id '. $jsonProduct['id']
      );
    }
    $product->setCode($jsonProduct['code']);
    $product->setName($jsonProduct['name']);
    $product->setDescription($jsonProduct['description']);
    $product->setPrice($jsonProduct['price']);
    $product->setCategory($jsonProduct['category']);
    $product->setQuantity(0);
    $product->setInventoryStatus($jsonProduct['inventoryStatus']);
    $em->flush();
    return new JsonResponse(NULL, JsonResponse::HTTP_NO_CONTENT);
  }

  #[Route('/products/{id}', name: 'deleteProduct', methods: ['DELETE'])]
  public function deleteProduct(Product $product, EntityManagerInterface $em): JsonResponse {
    $em->remove($product);
    $em->flush();

    return new JsonResponse(NULL, Response::HTTP_NO_CONTENT);
  }

  #[Route('/insertProducts', name: 'insertProducts', methods: ['GET'])]
  public function insertProductsJson(EntityManagerInterface $entityManager): Response {
    $package = new Package(new EmptyVersionStrategy());
    $path = $package->getUrl('../../front/src/assets/products.json');
    $products = file_get_contents($path);
    $jsonProducts = json_decode($products, 1);

    foreach ($jsonProducts['data'] as $jsonProduct) {
      $product = new Product();
      $product->setCode($jsonProduct['code']);
      $product->setName($jsonProduct['name']);
      $product->setDescription($jsonProduct['description']);
      $product->setImage($jsonProduct['image']);
      $product->setPrice($jsonProduct['price']);
      $product->setCategory($jsonProduct['category']);
      $product->setQuantity($jsonProduct['quantity']);
      $product->setInventoryStatus($jsonProduct['inventoryStatus']);
      $product->setRating($jsonProduct['rating']);
      $entityManager->persist($product);
    }
    $entityManager->flush();
    return new Response(NULL, Response::HTTP_NO_CONTENT);
  }

}
