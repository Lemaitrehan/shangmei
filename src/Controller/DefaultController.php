<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Student;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }


    /**
     * @Route("/info", name="info_page")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function info(Request $request)
    {
        $name = $request->get('name');
        $number = $request->get('number');
        $students = $this->getDoctrine()->getRepository(Student::class)->findBy(['name' => $name, 'number' => $number]);

        return $this->render('home/info.html.twig', [
            'students' => $students
        ]);
    }
}