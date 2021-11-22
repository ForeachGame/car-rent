<?php

namespace App\Controller;


use App\Entity\Car;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CarController
 * @package App\Controller
 * @Route("/api/car", name="api/car")
 */
class CarController extends ApiController
{
    /**
     * @param CarRepository $carRepository
     * @return JsonResponse
     * @Route("/list", name="/list", methods={"post"})
     */
    public function getCars(CarRepository $carRepository){
        $data = $carRepository->getCarID();
        return $this->response($data);
    }

}
