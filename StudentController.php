<?php
require_once __DIR__ . '/../models/Student.php';

class StudentController {

    private $blade;

    public function __construct($blade) {
        $this->blade = $blade;
    }

    public function index() {
        $students = Student::all();
        echo $this->blade->render('students.index', compact('students'));
    }

    public function create() {
        echo $this->blade->render('students.create');
    }

    public function store() {
        Student::create($_POST['name'], $_POST['email'], $_POST['course']);
        header("Location: index.php");
    }

    public function edit($id) {
        $student = Student::find($id);
        echo $this->blade->render('students.edit', compact('student'));
    }

    public function update($id) {
        Student::update(
            $id,
            $_POST['name'],
            $_POST['email'],
            $_POST['course']
        );
        header("Location: index.php");
    }

    public function delete($id) {
        Student::delete($id);
        header("Location: index.php");
    }
}
