<?php
    if(isset($_POST['students']) && !empty($_POST['students'])) {
        $students = $_POST['students'];

        $response = array(
            'students' => $students,
            'results' => ''
        );

        function getFailingMath($student) 
        {
            return ($student['math'] < 10);
        }

        function getFailingPhysics($student) 
        {
            return ($student['physics'] < 10);
        }

        function getFailingProg($student) 
        {
            return ($student['prog'] < 10);
        }

        function getPassingMath($student)
        {
            return ($student['math'] >= 10);
        }

        function getPassingPhysics($student)
        {
            return ($student['physics'] >= 10);
        }

        function getPassingProg($student)
        {
            return ($student['prog'] >= 10);
        }

        function getPassingStudents($student) {
            return ($student['math'] >= 10 && $student['physics'] >= 10 && $student['prog'] >= 10) ? true : false;
        }

        function getPassedTwo($student) {
            if(($student['math'] >= 10 && $student['physics'] >= 10 && $student['prog'] < 10) || 
            ($student['math'] < 10 && $student['physics'] >= 10 && $student['prog'] >= 10) || 
            ($student['math'] >= 10 && $student['physics'] < 10 && $student['prog'] >= 10)) return true;
            else return false;
        }

        function getPassedOne($student) {
            if(($student['math'] >= 10 && $student['physics'] < 10 && $student['prog'] < 10) ||
            ($student['math'] < 10 && $student['physics'] >= 10 && $student['prog'] < 10) ||
            ($student['math'] < 10 && $student['physics'] < 10 && $student['prog'] >= 10)) return true;
            else return false;
        }

        /* Los promedios son la suma del map() del array de estudiantes, en el que el valor de cada uno de los espacios del
        array se vuelve el de el valor del atributo math/physics/prog en esa posicion, esta escrito asi porque hacer una funcion
        por cada parametro diferente es muy ladilla */
        $avgMath = array_sum(array_map(function($student) { return $student = $student['math']; }, $students)) / count($students);
        $avgPhysics = array_sum(array_map(function($student) { return $student = $student['physics']; }, $students)) / count($students);
        $avgProg = array_sum(array_map(function($student) { return $student = $student['prog']; }, $students)) / count($students);

        // Estas variables usan los callbacks que retornan si la nota del estudiante en x materia es menor a 10
        $failingMath = count(array_filter($students, "getFailingMath"));
        $failingPhysics = count(array_filter($students, "getFailingPhysics"));
        $failingProg = count(array_filter($students, "getFailingProg"));

        // Estas variables usan los callbacks que retornan si la nota del estudiante en x materia es mayor o igual a 10
        $passingMath = count(array_filter($students, "getPassingMath"));
        $passingPhysics = count(array_filter($students, "getPassingPhysics"));
        $passingProg = count(array_filter($students, "getPassingProg"));
        $passingStudents = count(array_filter($students, "getPassingStudents"));

        // Estas funciones son horribles
        $passedTwo = count(array_filter($students, "getPassedTwo"));
        $passedOne = count(array_filter($students, "getPassedOne"));

        /* Estas variables son el resultado de la suma de todos los elementos del array map() en el que los valores de
        todos los espacios son iguales a los valores de los atributos math/physics/prog, y de esos se saca el numero mas grande
        de ese array*/  
        $mathMax = max(array_map(function($student) { return $student = $student['math']; }, $students));
        $physicsMax = max(array_map(function($student) { return $student = $student['physics']; }, $students));
        $progMax = max(array_map(function($student) { return $student = $student['prog']; }, $students));
        
        $response['results'] = "<p>Math Average: $avgMath</p>
        <p>Physics Average: $avgPhysics</p>
        <p>Programming Average: $avgProg</p>
        <p>Amount of Students that failed Math: $failingMath</p>
        <p>Amount of Students that failed Physics: $failingPhysics</p>
        <p>Amount of Students that failed Programming: $failingProg</p>
        <p>Amount of Students that passed Math: $passingMath</p>
        <p>Amount of Students that passed Physics: $passingPhysics</p>
        <p>Amount of Students that passed Programming: $passingProg</p>
        <p>Amount of Students that passed all three subjects: $passingStudents</p>
        <p>Amount of Students that passed two subjects: $passedTwo</p>
        <p>Amount of Students that passed only one subject: $passedOne</p>
        <p>Maximum score in Math: $mathMax</p>
        <p>Maximum score in Physics: $physicsMax</p>
        <p>Maximum score in Programming: $progMax</p>";

        echo json_encode($response);
    } else {
        echo "Empty values. Try again.", "<br>";
        echo '<a href="javascript:history.back()">Try again</a>';
    }
?>