---
marp: true
html: true
size: 4:3
paginate: true
style: |
  strong {
    text-shadow: 1px 1px 4px #000000;
  }
  @media print {
    strong {
      text-shadow: none !important;
      -webkit-text-stroke: 0.6px rgba(0,0,0,0.35);
      text-stroke: 0.6px rgba(0,0,0,0.35); /* ignored by many, harmless */
    }
  }
  img[alt~="center"] {
    display: block;
    margin: 0 auto;
  }
    img[alt~="outline"] {
    border: 2px solid #388bee;
  }
  .columns {
    display: flex;
    gap: 2rem;
  }
  .column {
    flex: 1;
  }
---

<!-- _class: lead -->
<!-- _class: frontpage -->
<!-- _paginate: skip -->
# The Studnet API and how it works
(NOTICE: Due to technical issues involving MYSQL, the databases and API for this project will running and stored within WSL2.)
---
# Crash Course in what PHP ,APIs, MYSQL, Security, Curl, HTML, and Javascript

# What are REST APIs
  REST APIs or Representational State Transfer Application Programming Interfaces are software archutecture style which is used in the creation of online web services.
  
  They relay on the 4 endpoint types:

  GET: which finds data from the server's database and returns the results of the found data.

  POST: which add new data to the server's database from given user inputs.

  PUT:  which updates a section of the database with updated information for the data entry from user input.

  DELETE: which removes a data entry from the server's database

  These endpoints allow interactivity between the user and server through requests and responces.
---
# What is MYSQL?
  MYSQL is an open-source database management system that that allows the creation and management of data tables and allow the running of APIs through them.
---
# What is PHP?
  PHP or Hypertext Preprocessor is a scripting langauge which allows the creation of functions, varibles, and contrants in order to make programs and web services for web servers to process and executed through PHP interpreters.
---
# How security for web services works?
For the security features that can be used include the uses of:

Sessions: which are personal save states that the server makes for the user by making a unique session id and cookies and through authentication or authorization system.

Input Validation: which are functions that validates user inputs related to their server account to determine if their a valid user through a validator function and database.

Bearer Tokens: a digital indentifier that aloow mobile users and web APIs that helps maintaining sessions when cookies aren't easily useable.
---
# What are Curl, HTML, and Javascript codes

Curl: Command line codes that allow interaction of of a web server through a command line terminal.

HTML or Hypertext Markup Language: a standard markup language that allows the creation of a visually structure web page that will be displayed on a web browser.

Javascript: Another programming language that used besides HTML and CSS that uses Node.js as a runtime system.
---
# How to run the server 

  To run the server, you will need to cd models directory
  the run the php -S localhost:8000 command in the termianl to run the server, then enter localhost:8000 into the browser to access the API.

  For the apitest.html is the same case but add apitest.html after localhost:8000/apitest.html.

---
# Project REST APIs
  The Reason for the creation of the API, The Problem it solves and the list of endpoints, and the amount of API's
---
### The Problem 

The problem of this project example is that a student guidance counsel was wanting a way to have access the a list of students that contain's the student's name, course, major, and academic year, but it must be secure for teachers and and faculty.
---
### The Reason

The reason for making this API was to provide a sercure server to provide a database for student information to help faculty make better degree plans for students,but know the student's current academic year, major, and current course their taking.
---
### The APIs and Endpoints

For the APIs, there is only one API that being the Student API under Student_API_Code that provides access to the studentsdata database and provide a secure way to access if only faculty and the admin via a user database.
---
The endpoints being used for the API are  ...

### For GET:

get_all_students(), which gets the entire contents of the student database.

get_student_by_ID(), which shows the a finding of a student based on their automaticlly assigned database ID number.

get_student_b_name(), which gets the studnet information based on their name.

get_students_by_major(), which gets students info based on the their major

get_students_by_course() which gets many students based on the course their taking.

get_students_by_year(), which finds all the students in the database based on their current academic year.
---
### For POST:

create_student(), which takes user input for the student's full name, major, course,and Academic year, and adds them to the database with their own assigned database ID number.
---
### For PUT:

update_student(), which takes user input for the database ID number they want to update and the update addtion of the student's full name, major, course or academic year.
---
### For DELETE:

delete_student($ID),
which uses a user input for the database ID number to delete an entry.

delete_all_students(), which is an admin exculsive endpoint which deletes all entries from the database.
---
# MySQL DB Usage in REST APIs

# The Databases
There databases that were made for this API were a dbusers which stores the data for usernames, passwords, and user's emails of the university faculty that will use the database.

The second is the studentsdata table which stores the full names, majors , courses, and current Academic Years of the students that faculty have taken account of, with each entry being automatically assign ID number.
---
# Database Useage for APIs
The studentsdata database is used by the main student API which relays on the php files of endpoints, EPindex, students, and index.

The dbusers database is used security section of the Student API and is relayed on by the php files of login, logoutm reigister, sessionauth, auth, change_pwd, user_dash, user_man, and update_user_profile.
---
# Security Features of the REST APIs

---
# Description for Security features for the API

The main security features being used for the Student API is hash passwords and session authorization.
---
Hash password occur whenever a new user registers a new account where it will take password value they inputted into box on regsiter.php. Then the server send their inputs though the auth.php file where it first checks the password strength by checking if the password meets requirements the runs the password string through the password_hash function where it takes the the password string and run it through the PASSWORD_DEFAULT algolthem in which hashs or encrypts the password before making it the value for the new hash_password string.
---
The session authorization centers on the sessionsauth.php checking if the user is login from the dbusers.json data file, should user not be logged in via sessionauth in the index.php, it would only provide access to the login button tothe login.php page. Here, they enter their username or password if they have made an account or can register a account.once they enter their username and password, their inputs are sent through auth.php to check if user is in the dbusers database using the jsondatabase.php file, if it finds username and the user entered the correct password then the API makes a session cookie to log and save interactions from the user and redirects them to the index.php page, if the wrong password was given it redirects the user back to the login page, gives them an error and points them for failed attempt, if 5 failed attempts were done then it timeout the user for 15 minutes. When the user logs off the the session cookie is destoryed, and user is sent to the logout.php page.
---
# The endpoints for the security system 
The endpoints used for the hash password  

From auth.php:

 validate_password_strengh, change_password, find_by_id, login, and password_hash
---
For the endpoints of session authorization; in sessionauth.php:
 
 __construct, login_user, is_logged_in, get_current user, logout, require_auth, is_guest, get_session_info, and require_guest.
---
# the REST API Examples via Curl, and HTML/Javascript

# Curl Commands
  For GET:
  Get all students:

  ![w:150pt center](./pics/curl_selectall_test&results.JPG)

  Get by Name:

  ![w:150pt center](./pics/project1/marp/pics/curl_selectname_test&results.JPG)

  Get by ID:

  ![w:150pt center](./pics/curl_selectid_test&results.JPG)

  Get by Major:

  ![w:150pt center](./pics/curl_selectmajor_test&results.JPG)

  Get by Course:

  ![w:150pt center](./pics/curl_selectcourse_test&results.JPG)

  Get by Year:

   ![w:150pt center](./pics/curl_selectyear_test&results.JPG)
---
  For POST:

  Create student:

  ![w:150pt center](./pics/curl_create_test&results.JPG)

  Login:

  ![w:150pt center](./pics/curl_login_test&results.JPG)
---
  For PUT:

  Update Student:

  ![w:150pt center](./pics/curl_update_test&results.JPG)
---
  For DELETE:

  Delete Student:

  ![w:150pt center](./pics/curl_delete_test&results.JPG)

  Delete all students:

  ![w:150pt center](./pics/curl_deleteall_test&results.JPG)
---
# HTML/Javascript

  For GET:
  
  Get all students:

  ![w:150pt center](./pics/Get_All_Students_test.JPG)

  ![w:150pt center](./pics/Get_All_Students_test_results.JPG)

  Get by Name:

  ![w:150pt center](./pics/Get_Student_By_Name_test&result.JPG)

  Get by ID:

  ![w:150pt center](./pics/Get_Student_By_ID_test&result.JPG)

  Get by Course:

  ![w:150pt center](./pics/Get_Student_By_Course_test&result.JPG)

  Get by Major:

  ![w:150pt center](./pics/Get_Student_By_Major_test&result.JPG)

  Get by Year:

  ![w:150pt center](./pics/Get_Student_By_Year_test&result.JPG)
---
  For POST:

  Login:

  ![w:150pt center](./pics/Login_in_test.JPG)

  ![w:150pt center](./pics/Login_in_test_results1.JPG)

  ![w:150pt center](./pics/Login_in_test_results2.JPG)

  Create Student:

  ![w:150pt center](./pics/Create_Student_test&result.JPG)
---
  For PUT:

  Update Student:

  ![w:150pt center](./pics/Update_Student_test&result.JPG)
---
  For DELETE:

  Delete student:

  ![w:150pt center](./pics/Delete_Student_test&result.JPG)

  Delete all student:

  ![w:150pt center](./pics/Delete_All_Students_test.JPG)
---

