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

# MySQL DB Usage in REST APIs
(NOTICE: Due to technical issues involving MYSQL, the databases and API for this project will running and stored within WSL2.)
---
# The Databases
There databases that were made for this API were a dbusers which stores the data for usernames, passwords, and user's emails of the university faculty that will use the database.
---
The second is the studentsdata table which stores the full names, majors , courses, and current Academic Years of the students that faculty have taken account of, with each entry being automatically assign ID number.
---
# Database Useage for APIs
The studentsdata database is used by the main student API which relays on the php files of endpoints, EPindex, students, and index.
---
The dbusers database is used security section of the Student API and is relayed on by the php files of login, logoutm reigister, sessionauth, auth, change_pwd, user_dash, user_man, and update_user_profile.
---