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

# REST API Examples
---
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
