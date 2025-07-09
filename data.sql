--liste de departements
create or replace view V_departements as
select employees.*, departments.dept_name from employees join dept_emp on dept_emp.emp_no = employees.emp_no join departments on departments.dept_no = dept_emp.dept_no;

--liste manager courant
create or replace view V_dept_manager_curent as
select e.first_name,e.last_name 
from employees as e join dept_emp as de
on e.emp_no = de.emp_no 
where to_date = '9999-01-01';

--liste des employees dans chaque departement
create or replace view V_employees_departements as
select employees.first_name, employees.last_name, departments.dept_name from employees join dept_emp on dept_emp.emp_no = employees.emp_no join departments on departments.dept_no = dept_emp.dept_no;

--fiche des employees
create or replace view V_employees_fiche as
select employees.first_name, employees.last_name,salaries.salary,titles.title from employees join salaries on salaries.emp_no = employees.emp_no join titles on titles.emp_no = employees.emp_no;

--nombre d'employees avec son salaire moyenne
create or replace view V_nombre_employees as
select count(employees.gender),AVG(salaries.salary) from employees join salaries on salaries.emp_no = employees.emp_no;