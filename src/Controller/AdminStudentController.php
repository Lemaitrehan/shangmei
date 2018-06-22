<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Student;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\File;

class AdminStudentController extends Controller
{
    /**
     * 考生首页
     * @Route("/admin/student/index", name="admin_student_index")
     */
    public function index()
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();
        return $this->render('admin/student/index.html.twig', [
            'students' => $students
        ]);
    }

    /**
     * 添加(无用，直接导入)
     * @Route("/admin/student/create", name="admin_student_create")
     */
    public function create()
    {
        $student = new Student();

        $form = $this->createForm(StudentType::class, $student);

        return $this->render('admin/student/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * 导入考生资料
     * @Route("/admin/student/import", name="admin_student_import")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import(Request $request, EntityManagerInterface $entityManager)
    {

        if($request->isMethod('POST')) {
            $xlsx = $request->files->get('xlsx');
            $fileName = md5(uniqid()) . '.' . $xlsx->guessExtension();
            $xlsx->move(
                $this->getParameter('xlsx_directory'),
                $fileName
            );

            /** @var $file */
            $file = $filename = new File($this->getParameter('xlsx_directory').'/'.$fileName);

            /** @var $spreadsheet */
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheetData as $value) {
                $student = new Student();
                $student->setName($value[0]);
                $student->setSubject($value[1]);
                $student->setTime($value[2]);
                $student->setAddress($value[3]);
                $student->setSite($value[4]);
                $student->setRoom((int) $value[5]);
                $student->setSeat((int) $value[6]);
                $student->setNumber($value[7]);
                $entityManager->persist($student);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_student_index');
        }
        return $this->render('admin/student/import.html.twig');
    }

}