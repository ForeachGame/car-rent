<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserGroup;
use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route ("/api/user", name="_user")
 * */
class UserController extends ApiController
{

    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route ("/list", name="user_list", methods={"post"})
     * */
    public function getUsers(UserRepository $userRepository)
    {
        $data = $userRepository->findAll();
        return $this->response($data);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param UserGroupRepository $userGroupRepository
     * @return JsonResponse
     * @throws \Exception
     * @Route("/add", name="user_add", methods={"POST"})
     */
    public function addUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserGroupRepository $userGroupRepository
    )
    {
        try {
            $request = $this->transformJsonBody($request);

            if(
                !$request ||
                !$request->get('name') ||
                !$request->get('last_name') ||
                !$request->get('phone') ||
                !$request->get('user_group')
            ) {
                throw new \Exception();
            }

            $user = new User();
            $user->setName($request->get('name'));
            $user->setLastName($request->get('last_name'));
            $request->get('middle_name') && $user->setMiddleName($request->get('middle_name'));
            $user->setPhone($request->get('phone'));
            $user->setUserGroup($userGroupRepository->find($request->get('user_group')));

            $entityManager->persist($user);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "User added successfully",
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
     * @param UserRepository $userRepository
     * @param UserGroupRepository $userGroupRepository
     * @param $id
     * @return JsonResponse
     * @Route("/update/{id}", name="user_update", methods={"PUT"})
     */
    public function updateUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserGroupRepository $userGroupRepository,
        $id
    )
    {
        try {
            $user = $userRepository->find($id);

            if(!$user) {
                $data = [
                    "status" => 404,
                    "errors" => "User not found",
                ];

                return $this->response($data);
            }

            $request = $this->transformJsonBody($request);

            if(
                !$request ||
                !$request->get('name') ||
                !$request->get('last_name') ||
                !$request->get('phone') ||
                !$request->get('user_group')
            ) {
                throw new \Exception();
            }

            $user->setName($request->get('name'));
            $user->setLastName($request->get('last_name'));
            $request->get('middle_name') && $user->setMiddleName($request->get('middle_name'));
            $user->setPhone($request->get('phone'));
            $user->setUserGroup($userGroupRepository->find($request->get('user_group')));

            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "User update successfully",
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
     * @param UserRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @Route("/delete/{id}", name="user_delete", methods={"DELETE"})
     */
    public function removeUser(EntityManagerInterface $entityManager, UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);

        if(!$user) {
            $data = [
                "status" => 404,
                "errors" => "User not found",
            ];

            return $this->response($data);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        $data = [
            'status' => 200,
            'success' => "User delete successfully",
        ];

        return $this->response($data);
    }
}
