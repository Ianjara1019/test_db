-- Improved employee-department view
CREATE OR REPLACE VIEW v_employee_department AS
SELECT e.*, d.dept_name, cde.dept_no, cde.to_date 
FROM employees e
JOIN current_dept_emp cde ON cde.emp_no = e.emp_no
JOIN departments d ON cde.dept_no = d.dept_no;

-- Current employees view
CREATE OR REPLACE VIEW v_current_emp AS
SELECT emp_no, first_name, last_name, dept_name, dept_no, to_date 
FROM v_employee_department 
WHERE to_date = '9999-01-01';

-- Department managers view
CREATE OR REPLACE VIEW v_manage_dept AS
SELECT dm.dept_no, d.dept_name, e.first_name, e.last_name
FROM dept_manager dm
JOIN employees e ON dm.emp_no = e.emp_no
JOIN departments d ON dm.dept_no = d.dept_no
WHERE dm.to_date = '9999-01-01';

-- Employee count by department
CREATE OR REPLACE VIEW v_nb_emp AS
SELECT dept_no, COUNT(*) as nb_employee 
FROM v_current_emp 
GROUP BY dept_no;

-- department, manager, employee count
SELECT md.dept_no, md.dept_name, md.first_name as manager_first_name,md.last_name as manager_last_name, ne.nb_employee 
FROM v_manage_dept md
JOIN v_nb_emp ne ON ne.dept_no = md.dept_no;

-- Employee count by department (homme)
CREATE OR REPLACE view v_nb_homme as
SELECT dept_no, COUNT(gender) as nb_homme FROM v_employee_department WHERE gender = 'M' GROUP by dept_no;

-- Employee count by department (femme)
CREATE OR REPLACE view v_nb_femme as
SELECT dept_no, COUNT(gender) as nb_femme FROM v_employee_department WHERE gender = 'F' GROUP by dept_no;

SELECT v_nb_femme.dept_no,v_nb_emp.nb_employee, v_nb_femme.nb_femme, v_nb_homme.nb_homme FROM v_nb_femme JOIN v_nb_homme ON v_nb_femme.dept_no = v_nb_homme.dept_no JOIN v_nb_emp ON v_nb_emp.dept_no = v_nb_homme.dept_no WHERE v_nb_femme.dept_no = 'd001'; 