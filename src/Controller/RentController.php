<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Repository\RentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RentController
 * @package App\Controller
 * @Route("/api/rent", name="rent")
 */

class RentController extends ApiController
{
    /**
     * @param  RentRepository $rentRepository
     * @return  JsonResponse
     * @Route("/list", name="rent_list", methods={"post"})
     */
    public function getRents(RentRepository $rentRepository)
    {
        $data = $rentRepository->findAll();
        return $this->response($data);
    }

    //todo Добавить аренду
    //todo Список аренд с фильтрами
}
