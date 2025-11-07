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

# REST APIs
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

