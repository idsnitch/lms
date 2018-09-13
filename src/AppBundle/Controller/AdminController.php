<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Entity\Borrowed;
use AppBundle\Entity\Category;
use AppBundle\Entity\HeadOfDepartment;
use AppBundle\Entity\HODTeacher;
use AppBundle\Entity\Metadata;
use AppBundle\Entity\Student;
use AppBundle\Entity\Teacher;
use AppBundle\Entity\User;
use AppBundle\Form\BookForm;
use AppBundle\Form\BorrowForm;
use AppBundle\Form\CategoryForm;
use AppBundle\Form\DeanSwapForm;
use AppBundle\Form\DeanSwapLostForm;
use AppBundle\Form\HODForm;
use AppBundle\Form\HODIssuedForm;
use AppBundle\Form\HODIssueTeacherForm;
use AppBundle\Form\HODSelectForm;
use AppBundle\Form\IssueBooksLibraryForm;
use AppBundle\Form\LibrarySelectForm;
use AppBundle\Form\MetadataForm;
use AppBundle\Form\NewBookForm;
use AppBundle\Form\NewUserForm;
use AppBundle\Form\ReturnForm;
use AppBundle\Form\SingleBookForm;
use AppBundle\Form\StudentForm;
use AppBundle\Form\TeacherForm;
use AppBundle\Form\TeacherIssueBooksForm;
use AppBundle\Form\UserForm;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @Route("/administrator")
 * @Security("is_granted('ROLE_USER')")
 *
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nrStudents = $em->getRepository("AppBundle:Student")->findNrActiveStudents();
        $nrBooks = $em->getRepository("AppBundle:Book")->findNrBooks();
        $nrBooksBorrowed = $em->getRepository("AppBundle:Borrowed")->findNrAllBorrowedBooks();
        $nrBooksReturned = $em->getRepository("AppBundle:Borrowed")->findNrReturnedBooks();
        $nrCurrentlyBorrowed = $em->getRepository("AppBundle:Borrowed")->findNrCurrentBorrowedBooks();

        $nrHodAssigned = $em->getRepository("AppBundle:Book")->nrHODAssignedBooks();
        $nrTeacherAssigned = $em->getRepository("AppBundle:Book")->nrTeacherAssignedBooks();

        // replace this example code with whatever you need
        return $this->render(':admin:dashboard.htm.twig', [
            'nrStudents' => $nrStudents,
            'nrBooks' => $nrBooks,
            'nrLostBooks' => '',
            'nrTeachers' => '',
            'nrLibrarians' => '',
            'nrBooksBorrowed' => $nrBooksBorrowed,
            'nrBooksReturned' => $nrBooksReturned,
            'nrCurrentlyBorrowed' => $nrCurrentlyBorrowed,
            'nrHodAssigned'=>$nrHodAssigned,
            'nrTeacherAssigned'=>$nrTeacherAssigned
        ]);
    }

    /**
     * @Route("/student/add",name="add-student")
     */
    public function addStudentAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $student = new Student();
        $student->setCreatedBy($user);
        $student->setUpdatedBy($user);
        $form = $this->createForm(StudentForm::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $em->persist($student);
            $em->flush();
            $this->redirectToRoute('students');
        }
        return $this->render('admin/student/add-student.htm.twig', ['form' => $form->createView(), 'studentx' => 'active']);

    }

    /**
     * @Route("/student/form",name="add-studentform")
     */
    public function addStudentFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $student = new Student();
        $student->setCreatedBy($user);
        $student->setUpdatedBy($user);
        $form = $this->createForm(StudentForm::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $em->persist($student);
            $em->flush();
            $this->redirectToRoute('students');
        }
        return $this->render('admin/student/studentForm.htm.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/students",name="students")
     */
    public function studentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Student')->findAll();
        return $this->render('admin/student/students.htm.twig', ['students' => $students, 'studentx' => 'active']);

    }

    /**
     * @Route("/teacher/add",name="add-teacher")
     */
    public function addTeacherAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $teacher = new Teacher();
        $teacher->setCreatedBy($user);
        $teacher->setUpdatedBy($user);
        $form = $this->createForm(TeacherForm::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
            $em->persist($teacher);
            $em->flush();
            $this->redirectToRoute('teachers');
        }
        return $this->render('admin/teacher/add-teacher.htm.twig', ['form' => $form->createView(), 'teacherx' => 'active']);

    }

    /**
     * @Route("/teacher/form",name="add-teacherform")
     */
    public function addTeacherFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $teacher = new Teacher();
        $teacher->setCreatedBy($user);
        $teacher->setUpdatedBy($user);
        $form = $this->createForm(TeacherForm::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $teacher = $form->getData();
            $em->persist($teacher);
            $em->flush();
            $this->redirectToRoute('students');
        }
        return $this->render('admin/teacher/teacherForm.htm.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/teachers",name="teachers")
     */
    public function teachersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teachers = $em->getRepository('AppBundle:Teacher')->findAll();
        return $this->render('admin/teacher/teachers.htm.twig', ['teachers' => $teachers, 'teacherx' => 'active']);

    }

    /**
     * @Route("/hod/add",name="add-hod")
     */
    public function addHodAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $hod = new HeadOfDepartment();
        $hod->setCreatedBy($user);
        $hod->setModifiedBy($user);
        $form = $this->createForm(HODForm::class, $hod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hod = $form->getData();
            $em->persist($hod);
            $em->flush();
            $this->redirectToRoute('hods');
        }
        return $this->render('admin/hod/add-hod.htm.twig', ['form' => $form->createView(), 'hodx' => 'active']);

    }

    /**
     * @Route("/hod/form",name="add-hodform")
     */
    public function addHodFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $hod = new HeadOfDepartment();
        $hod->setCreatedBy($user);
        $hod->setModifiedBy($user);
        $form = $this->createForm(HODForm::class, $hod);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hod = $form->getData();
            $em->persist($hod);
            $em->flush();
            $this->redirectToRoute('hods');
        }
        return $this->render('admin/hod/hodForm.htm.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/hods",name="hods")
     */
    public function hodsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $hods = $em->getRepository('AppBundle:HeadOfDepartment')->findAll();
        return $this->render('admin/hod/hods.htm.twig', ['hods' => $hods, 'hodx' => 'active']);

    }
    /**
     * @Route("/student/{id}/update",name="update-student")
     */
    public function updateStudentAction(Request $request, Student $student)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $student->setUpdatedBy($user);
        $form = $this->createForm(StudentForm::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $em->persist($student);
            $em->flush();
            $this->redirectToRoute('students');
        }
        return $this->render('admin/update-student.htm.twig', ['form' => $form->createView(), 'studentx' => 'active']);
    }
    /**
     * @Route("/category/add",name="add-category")
     */
    public function addCategoryAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('categories');
        }
        return $this->render('admin/category/add-category.htm.twig', ['form' => $form->createView(), 'categoryx' => 'active']);
    }

    /**
     * @Route("/category/form",name="add-categoryForm")
     */
    public function addCategoryFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $form = $this->createForm(CategoryForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('categories');
        }
        return $this->render('admin/category/categoryForm.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/subjects",name="categories")
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();
        return $this->render('admin/category/categories.htm.twig', ['categories' => $categories, 'categoryx' => 'active']);
    }

    /**
     * @Route("/category/{id}/update",name="update-category")
     */
    public function updateCategoryAction(Request $request, Category $category)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $form = $this->createForm(categoryForm::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
            $this->redirectToRoute('categories');
        }
        return $this->render('admin/update-category.htm.twig', ['form' => $form->createView(), 'categoryx' => 'active']);

    }
    /**
     * DEAN OF STUDIES RELATED FUNCTIONALITY
     * The Dean of Studies has 3 key Roles
     * 1. Swap Books between Students
     * 2. Transfer Books from One Student to the Other
     * 3. Replace Lost Books
     */

    /**
     * @Route("/books/dean/swap-select",name="dean-swap-select")
     */
    public function deanSelectAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(NewBookForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('dean-swap-books-step-1',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/dean:select.htm.twig',[
            'form'=>$form->createView(),
            'swapx' => 'active',
        ]);

    }

    /**
     * @Route("/books/dean/swap/1/{class}/{subject}",name="dean-swap-books-step-1")
     */
    public function deanSwapAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(DeanSwapForm::class,null,[
            'class'=>$class,
            'subject'=>$subject
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $transferFrom = $form['student1']->getData();
            $transferTo = $form['student2']->getData();
            $book = $form['book']->getData();

            $book->setStudentAssigned($transferTo);
            $em->persist($book);
            $em->flush();
            return new Response(null,200);
        }
        return $this->render(':admin/dean:select-available-book.htm.twig',[
            'form'=>$form->createView(),
            'class'=>$class,
            'subject'=>$subject,
            'swapx'=>'active'
        ]);

    }
    /**
     * @Route("/books/dean/swap-lost",name="dean-swap-lost")
     */
    public function deanSelectLostAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(NewBookForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('dean-swap-books-step-2',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/dean:select.htm.twig',[
            'form'=>$form->createView(),
            'swaplostx' => 'active',
        ]);

    }
    /**
     * @Route("/books/dean/swap/2/{class}/{subject}",name="dean-swap-books-step-2")
     */
    public function deanSwapLostAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(DeanSwapLostForm::class,null,[
            'class'=>$class,
            'subject'=>$subject
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $transferFrom = $form['student1']->getData();
            $transferTo = $form['student2']->getData();
            $metadata = $form['metadata']->getData();

            $student = $em->getRepository("AppBundle:Student")
                ->findOneBy([
                    'admissionNumber'=>$transferFrom
                ]);

            $book = $em->getRepository("AppBundle:Book")
                ->findOneBy([
                    'metadata'=>$metadata,
                    'studentAssigned'=>$student,
                    'stage'=>'Student',
                    'state'=>'Lost'
                ]);
            if ($book) {
                $book->setStudentAssigned($transferTo);
                $em->persist($book);
                $em->flush();
                return new Response(null, 200);
            }else{
                return new Response(null,404);
            }
        }
        return $this->render(':admin/dean:select-lost-book.htm.twig',[
            'form'=>$form->createView(),
            'class'=>$class,
            'subject'=>$subject,
            'swaplostx'=>'active'
        ]);

    }
    /**
     * @Route("/books/dean/select-replace",name="dean-select-replace")
     */
    public function deanSelectReplaceAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(NewBookForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('dean-lost-books',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/dean:select.htm.twig',[
            'form'=>$form->createView(),
            'replacex' => 'active',
        ]);

    }

    /**
     * @Route("/books/dean/lost/{class}/{subject}",name="dean-lost-books")
     */
    public function replaceBookAction(Request $request,$class,$subject){
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository("AppBundle:Book")
            ->findLostBooks($class,$subject);
        //var_dump($books);exit;
        return $this->render(':admin/dean:lost-books.htm.twig',[
            'books'=>$books,
            'subject'=>$subject,
            'class'=>$class,
            'replacex'=>'active'
        ]);
    }

    /**
     * @Route("/books/lost/{id}/replace",name="replace-lost-book")
     */
    public function replaceLostBookAction(Request $request,Book $book){
        $em= $this->getDoctrine()->getManager();

        $barcode= $book->getBarcode();
        $barcode = 'R'.$barcode;

        $book->setBarcode($barcode);
        $book->setStatus("Replacement");
        $book->setState("Dormant");
        $book->setStage("Library");

        $em->persist($book);
        $em->flush();

        return new Response(null,200);

    }
    /***
     * LIBRARY RELATED FUNCTIONALITY
     * The Librarian has 3 Key Tasks
     * 1. Create New Books in the system
     * 2. Issue Books to Head of Departments
     * 3. Receive Books from HOD's
     */
    /**
     * @Route("/books/library/new",name="new-library-books")
     */
    public function newLibraryBookAction(Request $request)
    {
        $form = $this->createForm(NewBookForm::class, null, ['action' => $this->generateUrl('select-metadata'),]);
        return $this->render(':admin/book:new.htm.twig', ['form' => $form->createView(), 'newbookx' => 'active']);
    }
    /**
     * @Route("/books/library/select",name="select-metadata")
     */
    public function selectMetadataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();
            $meta = $em->getRepository('AppBundle:Metadata')->findBy(['category' => $subject, 'class' => $class]);
        }
        return $this->render('admin/library/select-meta.htm.twig', ['metadata' => $meta, 'newbookx' => 'active']);

    }
    /**
     * @Route("/metadata",name="metadata")
     */
    public function metadataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();
            $meta = $em->getRepository('AppBundle:Metadata')->findBy(['category' => $subject, 'class' => $class]);
        } else {
            $meta = $em->getRepository('AppBundle:Metadata')->findAll();
        }
        return $this->render('admin/metadata/metadata.htm.twig', ['metadata' => $meta, 'metadatax' => 'active']);

    }

    /**
     * @Route("/books/library/issue",name="issue-library-books")
     */
    public function issueLibraryBookAction(Request $request)
    {
        $form = $this->createForm(NewBookForm::class);

        return $this->render(':admin/library:issueBooks.htm.twig', ['form' => $form->createView(), 'issuex' => 'active']);
    }

    /**
     * @Route("/books/library/metadata",name="library-select-book")
     */
    public function issueLibraryMetadataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();
            $meta = $em->getRepository('AppBundle:Metadata')
                ->findBy([
                'category' => $subject,
                'class' => $class
            ]);
        } else {
            $meta = $em->getRepository('AppBundle:Metadata')->findAll();
        }
        return $this->render('admin/library/metadata.htm.twig', ['metadata' => $meta, 'issuex' => 'active']);

    }

    /**
     * @Route("/books/library/{id}/issue",name="issue-book-library")
     */
    public function issueBookLibraryAction(Request $request, Metadata $metadata){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'subject'=>$metadata->getCategory(),
            ]);
        $nrAvailableBooks = $em->getRepository("AppBundle:Book")
            ->nrBooksAvailableLibrary($metadata);

        $form = $this->createForm(IssueBooksLibraryForm::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nrBooks = $form['numberOfBooks']->getData();
           //var_dump($nrBooks);exit;
            $books = $em->getRepository("AppBundle:Book")
                ->findBy([
                    'metadata'=>$metadata,
                    'status'=>'New',
                    'stage'=>'Library',
                    'state'=>'Dormant'
                ],
                    [
                        'barcode'=>'Asc'
                    ],
                    $nrBooks
                );
            //var_dump(implode(',',$books));exit;
            foreach ($books as $book){
                $book->setHodAssigned($hod);
                $book->setStage("HOD");
                $book->setState("Issued");
                $em->persist($book);
                //echo $book->getBarcode().'<br/>';
            }
           // var_dump('books');exit;
            $em->flush();
            return $this->redirectToRoute('books');
        }
       return $this->render('admin/library/issue.htm.twig', [
            'form' => $form->createView(),
            'metadata' => $metadata,
            'issuex' => 'active',
            'availableBooks'=>$nrAvailableBooks
        ]);

    }

    /**
     * @Route("/library/issued/select",name="select-issued-metadata")
     */
    public function selectIssuedMetadataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LibrarySelectForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $meta = $form['book']->getData();
            return $this->redirectToRoute('library-issued-books',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render('admin/library/select.htm.twig', [
            'form' => $form->createView(),
             'newbookx' => 'active'
        ]);

    }
    /**
     * @Route("/books/library/{id}/issued",name="library-issued-books")
     */
    public function issuedAction(Request $request,Metadata $metadata)
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'HOD',
                'state'=>'Issued',
                'metadata'=>$metadata
            ]);

        return $this->render('admin/library/issued-books.htm.twig', [
            'books'=>$books,
            'meta'=>$metadata,
            'issuedx' => 'active'
        ]);

    }
    /**
     * @Route("/books/library/returned/select",name="select-returned-metadata")
     */
    public function selectReturnedMetadataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(LibrarySelectForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $meta = $form['book']->getData();
            return $this->redirectToRoute('library-returned-books',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render('admin/library/select.htm.twig', [
            'form' => $form->createView(),
            'returnedx' => 'active'
        ]);

    }
    /**
     * @Route("/books/library/{id}/returned",name="library-returned-books")
     */
    public function returnedBooksAction(Request $request,Metadata $metadata)
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Library',
                'state'=>'Returned By HOD',
                'metadata'=>$metadata
            ]);

        return $this->render('admin/library/returned-books.htm.twig', [
            'books'=>$books,
            'meta'=>$metadata,
            'returnedx' => 'active'
        ]);

    }

    /**
     * @Route("/books/hod/select/accept",name="select-accept-meta-hod")
     */
    public function selectMetaHODAssignedAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form = $this->createForm(HODSelectForm::class,null,[
            'subject'=>$hod->getSubject()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $meta = $form['book']->getData();
            return $this->redirectToRoute('hod-books-assigned',[
                'id'=>$meta->getId()
            ]);

        }
        return $this->render(':admin/hod:hod-select.htm.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/books/hod/{id}/assigned",name="hod-books-assigned")
     */
    public function hodAllIssuedBooksAction(Request $request,Metadata $metadata){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'HOD',
                'state'=>'Issued',
                'metadata'=>$metadata,
                'hodAssigned'=>$hod
            ]);
        return $this->render(':admin/book:my-pending-hod-assigned-books.htm.twig',[
            'books'=>$books,
            'hod'=>$hod,
            'meta'=>$metadata,
            'acceptx' => 'active',
        ]);
    }
    /**
     * @Route("/books/hod/select/accepted",name="select-accepted-meta-hod")
     */
    public function selectMetaHODAcceptedAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form = $this->createForm(HODSelectForm::class,null,[
            'subject'=>$hod->getSubject()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $meta = $form['book']->getData();
            return $this->redirectToRoute('my-accepted-assigned-books-hod',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render(':admin/hod:hod-select.htm.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/books/hod/{id}/accepted",name="my-accepted-assigned-books-hod")
     */
    public function myAcceptedIssuedBooksHODAction(Request $request,Metadata $metadata){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'HOD',
                'state'=>'Accepted',
                'metadata'=>$metadata,
                'hodAssigned'=>$hod
            ]);
        return $this->render(':admin/hod:my-accepted-hod-assigned-books.htm.twig',[
            'books'=>$books,
            'hod'=>$hod,
            'meta'=>$metadata,
            'acceptedx' => 'active',
        ]);
    }

    /**
     * @Route("/books/hod/book/{id}/accept",name="accept-hod-books")
     */
    public function acceptHODAssignedAction(Request $request,Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setState("Accepted");
        $em->persist($book);
        $em->flush();
        return new Response(null,200);
    }

    /**
     * @Route("/hod/books/select",name="hod-select-book")
     */
    public function hodSelectBookAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form = $this->createForm(HODSelectForm::class,null,[
            'subject'=>$hod->getSubject()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $meta = $form['book']->getData();
            return $this->redirectToRoute('hod-issue-book',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render(':admin/hod:hod-select.htm.twig',[
            'form'=>$form->createView(),
            'issuex' => 'active',
        ]);

    }

    /**
     * @Route("/hod/books/{id}/issue",name="hod-issue-book")
     */
    public function hodIssueBooksAction(Request $request,Metadata $metadata){
        $hod = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $subject = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$hod
            ]);

        $form= $this->createForm(HODIssueTeacherForm::class,null,[
            'subject'=>$subject->getSubject(),
            'class'=>$subject->getClass()
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'HOD',
                'state'=>'Accepted',
                'hodAssigned'=>$subject,
                'metadata'=>$metadata->getId()
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()){
            $nrBooks = $form['numberOfBooks']->getData();
            $teacher = $form['teacher']->getData();

            //var_dump($nrBooks);exit;
            $books = $em->getRepository("AppBundle:Book")
                ->findBy([
                    'metadata'=>$metadata,
                    'status'=>'New',
                    'stage'=>'HOD',
                    'state'=>'Accepted',
                    'hodAssigned'=>$subject
                ],
                    [
                        'barcode'=>'Asc'
                    ],
                    $nrBooks
                );
            //var_dump(implode(',',$books));exit;
            foreach ($books as $book){
                $book->setTeacherAssigned($teacher);
                $book->setStage("Teacher");
                $book->setState("Issued");
                $em->persist($book);

                $hodTeacher = new HODTeacher();
                $hodTeacher->setTeacher($teacher);
                $hodTeacher->setBook($book);
                $hodTeacher->setTransactionType("Issue Book");
                $hodTeacher->setTransactionDate(new \DateTime());
                $em->persist($hodTeacher);
            }

            // var_dump('books');exit;
            $em->flush();

        }

        return $this->render(':admin/hod:hod-select-issue.htm.twig',[
            'form'=>$form->createView(),
            'books'=>$books,
            'metadata'=>$metadata,
            'hod'=>$hod,
            'issuex' => 'active',
        ]);
    }
    /**
     * @Route("/books/hod/teacher/{id}/accept",name="accept-book-from-teacher")
     */
    public function acceptBookFromTeacherAction(Request $request,Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setState("Received From Teacher");
        $em->persist($book);
        $em->flush();
        return new Response(null,200);
    }

    /**
     * @Route("/hod/returned/select",name="hod-select-returned-book")
     */
    public function hodSelectReturnedBookAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form = $this->createForm(HODSelectForm::class,null,[
            'subject'=>$hod->getSubject()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $meta = $form['book']->getData();
            return $this->redirectToRoute('hod-returned-books',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render(':admin/hod:hod-select.htm.twig',[
            'form'=>$form->createView(),
            'returnedx' => 'active',
        ]);

    }
    /**
     * @Route("/hod/books/{id}/returned",name="hod-returned-books")
     */
    public function hodReturnedBooksAction(Request $request,Metadata $metadata){
        $hod = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$hod
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'HOD',
                'state'=>'Returned By Teacher',
                'hodAssigned'=>$hod,
                'metadata'=>$metadata
            ]);

        return $this->render(':admin/hod:my-teacher-returned-books.htm.twig',[
            'books'=>$books,
            'meta'=>$metadata,
            'hod'=>$hod,
            'returnedx' => 'active',
        ]);
    }
    /**
     * @Route("/hod/library/return/select",name="hod-select-books-to-return")
     */
    public function hodSelectBooksToReturnAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $hod = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form = $this->createForm(HODSelectForm::class,null,[
            'subject'=>$hod->getSubject()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $meta = $form['book']->getData();
            return $this->redirectToRoute('hod-return-to-library',[
                'id'=>$meta->getId()
            ]);
        }
        return $this->render(':admin/hod:hod-select.htm.twig',[
            'form'=>$form->createView(),
            'returnedx' => 'active',
        ]);

    }

    /**
     * @Route("/hod/return/{id}/books",name="hod-return-to-library")
     */
    public function hodReturnBooksAction(Request $request,Metadata $metadata){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(ReturnForm::class);

        $em = $this->getDoctrine()->getManager();

        $teacher = $em->getRepository("AppBundle:HeadOfDepartment")
            ->findOneBy([
                'teacher'=>$user
            ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $books = $em->getRepository("AppBundle:Book")
                ->findBy([
                    'hodAssigned'=>$teacher,
                    'metadata'=>$metadata,
                    'state'=>'Received From Teacher',
                    'stage'=>'HOD'
                ]);
            foreach ($books as $book){
                $book->setStage("Library");
                $book->setState("Returned By HOD");
                $em->persist($book);
            }
            $em->flush();
            return new Response(null,200);

        }
        $availableBooks = $em->getRepository("AppBundle:Book")
            ->findBooksAvailableForReturnToLibraryHOD($teacher,$metadata);

        return $this->render(':admin/hod:returntoLibrary.htm.twig',[
            'form'=>$form->createView(),
            'teacher'=>$teacher,
            'availableBooks'=>$availableBooks,
            'metadata'=>$metadata,
            'returnedx' => 'active',
        ]);
    }

    /**
     * @Route("/books/assigned/teacher/select",name="select-pending-meta-teacher")
     */
    public function selectAssignedMetaAction(Request $request){
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('my-filtered-pending-assigned-books-teacher',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/teacher:select-accept.htm.twig',[
            'form'=>$form->createView(),
            'issuex' => 'active',
        ]);
    }
    /**
     * @Route("/books/teacher/assigned",name="my-pending-assigned-books-teacher")
     */
    public function myPendingIssuedBooksTeacherAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Teacher',
                'state'=>'Issued',
                'teacherAssigned'=>$teacher
            ]);
        return $this->render(':admin/teacher:my-pending-teacher-assigned-books.htm.twig',[
            'books'=>$books,
            'teacher'=>$teacher,
            'acceptx' => 'active',
        ]);
    }
    /**
     * @Route("/books/teacher/{class}/assigned/{subject}",name="my-filtered-pending-assigned-books-teacher")
     */
    public function myFilteredPendingBooksTeacherAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);
        $category = $em->getRepository("AppBundle:Category")
            ->findOneBy([
                'categoryName'=>$subject
            ]);
        $meta = $em->getRepository("AppBundle:Metadata")
            ->findBy([
                'class'=>$class,
                'category'=>$category
            ]);
        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Teacher',
                'state'=>'Issued',
                'metadata'=>$meta,
                'teacherAssigned'=>$teacher
            ]);
        return $this->render(':admin/teacher:my-pending-teacher-assigned-books.htm.twig',[
            'books'=>$books,
            'teacher'=>$teacher,
            'class'=>$class,
            'subject'=>$subject,
            'acceptx' => 'active',
        ]);
    }

    /**
     * @Route("/books/teacher/accepted",name="my-accepted-assigned-books-teacher")
     */
    public function myAcceptedIssuedBooksTeacherAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Teacher',
                'state'=>'Accepted',
                'teacherAssigned'=>$teacher
            ]);
        return $this->render(':admin/teacher:my-accepted-teacher-assigned-books.htm.twig',[
            'books'=>$books,
            'teacher'=>$teacher,
            'acceptedx' => 'active',
        ]);
    }

    /**
     * @Route("/books/teacher/{id}/accepted",name="accept-teacher-books")
     */
    public function acceptTeacherAssignedAction(Request $request,Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setState("Accepted");
        $em->persist($book);
        $em->flush();
        return new Response(null,200);
    }

    /**
     * @Route("/books/teacher/select",name="select-meta-teacher")
     */
    public function selectMetaAction(Request $request){
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('issue-books-teacher',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/teacher:select-book.htm.twig',[
            'form'=>$form->createView(),
            'issuex' => 'active',
        ]);
    }

    /**
     * @Route("/books/teacher/{class}/issue/{subject}",name="issue-books-teacher")
     */
    public function issueBookTeacherAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TeacherIssueBooksForm::class,null,[
            'class'=>$class,
            'subject'=>$subject,
            'teacher'=>$user
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $student= $form['student']->getData();
            $book =$form['book']->getData();

            $book->setStage("Student");
            $book->setState("Active");
            $book->setStudentAssigned($student);

            $em->persist($book);
            $em->flush();

            return new Response(null,200);
        }
        return $this->render(':admin/teacher:issueBooks.htm.twig',[
            'form'=>$form->createView(),
            'class'=>$class,
            'subject'=>$subject

        ]);

    }
    /**
     * @Route("/books/teacher/{class}/issueform/{subject}",name="issue-books-form-teacher")
     */
    public function issueBookFormTeacherAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TeacherIssueBooksForm::class,null,[
            'class'=>$class,
            'subject'=>$subject,
            'teacher'=>$user
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $student= $form['student']->getData();
            $book =$form['book']->getData();

            $book->setStage("Student");
            $book->setState("Active");
            $book->setStudentAssigned($student);

            $em->persist($book);
            $em->flush();

            return new Response(null,200);
        }
        return $this->render(':admin/teacher:issueForm.htm.twig',[
            'form'=>$form->createView(),
            'class'=>$class,
            'subject'=>$subject
        ]);

    }
    /**
     * @Route("/books/issued/teacher/select",name="select-issued-meta-teacher")
     */
    public function selectIssuedMetaAction(Request $request){
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('my-filtered-student-issued-books',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/teacher:select-accept.htm.twig',[
            'form'=>$form->createView(),
            'issuex' => 'active',
        ]);
    }
    /**
     * @Route("/books/student/{class}/issued/{subject}",name="my-filtered-student-issued-books")
     */
    public function myStudentIssuedBooksTeacherAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")
            ->findOneBy([
                'categoryName'=>$subject
            ]);
        $meta = $em->getRepository("AppBundle:Metadata")
            ->findBy([
                'class'=>$class,
                'category'=>$category
            ]);

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Student',
                'state'=>'Active',
                'metadata'=>$meta,
                'teacherAssigned'=>$teacher
            ]);
        return $this->render(':admin/teacher:my-student-issued-books.htm.twig',[
            'books'=>$books,
            'teacher'=>$teacher,
            'class'=>$class,
            'subject'=>$subject,
            'issuedx' => 'active',
        ]);
    }
    /**
     * @Route("/books/return/teacher/select",name="select-returned-meta-teacher")
     */
    public function selectReturnedMetaAction(Request $request){
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $subject = $form['subject']->getData();
            $class = $form['class']->getData();

            return $this->redirectToRoute('return-books-teacher',[
                'class'=>$class,
                'subject'=>$subject
            ]);
        }
        return $this->render(':admin/teacher:select-accept.htm.twig',[
            'form'=>$form->createView(),
            'returnedx' => 'active',
        ]);
    }
    /**
     * @Route("/books/return/{class}/teacher/{subject}",name="return-books-teacher")
     */
    public function returnBooksTeacherAction(Request $request,$class,$subject){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(ReturnForm::class);


        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("AppBundle:Category")
            ->findOneBy([
                'categoryName'=>$subject
            ]);
        $meta = $em->getRepository("AppBundle:Metadata")
            ->findBy([
                'class'=>$class,
                'category'=>$category
            ]);

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()) {
            $books = $em->getRepository("AppBundle:Book")
                ->findBy([
                    'teacherAssigned'=>$teacher,
                    'metadata'=>$meta,
                    'state'=>'Returned By Student',
                    'stage'=>'Teacher'
                ]);
            foreach ($books as $book){
                $book->setStage("HOD");
                $book->setState("Returned By Teacher");
                $em->persist($book);
            }
             $em->flush();
            return new Response(null,200);

        }
        $availableBooks = $em->getRepository("AppBundle:Book")
            ->findAvailableForReturnTeacher($teacher,$subject,$class);

        return $this->render(':admin/teacher:returntoHOD.htm.twig',[
            'form'=>$form->createView(),
            'teacher'=>$teacher,
            'availableBooks'=>$availableBooks,
            'class'=>$class,
            'subject'=>$subject,
            'returnx' => 'active',
        ]);
    }

    /**
     * @Route("/books/student/{id}/return",name="student-teacher-return")
     */
    public function acceptedStudentReturnedTeacher(Request $request, Book $book){
            $em = $this->getDoctrine()->getManager();
            $book->setStage("Teacher");
            $book->setStatus("Used");
            $book->setState("Returned By Student");
            $em->persist($book);
            $em->flush();

            return new Response(null,200);
    }
    /**
     * @Route("/books/teacher/{id}/return",name="teacher-hod-return")
     */
    public function returnBooksTeacherHODAction(Request $request, Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setStage("HOD");
        $book->setState("Returned By Teacher");
        $em->persist($book);
        $em->flush();

        return new Response(null,200);
    }
    /**
     * @Route("/books/hod/{id}/acceptreturn",name="teacher-hod-accept")
     */
    public function acceptTeacherReturnedHOD(Request $request, Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setStage("HOD");
        $book->setState("Accepted From Teacher");
        $em->persist($book);
        $em->flush();

        return new Response(null,200);
    }
    /**
     * @Route("/books/hod/{id}/return",name="hod-library-return")
     */
    public function returnLibraryHOD(Request $request, Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setStage("Library");
        $book->setState("Returned By HOD");
        $em->persist($book);
        $em->flush();

        return new Response(null,200);
    }
    /**
     * @Route("/books/librarian/{id}/acceptreturn",name="hod-librarian-accept")
     */
    public function acceptHODReturnedLibrarian(Request $request, Book $book){
        $em = $this->getDoctrine()->getManager();
        $book->setStage("Library");
        $book->setState("Dormant");
        $em->persist($book);
        $em->flush();

        return new Response(null,200);
    }
    /**
     * @Route("/books/students/returned",name="my-student-returned-books")
     */
    public function myStudentReturnedBooksTeacherAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $teacher = $em->getRepository("AppBundle:Teacher")
            ->findOneBy([
                'user'=>$user
            ]);

        $books = $em->getRepository("AppBundle:Book")
            ->findBy([
                'stage'=>'Teacher',
                'state'=>'Returned By Student',
                'teacherAssigned'=>$teacher
            ]);
        return $this->render(':admin/teacher:my-student-returned-books.htm.twig',[
            'books'=>$books,
            'teacher'=>$teacher,
            'returnedx' => 'active',
        ]);
    }
    /**
     * @Route("/numberOfBooks",name="number-of-books")
     */
    public function numberOfBooksAction(Request $request)
    {
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($request);
        return $this->render(':admin/library:numberOfBooks.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/metadata/books",name="metadata-list")
     */
    public function metadataListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(NewBookForm::class);
        $form->handleRequest($form);
        $meta = $em->getRepository('AppBundle:Metadata')->findAll();
        return $this->render('admin/metadata/metadata.htm.twig', ['metadata' => $meta, 'metadatax' => 'active']);

    }


    /**
     * @Route("/book/{id}/add-multi",name="add-multiple-books")
     */
    public function addMultipleBooksAction(Request $request, Metadata $metadata)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $year = idate('Y');
        $yearSmall = idate('y');
        $book = new Book();
        $book->setCreatedBy($user);
        $book->setModifiedBy($user);
        $book->setMetadata($metadata);
        $book->setYearPurchased($year);
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $nrBooks = $request->request->get('numberOfBooks');
            $categoryCode = $book->getMetadata()->getCategory()->getCategoryCode();
            $purchasedOn = $book->getYearPurchased();
            for ($i = 0; $i < $nrBooks; $i++) {
                $newbook = new Book();
                $newbook->setCreatedBy($book->getCreatedBy());
                $newbook->setModifiedBy($book->getModifiedBy());
                $newbook->setMetadata($book->getMetadata());
                $newbook->setRemarks($book->getRemarks());
                $newbook->setYearPurchased($book->getYearPurchased());
                $newbook->setStatus($book->getStatus());
                //Craft a Code for the Barcode
                $milliseconds = microtime(true);
                $milli = str_replace(".", "", $milliseconds);
                $key = substr($milli, 0, 13);
                //generate the actual barCode
                $barcode = $this->generateBarCode($categoryCode, $book->getMetadata()->getClass(), $yearSmall, $key);
                $newbook->setBarcode($barcode);
                $em->persist($newbook);
                usleep(2);
            }
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('admin/book/add-book.htm.twig', ['form' => $form->createView(), 'metadata' => $metadata, 'bookx' => 'active']);
    }
    /**
     * @Route("/book/{id}/add-single",name="add-single-book")
     */
    public function addSingleBookAction(Request $request, Metadata $metadata)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $year = idate('Y');
        $yearSmall = idate('y');

        $book = new Book();
        $book->setCreatedBy($user);
        $book->setModifiedBy($user);
        $book->setMetadata($metadata);
        $book->setYearPurchased($year);

        $form = $this->createForm(SingleBookForm::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $nrBooks = $request->request->get('numberOfBooks');
            $categoryCode = $book->getMetadata()->getCategory()->getCategoryCode();
            $purchasedOn = $book->getYearPurchased();
            for ($i = 0; $i < $nrBooks; $i++) {
                $newbook = new Book();
                $newbook->setCreatedBy($book->getCreatedBy());
                $newbook->setModifiedBy($book->getModifiedBy());
                $newbook->setMetadata($book->getMetadata());
                $newbook->setRemarks($book->getRemarks());
                $newbook->setYearPurchased($book->getYearPurchased());
                $newbook->setStatus($book->getStatus());
                //Craft a Code for the Barcode
                $milliseconds = microtime(true);
                $milli = str_replace(".", "", $milliseconds);
                $key = substr($milli, 0, 13);
                //generate the actual barCode
                $barcode = $this->generateBarCode($categoryCode, $book->getMetadata()->getClass(), $yearSmall, $key);
                $newbook->setBarcode($barcode);
                $em->persist($newbook);
                usleep(2);
            }
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('admin/book/add-book.htm.twig', ['form' => $form->createView(), 'metadata' => $metadata, 'bookx' => 'active']);
    }

    /**
     * @Route("/book/add",name="add-book")
     */
    public function addBookAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $book = new Book();
        $book->setCreatedBy($user);
        $book->setModifiedBy($user);
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $nrBooks = $request->request->get('numberOfBooks');
            $categoryCode = $book->getMetadata()->getCategory()->getCategoryCode();
            $purchasedOn = date_format($book->getPurchasedAt(), 'y');
            for ($i = 0; $i < $nrBooks; $i++) {
                $newbook = new Book();
                $newbook->setCreatedBy($book->getCreatedBy());
                $newbook->setModifiedBy($book->getModifiedBy());
                $newbook->setMetadata($book->getMetadata());
                $newbook->setRemarks($book->getRemarks());
                $newbook->setPurchasedAt($book->getPurchasedAt());
                $newbook->setStatus($book->getStatus());
                $barcode = $this->generateBarCode($categoryCode, $purchasedOn, $i);
                $newbook->setBarcode($barcode);
                $em->persist($newbook);
            }
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('admin/book/add-book.htm.twig', ['form' => $form->createView(), 'newbookx' => 'active']);
    }

    /**
     * @Route("/book/form",name="add-bookForm")
     */
    public function addBookFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $book = new Book();
        $book->setCreatedBy($user);
        $book->setModifiedBy($user);
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $nrBooks = $request->request->get('numberOfBooks');
            $categoryCode = $book->getMetadata()->getCategory()->getCategoryCode();
            $purchasedOn = date_format($book->getPurchasedAt(), 'y');
            for ($i = 0; $i < $nrBooks; $i++) {
                $newbook = new Book();
                $newbook->setCreatedBy($book->getCreatedBy());
                $newbook->setModifiedBy($book->getModifiedBy());
                $newbook->setMetadata($book->getMetadata());
                $newbook->setRemarks($book->getRemarks());
                $newbook->setPurchasedAt($book->getPurchasedAt());
                $newbook->setStatus($book->getStatus());
                $barcode = $this->generateBarCode($categoryCode, $purchasedOn, $i);
                $newbook->setBarcode($barcode);
                $em->persist($newbook);
            }
            $em->flush();
            return $this->redirectToRoute('books');
        }
        return $this->render('admin/book/bookForm.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/books",name="books")
     */
    public function booksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findAll();
        return $this->render('admin/book/books.htm.twig', ['books' => $books, 'title' => 'All', 'bookx' => 'active']);

    }

    /**
     * @Route("/books/new",name="new-books")
     */
    public function newBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'New']);
        return $this->render('admin/book/books.htm.twig', ['books' => $books, 'title' => 'New']);

    }

    /**
     * @Route("/books/old",name="old-books")
     */
    public function oldBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'Old']);
        return $this->render('admin/books.htm.twig', ['books' => $books, 'title' => 'Old']);

    }

    /**
     * @Route("/books/lost",name="lost-books")
     */
    public function lostBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'Lost']);
        return $this->render('admin/books.htm.twig', ['books' => $books, 'title' => 'Lost']);

    }

    /**
     * @Route("/books/damaged",name="damaged-books")
     */
    public function damagedBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'Damaged']);
        return $this->render('admin/books.htm.twig', ['books' => $books, 'title' => 'Damaged']);

    }

    /**
     * @Route("/books/replacement",name="replacement-books")
     */
    public function replacementBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'Replacement']);
        return $this->render('admin/books.htm.twig', ['books' => $books, 'title' => 'Replacement']);

    }

    /**
     * @Route("/books/hardbound",name="hardbound-books")
     */
    public function hardboundBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('AppBundle:Book')->findBy(['status' => 'Hardbound']);
        return $this->render('admin/books.htm.twig', ['books' => $books, 'title' => 'Hardbound']);

    }

    /**
     * @Route("/book/{id}/update",name="update-book")
     */
    public function updateBookAction(Request $request, Book $book)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $book->setCreatedBy($user);
        $book->setModifiedBy($user);
        $form = $this->createForm(BookForm::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $em->persist($book);
            $em->flush();
            $this->redirectToRoute('books');
        }
        return $this->render('admin/update-book.htm.twig', ['form' => $form->createView(), 'bookx' => 'active']);
    }

    /**
     * @Route("/metadata/add",name="add-metadata")
     */
    public function addMetadataAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $metadata = new Metadata();
        $metadata->setCreatedBy($user);
        $metadata->setModifiedBy($user);
        $form = $this->createForm(MetadataForm::class, $metadata);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $metadata = $form->getData();
            $em->persist($metadata);
            $em->flush();
            return $this->redirectToRoute('metadata');
        }
        return $this->render('admin/metadata/add-metadata.htm.twig', ['form' => $form->createView(), 'metadatax' => 'active']);
    }

    /**
     * @Route("/metadata/form",name="add-metadataForm")
     */
    public function addMetadataFormAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $metadata = new Metadata();
        $metadata->setCreatedBy($user);
        $metadata->setModifiedBy($user);
        $form = $this->createForm(MetadataForm::class, $metadata);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $metadata = $form->getData();
            $em->persist($metadata);
            $em->flush();
            return $this->redirectToRoute('metadata');
        }
        return $this->render('admin/metadata/metadataForm.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/metadata/{id}/update",name="update-metadata")
     */
    public function updateMetadatakAction(Request $request, Metadata $metadata)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $metadata->setCreatedBy($user);
        $metadata->setModifiedBy($user);
        $form = $this->createForm(MetadataForm::class, $metadata);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $metadata = $form->getData();
            $em->persist($metadata);
            $em->flush();
            $this->redirectToRoute('metadata');
        }
        return $this->render('admin/update-metadata.htm.twig', ['form' => $form->createView(), 'metedatax' => 'active']);
    }

    /**
     * @Route("/user/add",name="add-user")
     */
    public function addUserAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $user = new user();
        $user->setUpdatedBy($user);
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            $this->redirectToRoute('users');
        }
        return $this->render('admin/add-user.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/users",name="users")
     */
    public function usersAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->render('admin/add-user.htm.twig', ['users' => $users]);

    }

    /**
     * @Route("/book/{id}/borrow",name="borrow-book")
     */
    public function borrowBookAction(Request $request, Book $book)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $borrow = new Borrowed();
        $borrow->setReleasedBy($user);
        $form = $this->createForm(BorrowForm::class, $borrow);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $borrow = $form->getData();
            $em->persist($borrow);
            $em->flush();
            $this->redirectToRoute('borrowed-books');
        }
        return $this->render('admin/borrow-book.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/books/borrowed",name="borrowed-books")
     */
    public function borrowedBooksAction()
    {
        $em = $this->getDoctrine()->getManager();
        $borrowed = $em->getRepository('AppBundle:Borrowed')->findAll();
        return $this->render('admin/borrowed.htm.twig', ['borrowed' => $borrowed]);

    }

    /**
     * @Route("/book/{id}/return",name="return-book")
     */
    public function returnBookAction(Request $request, Borrowed $borrowed)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $borrowed->setReturnedAt(new \DateTime());
        $borrowed->setReceivedBy($user);
        $borrowed->setStatus("Returned");
        $em->persist($borrowed);
        $em->flush();
        return new Response(null, 204);
    }

    /**
     * @Route("/book/{id}/barcode",name="print-barcode")
     */
    public function printBarcodeAction(Request $request, Book $book)
    {
        return $this->render(':admin/print:barcode.htm.twig', ['book' => $book]);
    }

    /**
     * @Route("/settings",name="administration")
     */
    public function administrationAction(Request $request)
    {
        return $this->render('admin/administration/dashboard.htm.twig');
    }

    /**
     * @Route("/user/new",name="new-user")
     */
    public function newUserAction(Request $request)
    {
        $admin = $this->get('security.token_storage')->getToken()->getUser();
        $plainPassword = $this->generate_random_str(8);
        $user = new User();
        $user->setAccountCreatedBy($admin);
        $user->setUpdatedBy($admin);
        $user->setIsActive(true);
        $user->setPlainPassword($plainPassword);
        $form = $this->createForm(NewUserForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $role = $request->request->get('role');
            $userx = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($userx);
            $em->flush();
            //var_dump($user);exit;
        }
        return $this->render(':admin/user:new.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/{id}/update",name="update-user")
     */
    public function updateUserAction(Request $request, User $user)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $user->setUpdatedBy($user);
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();
            $this->redirectToRoute('users');
        }
        return $this->render('admin/update-user.htm.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/{id}/approve",name="approve-user")
     */
    public function approveUser(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user->setUpdatedBy($user);
        $user->setIsActive(true);
        $em->persist($user);
        $em->flush();
        return new Response(null, 204);

    }

    private function generateBarCode($categoryCode, $class, $date, $i)
    {
        $preBar = 'MFA';
        $midBar = time();
        $postBar = 'LMS';
        $barCode = $preBar . $categoryCode . $date . $class . $i;
        // $hash = hash('crc32',$barCode,false);
        //var_dump($barCode);exit;
        return $barCode;
    }

    private function generate_random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        if ($max < 1) {
            throw new Exception('$keyspace must be at least two characters long');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }
}
