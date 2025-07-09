<?php

function dbconnect() {
    static $connect = null;
    if ( $connect === null ) {
        $connect = mysqli_connect( 'localhost', 'root', '', 'employees' );
        if ( !$connect ) {
            die( 'Erreur de connexion à la base de données : ' . mysqli_connect_error() );
        }
    }
    return $connect;
}

function select_dept_manager() {
    return $departement_query = mysqli_query( dbconnect(), "SELECT md.dept_no, md.dept_name, md.first_name as manager_first_name, md.last_name as manager_last_name, ne.nb_employee 
    FROM v_manage_dept md
    JOIN v_nb_emp ne ON ne.dept_no = md.dept_no" );
}

function search_dept( $dept ) {
    return $dept_query = mysqli_query( dbconnect(), "SELECT  * FROM departments WHERE detp_name = '$dept'" );
}

// function select_manager() {
//     return ;
// }

function select_dept_emp( $dept_no ) {
    return $dept_emp_query = mysqli_query( dbconnect(), "SELECT employees.* FROM employees JOIN dept_emp ON employees.emp_no = dept_emp.emp_no JOIN departments ON dept_emp.dept_no = departments.dept_no WHERE departments.dept_no = '$dept_no'" );
}

function fiche_emp( $emp_no ) {
    return $emp_info_query = mysqli_query( dbconnect(), "SELECT * FROM employees WHERE emp_no = '$emp_no'" );
}

function salaries( $emp_no ) {
    return $salaries_query = mysqli_query( dbconnect(), "SELECT * FROM salaries WHERE emp_no = '$emp_no'" );
}

function nb_employee ($dept_no){
    return $nb_employee_query = mysqli_query(dbconnect(), "SELECT v_nb_femme.dept_no,v_nb_emp.nb_employee, v_nb_femme.nb_femme, v_nb_homme.nb_homme FROM v_nb_femme JOIN v_nb_homme ON v_nb_femme.dept_no = v_nb_homme.dept_no JOIN v_nb_emp ON v_nb_emp.dept_no = v_nb_homme.dept_no WHERE v_nb_femme.dept_no = '$dept_no' ");
}
?>