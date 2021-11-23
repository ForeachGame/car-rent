<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Repository\CarRepository;
use App\Repository\RentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param RentRepository $rentRepository
     * @param CarRepository $carRepository
     * @param UserRepository $userReposetory
     * @return  JsonResponse
     * @Route("/list", name="rent_list", methods={"post"})
     */
    public function getRents(
        Request $request,
        EntityManagerInterface $entityManager,
        RentRepository $rentRepository,
        CarRepository $carRepository,
        UserRepository $userRepository
    )
    {
        try {
            $request = $this->transformJsonBody($request);

            if(!$request) {
                throw new \Exception();
            }

            $sort = $request->get('sort') ?? 'id';
            $order = $request->get('order') ?? 'ASC';

            $filter = [];
            if($request->get('car')) $filter['car'] = $carRepository->find($request->get('car'));
            if($request->get('client')) $filter['client'] = $userRepository->find($request->get('client'));
            if($request->get('owner')) $filter['car'] = $carRepository->findBy(['owner'=>$request->get('owner')]);

            $data = $rentRepository->findBy($filter, [$sort => $order]);

            return $this->response($data);

        } catch (\Exception $exception) {
            $data = [
                "status"=>422,
                "errors"=>"Data not valid"
            ];

            return $this->response($data, 422);
        }
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param RentRepository $rentRepository
     * @param UserRepository $userRepository
     * @param CarRepository $carRepository
     * @return JsonResponse
     * @throws \Exception
     * @Route("/add", name="rent_add", methods={"POST"})
     */
    public function addRent(
        Request $request,
        EntityManagerInterface $entityManager,
        RentRepository $rentRepository,
        UserRepository $userRepository,
        CarRepository $carRepository
    )
    {
        try {
            $request = $this->transformJsonBody($request);

            if(
                !$request ||
                !$request->get('car') ||
                !$request->get('client') ||
                !$request->get('start_date') ||
                !$request->get('end_date')
            ) {
                throw new \Exception();
            }

            $rent = new Rent();
            $rent->setCar($carRepository->find($request->get('car')));
            $rent->setClient($userRepository->find($request->get('client')));
            $rent->setStartDate(new \DateTime($request->get('start_date')));
            $rent->setEndDate(new \DateTime($request->get('end_date')));
            $rent->setCost($rent->calcCost());

            $entityManager->persist($rent);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Rent added successfully",
            ];

            return $this->response($data);

        } catch (\Exception $exception) {
            $data = [
                "status"=>422,
                "errors"=>"Data not valid"
            ];

            return $this->response($data, 422);
        }

    }
}
