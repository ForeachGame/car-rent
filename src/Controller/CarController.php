<?php

namespace App\Controller;


use App\Entity\Car;
use App\Repository\CarRepository;
use App\Repository\CarTypeRepository;
use App\Repository\UserRepository;
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
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CarRepository $carRepository
     * @param CarTypeRepository $carTypeRepository
     * @param UserRepository $userReposetory
     * @return JsonResponse
     * @throws \Exception
     * @Route("/list", name="car_list", methods={"post"})
     */
    public function getCars(
        Request $request,
        EntityManagerInterface $entityManager,
        CarRepository $carRepository,
        CarTypeRepository $carTypeRepository,
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
            if($request->get('owner')) $filter['owner'] = $userRepository->find($request->get('owner'));
            if($request->get('car_type')) $filter['car_type'] = $carTypeRepository->find($request->get('car_type'));

            $data = $carRepository->findBy($filter,[$sort => $order]);

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
     * @param CarRepository $carRepository
     * @param CarTypeRepository $carTypeRepository
     * @param UserRepository $userReposetory
     * @return JsonResponse
     * @throws \Exception
     * @Route("/add", name="car_add", methods={"POST"})
    */
    public function addCar(
        Request $request,
        EntityManagerInterface $entityManager,
        CarRepository $carRepository,
        CarTypeRepository $carTypeRepository,
        UserRepository $userRepository
    )
    {
        try {
            $request = $this->transformJsonBody($request);

            if(
                !$request ||
                !$request->get('title') ||
                !$request->get('car_type') ||
                !$request->get('owner')
            ) {
                throw new \Exception();
            }

            $car = new Car();
            $car->setTitle($request->get("title"));
            $car->setCarType($carTypeRepository->find($request->get('car_type')));
            $car->setOwner($userRepository->find($request->get('owner')));
            $request->get('active')
                ? $car->setActive($request->get('active') === 'Y' ? true : false)
                : $car->setActive(true);

            $entityManager->persist($car);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Car added successfully",
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

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param CarRepository $carRepository
     * @param CarTypeRepository $carTypeRepository
     * @param UserRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     * @Route("/update/{id}", name="car_update", methods={"PUT"})
     */
    public function updateCar(
        Request $request,
        EntityManagerInterface $entityManager,
        CarRepository $carRepository,
        CarTypeRepository $carTypeRepository,
        UserRepository $userRepository,
        $id
    )
    {
        try {
            $car = $carRepository->find($id);

            if(!$car) {
                $data = [
                    "status" => 404,
                    "errors" => "Car not found",
                ];

                return $this->response($data);
            }

            $request = $this->transformJsonBody($request);

            if(
                !$request ||
                !$request->get('title') ||
                !$request->get('car_type') ||
                !$request->get('owner')
            ) {
                throw new \Exception();
            }

            $car->setTitle($request->get("title"));
            $car->setCarType($carTypeRepository->find($request->get('car_type')));
            $car->setOwner($userRepository->find($request->get('owner')));
            $request->get('active')
                ? $car->setActive($request->get('active') === 'Y' ? true : false)
                : $car->setActive(true);

            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Car update successfully",
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

    /**
     * @param CarRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     * @Route("/delete/{id}", name="car_delete", methods={"DELETE"})
     */
    public function removeCar(EntityManagerInterface $entityManager, CarRepository $carRepository, $id)
    {
        $car = $carRepository->find($id);

        if(!$car) {
            $data = [
                "status" => 404,
                "errors" => "Car not found",
            ];

            return $this->response($data);
        }

        $entityManager->remove($car);
        $entityManager->flush();

        $data = [
            'status' => 200,
            'success' => "Car delete successfully",
        ];

        return $this->response($data);
    }
}
