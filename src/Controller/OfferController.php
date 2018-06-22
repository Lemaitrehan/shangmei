<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\UserOffer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OfferController extends Controller
{
    /**
     * 优惠领取
     * @Route("/offer", name="offer_page")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, EntityManagerInterface $entityManager)
    {

        if ($request->isMethod('POST')) {
            $arr = [1, 2, 3, 4];

            $name = $request->get('name');
            $phone = $request->get('phone');

            $user = $this->getDoctrine()->getRepository(UserOffer::class)->findOneBy(['name' => $name, 'phone' => $phone]);

            if (!$user) {
                $userOffer = new UserOffer();
                $userOffer->setName($name);
                $userOffer->setPhone($phone);
                $userOffer->setOffer(array_rand($arr, 1));

                $entityManager->persist($userOffer);
                $entityManager->flush();

                return $this->redirectToRoute('offer_get_page', ['name' => $name, 'phone' => $phone]);
            } else {
                return new Response('<html><body><p>你已参加过该次活动，请关注 中鹏培训 公众号查询相关优惠信息</p></body></html>');
            }


        }


        return $this->render('offer/index.html.twig');
    }

    /**
     * 领取优惠之后展现的图片
     * @Route("/offer/get/{name}/{phone}", name="offer_get_page")
     * @param $name
     * @param $phone
     * @return Response
     */
    public function getOffer($name, $phone)
    {
        $array = [
            ['name' => '500元课程优惠卷', 'begin' => '2018-06-01', 'end' => '2018-07-15', 'image' => '1.jpg'],
            ['name' => '1折优惠卷设计美术课程', 'begin' => '2018-06-01', 'end' => '2018-07-15', 'image' => '2.jpg'],
            ['name' => '1折优惠卷PS软件基础课程', 'begin' => '2018-06-01', 'end' => '2018-07-15', 'image' => '3.jpg'],
            ['name' => '1折优惠卷WEB基础课程', 'begin' => '2018-06-01', 'end' => '2018-07-15', 'image' => '4.jpg']
        ];

        $user = $this->getDoctrine()->getRepository(UserOffer::class)->findOneBy(['name' => $name, 'phone' => $phone]);
        return $this->render('offer/get.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * 查询个人优惠信息
     * @Route("/offer/search/{name}/{phone}", name="offer_search_page", defaults={"name"="", "phone"=""})
     * @param $name
     * @param $phone
     * @return Response
     */
    public function search($name, $phone)
    {

        $user = $this->getDoctrine()->getRepository(UserOffer::class)->findOneBy(['name' => $name, 'phone' => $phone]);
        return $this->render('offer/search.html.twig', [
            'user' => $user
        ]);
    }
}